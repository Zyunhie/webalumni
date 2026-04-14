
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>[STAI YAPPI] Lowongan {{ $lowongan->judul }} untuk Alumni {{ $alumni->prodi }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; margin: 0 auto;">
                    <tr>
                        <td style="text-align: center; padding: 20px 0;">
                            <img src="{{ asset('images/Logo.png') }}" alt="STAI YAPPI" style="max-height: 60px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #10b981; padding: 30px; border-radius: 10px 10px 0 0; color: white;">
                            <h1 style="margin: 0; font-size: 24px;">Lowongan Kerja Baru!</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: white; padding: 30px; border-radius: 0 0 10px 10px;">
                            <h2 style="color: #10b981; margin-top: 0;">Halo Alumni {{ $alumni->prodi ?? 'STAI YAPPI' }},</h2>
                            <p>Ada lowongan kerja baru yang cocok dengan prodi Anda:</p>
                            
                            <div style="background: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0;">
                                <h3 style="margin: 0 0 10px 0; color: #111827;">{{ $lowongan->judul }}</h3>
                                <p style="margin: 0 0 5px 0;"><strong>Perusahaan:</strong> {{ $lowongan->perusahaan }}</p>
                                <p style="margin: 0 0 5px 0;"><strong>Lokasi:</strong> {{ $lowongan->lokasi }}</p>
                                <p style="margin: 0 0 10px 0;"><strong>Target Prodi:</strong> {{ implode(', ', $lowongan->target_prodi ?? []) }}</p>
                            </div>
                            
                            <p style="margin: 20px 0;">Detail lebih lanjut dan cara melamar:</p>
                            <a href="{{ url('/lowongan/' . $lowongan->id) }}" style="display: inline-block; background: #10b981; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold;">Lihat Lowongan</a>
                            
                            <p style="margin: 30px 0 10px 0; font-size: 14px; color: #6b7280;">Salam hangat,<br>Tim Alumni STAI YAPPI</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

