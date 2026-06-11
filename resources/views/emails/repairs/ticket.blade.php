<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">

    <div style="max-width:700px; margin:auto; background:white; padding:30px; border-radius:10px;">

        <h2>Repair Ticket Created</h2>

        <p>Hello {{ $ticket->customer->fullname }},</p>

        <p>Your repair ticket has been created successfully.</p>

        <hr>

        <p>
            <strong>Ticket Number:</strong>
            {{ $ticket->ticket_number }}
        </p>

        <p>
            <strong>Device:</strong>
            {{ $ticket->deviceModel->brand->name }}
            {{ $ticket->deviceModel->name }}
        </p>

        <p>
            <strong>Status:</strong>
            {{ $ticket->status }}
        </p>

        <p>
            <strong>Issue:</strong>
            {{ $ticket->issue_description }}
        </p>

        <a href="{{ route('customer.repair.track', $ticket->public_token) }}"
            style="
                display:inline-block;
                padding:12px 20px;
                background:#2563eb;
                color:white;
                text-decoration:none;
                border-radius:5px;
           ">
            Track Repair
        </a>

    </div>

</body>

</html>
