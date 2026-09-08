<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pesan Kontak Baru TVIP</title>
</head>
<body style="font-family: Inter, Arial, sans-serif; color: #101828; line-height: 1.6;">
    <h1 style="color: #0f4c81;">Pesan Kontak Baru</h1>
    <p>Pesan baru dikirim melalui website TVIP.</p>

    <table cellpadding="8" cellspacing="0" border="0" style="border-collapse: collapse; width: 100%; max-width: 680px;">
        <tr><td><strong>Nama</strong></td><td>{{ $contactMessage->name }}</td></tr>
        <tr><td><strong>Perusahaan</strong></td><td>{{ $contactMessage->company ?: '-' }}</td></tr>
        <tr><td><strong>Email</strong></td><td>{{ $contactMessage->email }}</td></tr>
        <tr><td><strong>Telepon</strong></td><td>{{ $contactMessage->phone ?: '-' }}</td></tr>
        <tr><td><strong>Subjek</strong></td><td>{{ $contactMessage->subject }}</td></tr>
        <tr><td valign="top"><strong>Pesan</strong></td><td>{!! nl2br(e($contactMessage->message)) !!}</td></tr>
        <tr><td><strong>Waktu</strong></td><td>{{ $contactMessage->created_at?->format('d M Y H:i') }}</td></tr>
    </table>
</body>
</html>
