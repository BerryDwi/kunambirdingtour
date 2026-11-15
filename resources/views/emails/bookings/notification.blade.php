<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New booking inquiry</title>
</head>
<body style="margin: 0; padding: 24px; background-color: #f4f6f5; font-family: Arial, Helvetica, sans-serif; color: #172b40;">
    <div style="max-width: 640px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
        <div style="background-color: #087d50; padding: 20px 24px; color: #ffffff;">
            <h1 style="margin: 0; font-size: 20px;">New booking inquiry</h1>
            <p style="margin: 6px 0 0; font-size: 14px;">Reference: <strong>{{ $booking->reference_code }}</strong></p>
        </div>

        <div style="padding: 24px;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <tr>
                    <th style="text-align: left; padding: 8px 0; width: 38%; color: #64748b;">Tour</th>
                    <td style="padding: 8px 0;">{{ $booking->tour_name }}@if ($booking->tour_year) ({{ $booking->tour_year }})@endif</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 8px 0; color: #64748b;">Tour type</th>
                    <td style="padding: 8px 0;">{{ $booking->tour_type->label() }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 8px 0; color: #64748b;">Currency</th>
                    <td style="padding: 8px 0;">{{ $booking->currency->label() }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 8px 0; color: #64748b;">Room preference</th>
                    <td style="padding: 8px 0;">{{ $booking->room_preference->label() }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 8px 0; color: #64748b;">Travellers</th>
                    <td style="padding: 8px 0;">{{ $booking->participants_count }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 8px 0; color: #64748b;">Full name</th>
                    <td style="padding: 8px 0;">{{ $booking->full_name }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 8px 0; color: #64748b;">Email</th>
                    <td style="padding: 8px 0;"><a href="mailto:{{ $booking->email }}" style="color: #087d50;">{{ $booking->email }}</a></td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 8px 0; color: #64748b;">Phone</th>
                    <td style="padding: 8px 0;">{{ $booking->phone }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 8px 0; color: #64748b;">Country</th>
                    <td style="padding: 8px 0;">{{ $booking->country }}</td>
                </tr>
                @if ($booking->birding_experience)
                    <tr>
                        <th style="text-align: left; padding: 8px 0; color: #64748b;">Birding experience</th>
                        <td style="padding: 8px 0;">{{ $booking->birding_experience }}</td>
                    </tr>
                @endif
                @if ($booking->dietary_medical)
                    <tr>
                        <th style="text-align: left; padding: 8px 0; color: #64748b;">Dietary / medical</th>
                        <td style="padding: 8px 0;">{!! nl2br(e($booking->dietary_medical)) !!}</td>
                    </tr>
                @endif
                @if ($booking->special_notes)
                    <tr>
                        <th style="text-align: left; padding: 8px 0; color: #64748b;">Special requests</th>
                        <td style="padding: 8px 0;">{!! nl2br(e($booking->special_notes)) !!}</td>
                    </tr>
                @endif
                <tr>
                    <th style="text-align: left; padding: 8px 0; color: #64748b;">Terms accepted</th>
                    <td style="padding: 8px 0;">{{ $booking->terms_accepted_at?->format('j F Y, H:i') }}</td>
                </tr>
            </table>

            <p style="margin: 20px 0 0; font-size: 12px; color: #94a3b8;">
                Submitted {{ $booking->created_at->format('j F Y, H:i') }}
                @if ($booking->ip_address) from {{ $booking->ip_address }} @endif
            </p>
        </div>
    </div>
</body>
</html>
