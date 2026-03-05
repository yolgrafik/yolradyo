<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1a1a2e; color: #fff; padding: 15px; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fa; padding: 20px; border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 8px 8px; }
        .message-box { background: #fff; padding: 15px; border-radius: 8px; border-left: 4px solid #c92a2a; margin-top: 15px; }
        .meta { font-size: 0.9rem; color: #6c757d; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <strong>{{ $programci->ad }}</strong> için yeni iletişim mesajı
        </div>
        <div class="content">
            <p><strong>Gönderen:</strong> {{ $senderName }} &lt;{{ $senderEmail }}&gt;</p>
            <div class="message-box">
                {{ $messageBody }}
            </div>
            <p class="meta">Bu mesaj {{ config('app.name') }} web sitesindeki programcı iletişim formundan gönderildi.</p>
        </div>
    </div>
</body>
</html>
