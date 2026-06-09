<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\ReportNotification;
use App\Notifications\UserReportedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:post,comment',
            'id' => 'required|integer',
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Vérifier que l'élément existe
        if ($request->type === 'post') {
            $item = Post::findOrFail($request->id);
        } else {
            $item = Comment::findOrFail($request->id);
        }

        // Vérifier si l'utilisateur n'a pas déjà signalé cet élément
        $existingReport = Report::where('user_id', Auth::id())
            ->where('reportable_type', get_class($item))
            ->where('reportable_id', $item->id)
            ->first();

        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà signalé cet élément.',
            ], 422);
        }

        // Créer le signalement
        $report = Report::create([
            'user_id' => Auth::id(),
            'reportable_type' => get_class($item),
            'reportable_id' => $item->id,
            'reason' => $request->reason,
            'description' => $request->description,
        ]);

        // Notifier tous les administrateurs
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            $admin->notify(new ReportNotification($report, Auth::user(), $item));
        }

        // Notifier l'utilisateur signalé (si ce n'est pas lui-même)
        $reportedUser = $item->user;
        if ($reportedUser->id !== Auth::id()) {
            $reportedUser->notify(new UserReportedNotification($report, Auth::user(), $item));
        }

        return response()->json([
            'success' => true,
            'message' => 'Signalement envoyé avec succès. Nos équipes vont l\'examiner.'
        ]);
    }

    public function index(Request $request)
    {
        // Seuls les admins peuvent voir les signalements
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $status = $request->get('status', 'pending');
        
        $reports = Report::with(['user', 'reportable', 'reviewer'])
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.reports.index', compact('reports', 'status'));
    }

    public function show(Report $report)
    {
        // Seuls les admins peuvent voir les détails des signalements
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $report->load(['user', 'reportable.user', 'reviewer']);

        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        // Seuls les admins peuvent mettre à jour les signalements
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'status' => 'required|in:reviewed,resolved,dismissed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Signalement mis à jour avec succès.');
    }

    public function deleteReportedUser(Report $report)
    {
        // Seuls les admins peuvent supprimer des utilisateurs
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $reportedContent = $report->reportable;
        $reportedUser = $reportedContent->user;

        // Empêcher la suppression d'un admin
        if ($reportedUser->isAdmin()) {
            return back()->with('error', 'Impossible de supprimer un compte administrateur.');
        }

        // Empêcher l'auto-suppression
        if ($reportedUser->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $userName = $reportedUser->name;
        
        // Marquer le signalement comme résolu
        $report->update([
            'status' => 'resolved',
            'admin_notes' => "Utilisateur {$userName} supprimé par l'administrateur " . Auth::user()->name,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        // Supprimer l'utilisateur
        $reportedUser->delete();

        return back()->with('success', "L'utilisateur {$userName} a été supprimé avec succès.");
    }
}