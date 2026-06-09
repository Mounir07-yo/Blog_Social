<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    /**
     * Afficher le formulaire de demande de réinitialisation
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envoyer le lien de réinitialisation par email
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'L\'email est requis.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.exists' => 'Aucun compte n\'est associé à cette adresse email.',
        ]);

        $user = User::where('email', $request->email)->first();
        $token = Str::random(60);

        // Stocker le token de manière sécurisée
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        try {
            // Envoyer l'email avec le lien sécurisé
            Mail::to($user->email)->send(new PasswordResetMail($user, $token));
            
            return back()->with('status', 
                'Un lien de réinitialisation a été envoyé à votre adresse email. ' .
                'Vérifiez votre boîte de réception (et vos spams) dans les prochaines minutes.'
            );
            
        } catch (\Exception $e) {
            // En cas d'erreur d'envoi d'email, afficher le lien directement (pour le développement)
            if (config('app.env') === 'local' || config('app.debug') === true) {
                $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($user->email));
                
                return back()->with('dev_link', $resetUrl)
                           ->with('dev_message', 
                               'Mode développement : L\'email n\'a pas pu être envoyé. Utilisez le lien ci-dessous :'
                           );
            } else {
                return back()->withErrors(['email' => 'Erreur lors de l\'envoi de l\'email. Veuillez réessayer plus tard.']);
            }
        }
    }

    /**
     * Afficher le formulaire de réinitialisation
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Réinitialiser le mot de passe
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.required' => 'L\'email est requis.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.exists' => 'Aucun compte n\'est associé à cette adresse email.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        // Vérifier le token
        $resetRecord = \DB::table('password_reset_tokens')
                         ->where('email', $request->email)
                         ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['token' => 'Ce lien de réinitialisation est invalide ou a déjà été utilisé.']);
        }

        // Vérifier que le token n'est pas expiré (1 heure)
        $tokenCreatedAt = \Carbon\Carbon::parse($resetRecord->created_at);
        if ($tokenCreatedAt->addHour()->isPast()) {
            // Supprimer le token expiré
            \DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            
            return back()->withErrors(['token' => 'Ce lien de réinitialisation a expiré. Veuillez refaire une demande.']);
        }

        // Réinitialiser le mot de passe
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Supprimer le token utilisé
        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Envoyer un email de confirmation (optionnel)
        try {
            Mail::to($user->email)->send(new \App\Mail\PasswordChangedNotification($user));
        } catch (\Exception $e) {
            // Ignorer l'erreur d'email de confirmation
        }

        return redirect()->route('login')->with('success', 
            'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.'
        );
    }
}