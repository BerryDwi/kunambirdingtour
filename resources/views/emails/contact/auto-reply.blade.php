<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>We received your message</title>
</head>
<body style="margin: 0; padding: 24px; background-color: #f4f6f5; font-family: Arial, Helvetica, sans-serif; color: #172b40;">
    <div style="max-width: 640px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
        <div style="background-color: #087d50; padding: 20px 24px; color: #ffffff;">
            <h1 style="margin: 0; font-size: 20px;">Thank you for getting in touch</h1>
        </div>

        <div style="padding: 24px; font-size: 14px; line-height: 1.7;">
            <p style="margin-top: 0;">Dear {{ $contactMessage->first_name }},</p>

            <p>
                Thank you for contacting Birdtour Asia. Your message has been received and a member of
                our team will reply as soon as possible.
            </p>

            <p style="padding: 12px 16px; background-color: #ecfdf5; border-left: 4px solid #087d50; border-radius: 4px;">
                For your records, this is a copy of the message you sent us:
            </p>

            <div style="padding: 16px; background-color: #f8fafc; border-radius: 4px;">
                {!! nl2br(e($contactMessage->message)) !!}
            </div>

            <p style="margin-bottom: 0;">
                Kind regards,<br>
                <strong>Birdtour Asia</strong><br>
                <a href="mailto:{{ \App\Models\Setting::officeEmail() }}" style="color: #087d50;">{{ \App\Models\Setting::officeEmail() }}</a>
            </p>
        </div>
    </div>
</body>
</html>
