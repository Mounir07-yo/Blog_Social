<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe modifié</title>
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
            background-color: #28a745;
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
        .success {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ Mot de passe modifié</h1>
        <p>{{ $appName }}</p>
    </div>
    
    <div class="content">
        <h2>Bonjour {{ $user->name }},</h2>
        
        <div class="success">
            <h3>🎉 Votre mot de passe a été modifié avec succès !</h3>
            <p><strong>Date et heure :</strong> {{ now()->setTimezone('Europe/Paris')->format('d/m/Y à H:i') }}</p>
        </div>
        
        <p>Ce message confirme que le mot de passe de votre compte <strong>{{ $appName }}</strong> a été modifié avec succès.</p>
        
        <p>Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.</p>
        
        <div class="warning">
            <h3>⚠️ Ce n'était pas vous ?</h3>
            <p>Si vous n'avez pas modifié votre mot de passe, votre compte pourrait être compromis. Dans ce cas :</p>
            <ul>
                <li>Connectez-vous immédiatement et changez votre mot de passe</li>
                <li>Vérifiez vos paramètres de sécurité</li>
                <li>Contactez-nous si vous avez besoin d'aide</li>
            </ul>
        </div>
        
        <p>Pour votre sécurité, nous vous recommandons de :</p>
        <ul>
            <li>Garder votre mot de passe confidentiel</li>
            <li>Ne jamais le partager avec d'autres personnes</li>
            <li>Utiliser un mot de passe unique pour chaque service</li>
            <li>Vous déconnecter des appareils partagés</li>
        </ul>
        
        <p>Merci de votre confiance !</p>
        
        <p>Cordialement,<br>
        L'équipe {{ $appName }}</p>
    </div>
    
    <div class="footer">
        <p>Cet email de confirmation a été envoyé à {{ $user->email }}.</p>
        <hr>
        <p>{{ $appName }} - Votre blog social sécurisé</p>
    </div>
</body>
</html>