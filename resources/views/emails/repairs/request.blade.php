<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Repair Request</title>
</head>
<body style="font-family: Arial, sans-serif; line-height:1.6">

    <h2>New Repair Request Received</h2>

    <p>
        A new repair request has been submitted by a customer.
    </p>

    <p>
        Please review the request details in the administration panel.
    </p>

    <p>
        <a href="{{ route('repair-requests.show', $repair_request->id) }}"
           style="
                background:#2563eb;
                color:white;
                padding:10px 20px;
                text-decoration:none;
                border-radius:5px;
                display:inline-block;
           ">
            View Repair Requests
        </a>
    </p>

    <hr>

    <small>
        Tech Repair
    </small>

</body>
</html>
