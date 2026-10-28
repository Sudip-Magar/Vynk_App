<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>Your Vynk verification code</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6; -webkit-text-size-adjust:100%;">

    {{-- preview text shown next to the subject in the inbox --}}
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:transparent;">
        Your code is {{ $otp }}. It expires in {{ $minutes }} minutes.
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f3f4f6;">
        <tr>
            <td align="center" style="padding:32px 16px;">

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width:480px; background-color:#ffffff; border:1px solid #e5e7eb; border-radius:16px;">

                    {{-- brand --}}
                    <tr>
                        <td align="center" style="padding:32px 32px 0 32px;">
                            <span style="font-family:Georgia, 'Times New Roman', serif; font-size:30px; font-weight:bold; font-style:italic; color:#059669;">
                                Vynk
                            </span>
                        </td>
                    </tr>

                    {{-- heading --}}
                    <tr>
                        <td align="center" style="padding:24px 32px 0 32px; font-family:'Segoe UI', Arial, Helvetica, sans-serif;">
                            <h1 style="margin:0; font-size:22px; line-height:28px; font-weight:700; color:#111827;">
                                Verify your email
                            </h1>
                            <p style="margin:12px 0 0 0; font-size:15px; line-height:24px; color:#4b5563;">
                                Enter this code on Vynk to continue. It expires in
                                <strong style="color:#111827;">{{ $minutes }} minutes</strong>.
                            </p>
                        </td>
                    </tr>

                    {{-- the code --}}
                    <tr>
                        <td align="center" style="padding:24px 32px 0 32px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td align="center"
                                        style="background-color:#ecfdf5; border:1px dashed #6ee7b7; border-radius:12px; padding:18px 8px;">
                                        <span style="font-family:'Courier New', Courier, monospace; font-size:38px; line-height:44px; font-weight:bold; letter-spacing:10px; color:#065f46; padding-left:10px;">{{ $otp }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- safety note --}}
                    <tr>
                        <td align="center" style="padding:24px 32px 0 32px; font-family:'Segoe UI', Arial, Helvetica, sans-serif;">
                            <p style="margin:0; font-size:13px; line-height:20px; color:#6b7280;">
                                Never share this code with anyone. Vynk will never ask you for it.
                            </p>
                        </td>
                    </tr>

                    {{-- divider --}}
                    <tr>
                        <td style="padding:28px 32px 0 32px;">
                            <div style="border-top:1px solid #e5e7eb; font-size:0; line-height:0;">&nbsp;</div>
                        </td>
                    </tr>

                    {{-- footer --}}
                    <tr>
                        <td align="center" style="padding:16px 32px 32px 32px; font-family:'Segoe UI', Arial, Helvetica, sans-serif;">
                            <p style="margin:0; font-size:12px; line-height:18px; color:#9ca3af;">
                                Didn't request this? You can safely ignore this email.<br>
                                &copy; {{ date('Y') }} Vynk
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>
