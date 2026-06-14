<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Repair Request Update</title>
</head>

@php
    $isApproved = $repair_request->status === 'approved';

    $statusLabel = $isApproved ? 'Approved' : 'Rejected';

    $mainColor = $isApproved ? '#10b981' : '#ef4444';
    $lightColor = $isApproved ? '#ecfdf5' : '#fef2f2';
    $textColor = $isApproved ? '#065f46' : '#991b1b';
@endphp

<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial, sans-serif; color:#111827;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8; padding:30px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,0.08);">

                    <tr>
                        <td style="background:{{ $mainColor }}; padding:28px 32px; color:#ffffff;">
                            <h1 style="margin:0; font-size:24px;">
                                Repair Request {{ $statusLabel }}
                            </h1>

                            <p style="margin:8px 0 0; font-size:15px; opacity:0.95;">
                                Your repair request has been reviewed by our team.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px;">

                            <p style="font-size:16px; margin:0 0 20px;">
                                Hello {{ $repair_request->fullname ?? 'Customer' }},
                            </p>

                            <div
                                style="background:{{ $lightColor }}; border:1px solid {{ $mainColor }}; border-radius:12px; padding:18px; margin-bottom:24px;">
                                <p style="margin:0; font-size:15px; color:{{ $textColor }};">
                                    Your repair request status is now:
                                </p>

                                <h2 style="margin:8px 0 0; font-size:26px; color:{{ $textColor }};">
                                    {{ $statusLabel }}
                                </h2>
                            </div>

                            <h3 style="font-size:18px; margin:0 0 12px; color:#111827;">
                                Admin Response
                            </h3>

                            <div
                                style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:16px; margin-bottom:26px;">
                                <p style="margin:0; font-size:15px; line-height:1.7; color:#374151;">
                                    {{ $repair_request->response ?? 'No additional message was provided.' }}
                                </p>
                            </div>

                            <h3 style="font-size:18px; margin:0 0 12px; color:#111827;">
                                Request Details
                            </h3>

                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse:collapse; font-size:14px; margin-bottom:26px;">
                                <tr>
                                    <td style="background:#f9fafb; font-weight:bold; width:160px;">Request ID</td>
                                    <td style="background:#f9fafb;">#{{ $repair_request->id }}</td>
                                </tr>

                                <tr>
                                    <td style="font-weight:bold;">Device</td>
                                    <td>{{ $repair_request->device_name ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f9fafb; font-weight:bold;">Status</td>
                                    <td style="background:#f9fafb;">
                                        <span
                                            style="display:inline-block; padding:6px 12px; border-radius:999px; background:{{ $lightColor }}; color:{{ $textColor }}; font-weight:bold;">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            @if ($isApproved)
                                <p style="font-size:15px; line-height:1.7; color:#374151;">
                                    Our team will continue with the next steps of your repair. You will be contacted if
                                    we need more information.
                                </p>
                            @else
                                <p style="font-size:15px; line-height:1.7; color:#374151;">
                                    Your request could not be approved at this stage. Please check the admin response
                                    above for more information.
                                </p>
                            @endif

                        </td>
                    </tr>

                    <tr>
                        <td
                            style="background:#f9fafb; padding:18px 32px; text-align:center; font-size:12px; color:#6b7280;">
                            Seven Tech SRLS — Automatic notification
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>

</html>
