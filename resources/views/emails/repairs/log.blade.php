<style>
    .log-item {
        border-bottom: 1px solid #374151;
        padding: 20px 0;
        font-family: Arial, sans-serif;
    }

    .header {
        margin-bottom: 12px;
        overflow: hidden;
    }

    .user-section {
        float: left;
    }

    .avatar {
        width: 32px;
        height: 32px;
        line-height: 32px;
        text-align: center;
        border-radius: 50%;
        background: #2563eb;
        color: #fff;
        font-size: 14px;
        font-weight: bold;
        display: inline-block;
        vertical-align: top;
    }

    .user-info {
        display: inline-block;
        margin-left: 8px;
        vertical-align: top;
    }

    .user-name {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .date {
        font-size: 12px;
        color: #6b7280;
        margin: 2px 0 0;
    }

    .badge {
        float: right;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-success {
        border: 1px solid #22c55e;
        background: #dcfce7;
        color: #166534;
    }

    .badge-secondary {
        border: 1px solid #9ca3af;
        background: #f3f4f6;
        color: #374151;
    }

    .message {
        margin: 12px 0;
        font-size: 14px;
        line-height: 1.6;
        color: #374151;
        white-space: pre-line;
    }

    .status-box {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 8px;
        background: #f3f4f6;
        font-size: 12px;
    }

    .status-label {
        color: #6b7280;
    }

    .status-old {
        color: #ca8a04;
        font-weight: 600;
    }

    .status-arrow {
        color: #9ca3af;
        margin: 0 6px;
    }

    .status-new {
        color: #16a34a;
        font-weight: 600;
    }
</style>

<article class="log-item">

    <div class="header">

        <div class="user-section">

            <span class="avatar">T</span>

            <div class="user-info">
                <p class="user-name">Technician</p>

                <p class="date">
                    {{ $log->created_at->diffForHumans() }}
                </p>
            </div>

        </div>

        @if ($log->is_visible_to_customer)
            <span class="badge badge-success">
                Visible to customer
            </span>
        @else
            <span class="badge badge-secondary">
                Internal only
            </span>
        @endif

    </div>

    <p class="message">
        {{ $log->message }}
    </p>

    @if ($log->old_status || $log->new_status)

        <div class="status-box">

            <span class="status-label">Status:</span>

            <span class="status-old">
                {{ $log->old_status ?? '-' }}
            </span>

            <span class="status-arrow">→</span>

            <span class="status-new">
                {{ $log->new_status ?? '-' }}
            </span>

        </div>


        <p>   {{  $log->ticket->ticket_number }}</p>

         <a href="{{ route('repair-track', $log->ticket->ticket_number) }}">link ticket repair</a>


    @endif

</article>
