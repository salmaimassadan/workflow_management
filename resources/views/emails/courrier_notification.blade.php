<!DOCTYPE html>
<html>
<head>
    <title>Notification de Courrier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            font-size: 24px;
            color: #333333;
        }
        p {
            font-size: 16px;
            color: #555555;
        }
        strong {
            color: #333333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nouvelle Notification de Courrier</h1>
        
        <p><strong>Référence:</strong> {{ $reference }}</p>
        <p><strong>Type:</strong> {{ $type }}</p>
        <p><strong>Sujet:</strong> {{ $subject }}</p>
        <p><strong>Contenu:</strong> {{ $content }}</p>
        <p><strong>Statut:</strong> {{ $status }}</p>
        <p><strong>Expéditeur:</strong> {{ $sender }}</p>
        <p><strong>Destinataire:</strong> {{ $recipient }}</p>
        
        <p>Merci de traiter ce courrier dès que possible.</p>
    </div>
</body>
</html>
