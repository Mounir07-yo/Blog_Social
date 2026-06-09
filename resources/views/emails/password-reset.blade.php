<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe - AREX</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #666;
            font-size: 14px;
        }
        .security-tips {
            background-color: #e8f5e8;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔐 Réinitialisation de mot de passe</h1>
        <p>{{ $appName }}</p>
    </div>
    
    <div class="content">
        <h2>Bonjour {{ $user->name }},</h2>
        
        <p>Vous avez demandé la réinitialisation de votre mot de passe pour votre compte sur <strong>{{ $appName }}</strong>.</p>
        
        <p>Pour créer un nouveau mot de passe, cliquez sur le bouton ci-dessous :</p>
        
        <div style="text-align: center;">
            <a href="{{ $resetUrl }}" class="button">
                Réinitialiser mon mot de passe
            </a>
        </div>
        
        <p>Ou copiez et collez ce lien dans votre navigateur :</p>
        <p style="word-break: break-all; background-color: #e9ecef; padding: 10px; border-radius: 5px;">
            {{ $resetUrl }}
        </p>
        
        <div class="warning">
            <h3>⚠️ Important :</h3>
            <ul>
                <li>Ce lien est valide pendant <strong>1 heure seulement</strong></li>
                <li>Il ne peut être utilisé qu'<strong>une seule fois</strong></li>
                <li>Si vous n'avez pas demandé cette réinitialisation, ignorez cet email</li>
                <li>Votre mot de passe actuel reste inchangé jusqu'à ce que vous en créiez un nouveau</li>
            </ul>
        </div>
        
        <div class="security-tips">
            <h3>💡 Conseils de sécurité :</h3>
            <ul>
                <li>Utilisez un mot de passe unique pour ce compte</li>
                <li>Mélangez lettres majuscules, minuscules, chiffres et symboles</li>
                <li>Évitez les informations personnelles facilement devinables</li>
                <li>Considérez l'utilisation d'un gestionnaire de mots de passe</li>
            </ul>
        </div>
        
        <p>Si vous avez des questions ou des problèmes, n'hésitez pas à nous contacter.</p>
        
        <p>Cordialement,<br>
        L'équipe {{ $appName }}</p>
    </div>
    
    <div class="footer">
        <p>Cet email a été envoyé à {{ $user->email }} suite à une demande de réinitialisation de mot de passe.</p>
        <p>Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet email en toute sécurité.</p>
        <hr>
        <p>{{ $appName }} - Votre blog social sécurisé</p>
    </div>
</body>
</html>