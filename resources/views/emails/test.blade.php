<!DOCTYPE html>
<html>
<head>
    <title>Email Generasi Juara</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #2d3748;">{{ $greeting }}</h1>
        <p style="font-size: 16px;">{{ $content }}</p>

        @isset($user)
        <div style="margin-top: 20px; padding: 15px; background: #f7fafc;">
            <p style="font-weight: bold;">Detail akun:</p>
            <ul style="list-style: none; padding: 0;">
                <li>Nama: {{ $user->name }}</li>
                <li>Email: {{ $user->email }}</li>
            </ul>
        </div>
        @endisset

        <footer style="margin-top: 30px; font-size: 14px; color: #718096;">
            © {{ date('Y') }} Generasi Juara. All rights reserved.
        </footer>
    </div>
</body>
</html>