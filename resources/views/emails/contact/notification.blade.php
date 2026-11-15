<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New contact message</title>
</head>
<body style="margin: 0; padding: 24px; background-color: #f4f6f5; font-family: Arial, Helvetica, sans-serif; color: #172b40;">
    <div style="max-width: 640px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
        <div style="background-color: #087d50; padding: 20px 24px; color: #ffffff;">
            <h1 style="margin: 0; font-size: 20px;">New contact message</h1>
        </div>

        <div style="padding: 24px; font-size: 14px; line-height: 1.7;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <tr>
                    <th style="text-align: left; padding: 8px 0; width: 30%; color: #64748b;">Name</th>
                    <td style="padding: 8px 0;">{{ $contactMessage->first_name }} {{ $contactMessage->last_name }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 8px 0; color: #64748b;">Email</th>
                    <td style="padding: 8px 0;"><a href="mailto:{{ $contactMessage->email }}" style="color: #087d50;">{{ $contactMessage->email }}</a></td>
                </tr>
                @if ($contactMessage->phone)
                    <tr>
                        <th style="text-align: left; padding: 8px 0; color: #64748b;">Phone</th>
                        <td style="padding: 8px 0;">{{ $contactMessage->phone }}</td>
                    </tr>
                @endif
            </table>

            <div style="margin-top: 16px; padding: 16px; background-color: #f8fafc; border-radius: 4px;">
                {!! nl2br(e($contactMessage->message)) !!}
            </div>

            <p style="margin: 20px 0 0; font-size: 12px; color: #94a3b8;">
                Received {{ $contactMessage->created_at->format('j F Y, H:i') }}
                @if ($contactMessage->ip_address) from {{ $contactMessage->ip_address }} @endif
            </p>
        </div>
    </div>
</body>
</html>
