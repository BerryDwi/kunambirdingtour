<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>We received your booking inquiry</title>
</head>
<body style="margin: 0; padding: 24px; background-color: #f4f6f5; font-family: Arial, Helvetica, sans-serif; color: #172b40;">
    <div style="max-width: 640px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
        <div style="background-color: #087d50; padding: 20px 24px; color: #ffffff;">
            <h1 style="margin: 0; font-size: 20px;">Thank you for your booking inquiry</h1>
        </div>

        <div style="padding: 24px; font-size: 14px; line-height: 1.7;">
            <p style="margin-top: 0;">Dear {{ $booking->full_name }},</p>

            <p>
                Thank you for contacting Birdtour Asia. We have received your inquiry for
                <strong>{{ $booking->tour_name }}</strong>@if ($booking->tour_year) ({{ $booking->tour_year }})@endif
                and our team will verify availability before following up within 24&ndash;48 hours.
            </p>

            <p style="padding: 12px 16px; background-color: #ecfdf5; border-left: 4px solid #087d50; border-radius: 4px;">
                Your reference code is <strong>{{ $booking->reference_code }}</strong>.
            </p>

            <table style="width: 100%; border-collapse: collapse; font-size: 14px; margin: 16px 0;">
                <tr>
                    <th style="text-align: left; padding: 6px 0; width: 38%; color: #64748b;">Tour type</th>
                    <td style="padding: 6px 0;">{{ $booking->tour_type->label() }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 6px 0; color: #64748b;">Travellers</th>
                    <td style="padding: 6px 0;">{{ $booking->participants_count }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 6px 0; color: #64748b;">Room preference</th>
                    <td style="padding: 6px 0;">{{ $booking->room_preference->label() }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 6px 0; color: #64748b;">Payment currency</th>
                    <td style="padding: 6px 0;">{{ $booking->currency->label() }}</td>
                </tr>
            </table>

            <p>
                If you need to add anything to your inquiry, simply reply to this email and quote your
                reference code so we can match it to your booking.
            </p>

            <p style="margin-bottom: 0;">
                Kind regards,<br>
                <strong>Birdtour Asia</strong><br>
                <a href="mailto:{{ \App\Models\Setting::officeEmail() }}" style="color: #087d50;">{{ \App\Models\Setting::officeEmail() }}</a>
            </p>
        </div>
    </div>
</body>
</html>
