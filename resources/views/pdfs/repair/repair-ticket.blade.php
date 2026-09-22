{{-- resources/views/pdf/repair-ticket.blade.php --}}

@php
    $status = strtolower($ticket->status ?? 'pending');

    $statusColor = match ($status) {
        'pending' => '#f59e0b',
        'in_progress' => '#2563eb',
        'waiting_parts' => '#7c3aed',
        'completed' => '#059669',
        'delivered' => '#047857',
        'cancelled' => '#dc2626',
        default => '#6b7280',
    };

    $statusLabel = str_replace('_', ' ', strtoupper($status));
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Repair Receipt - {{ $ticket->ticket_number }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        .page {
            padding: 28px;
        }

        .header {
            border-bottom: 3px solid #111827;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #111827;
        }

        .company-info {
            margin-top: 6px;
            color: #4b5563;
            line-height: 1.5;
        }

        .document-title {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            color: #111827;
        }

        .document-subtitle {
            text-align: right;
            color: #6b7280;
            margin-top: 4px;
        }

        .row {
            width: 100%;
            display: table;
        }

        .col {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .section {
            margin-bottom: 22px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #111827;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 6px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 4px;
            vertical-align: top;
        }

        .label {
            width: 36%;
            color: #6b7280;
            font-weight: bold;
        }

        .value {
            color: #111827;
        }

        .status-box {
            margin: 18px 0 24px;
            padding: 16px;
            text-align: center;
            color: white;
            background: {{ $statusColor }};
            border-radius: 8px;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .spec-table,
        .logs-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .spec-table th,
        .spec-table td,
        .logs-table th,
        .logs-table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .spec-table th,
        .logs-table th {
            background: #f3f4f6;
            font-weight: bold;
            color: #111827;
        }

        .note {
            white-space: pre-line;
            line-height: 1.5;
        }

        .badge-public {
            color: #047857;
            font-weight: bold;
        }

        .badge-internal {
            color: #6b7280;
            font-weight: bold;
        }

        .signatures {
            margin-top: 40px;
            width: 100%;
            display: table;
        }

        .signature-box {
            display: table-cell;
            width: 50%;
            padding-right: 30px;
        }

        .signature-line {
            margin-top: 45px;
            border-top: 1px solid #111827;
            padding-top: 6px;
            color: #374151;
        }

        .terms {
            margin-top: 30px;
            font-size: 10px;
            color: #4b5563;
            line-height: 1.6;
            border-top: 1px solid #d1d5db;
            padding-top: 12px;
        }

        .footer {
            position: fixed;
            bottom: 18px;
            left: 28px;
            right: 28px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
        }
    </style>
</head>

<body>
<div class="page">

    {{-- Header --}}
    <div class="header">
        <div class="row">
            <div class="col">
                <div class="company-name">Tech Repair</div>
                <div class="company-info">
                    Professional Device Repair Service<br>
                    Milan, Italy<br>
                    Email: tech-repair-admin@eprostam.com<br>
                    Phone: +39 351 633 2693
                </div>
            </div>

            <div class="col">
                <div class="document-title">REPAIR RECEIPT</div>
                <div class="document-subtitle">
                    Ticket: {{ $ticket->ticket_number }}<br>
                    Date: {{ $ticket->created_at?->format('d/m/Y H:i') }}<br>
                    Generated: {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Status --}}
    <div class="status-box">
        {{ $statusLabel }}
    </div>

    {{-- Ticket + Customer --}}
    <div class="row section">
        <div class="col" style="padding-right: 15px;">
            <div class="section-title">Ticket Information</div>

            <table class="info-table">
                <tr>
                    <td class="label">Ticket Number</td>
                    <td class="value">{{ $ticket->ticket_number }}</td>
                </tr>
                <tr>
                    <td class="label">Created At</td>
                    <td class="value">{{ $ticket->created_at?->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="label">Last Update</td>
                    <td class="value">{{ $ticket->updated_at?->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="label">Status</td>
                    <td class="value">{{ $statusLabel }}</td>
                </tr>
            </table>
        </div>

        <div class="col" style="padding-left: 15px;">
            <div class="section-title">Customer Information</div>

            <table class="info-table">
                <tr>
                    <td class="label">Full Name</td>
                    <td class="value">{{ $ticket->customer->fullname ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Phone</td>
                    <td class="value">{{ $ticket->customer->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td class="value">{{ $ticket->customer->email ?: '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Device --}}
    <div class="section">
        <div class="section-title">Device Information</div>

        <table class="info-table">
            <tr>
                <td class="label">Brand</td>
                <td class="value">{{ $ticket->deviceModel->brand->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Type</td>
                <td class="value">{{ $ticket->deviceModel->type->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Model</td>
                <td class="value">{{ $ticket->deviceModel->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Serial Number</td>
                <td class="value">{{ $ticket->sn ?: '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- Specifications --}}
    <div class="section">
        <div class="section-title">Device Specifications</div>

        <table class="spec-table">
            <thead>
                <tr>
                    <th>Attribute</th>
                    <th>Selected Option</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($ticket->selectedOptions as $option)
                    <tr>
                        <td>{{ $option->specAttribute->name ?? '-' }}</td>
                        <td>{{ $option->value ?? $option->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No specifications selected.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Repair Activity --}}
    <div class="section">
        <div class="section-title">Repair Activity</div>

        <table class="logs-table">
            <thead>
                <tr>
                    <th width="20%">Date</th>
                    <th width="45%">Technician Note</th>
                    <th width="25%">Status Change</th>
                    <th width="10%">Visibility</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($ticket->logs as $log)
                    <tr>
                        <td>{{ $log->created_at?->format('d/m/Y H:i') }}</td>

                        <td class="note">
                            {{ $log->message }}
                        </td>

                        <td>
                            @if ($log->old_status || $log->new_status)
                                {{ $log->old_status ?? '-' }}
                                →
                                {{ $log->new_status ?? '-' }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if ($log->is_visible_to_customer)
                                <span class="badge-public">Public</span>
                            @else
                                <span class="badge-internal">Internal</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No repair activity has been added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Signatures --}}
    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line">
                Customer Signature
            </div>
        </div>

        <div class="signature-box">
            <div class="signature-line">
                Technician Signature
            </div>
        </div>
    </div>

    {{-- Terms --}}
    <div class="terms">
        <strong>Terms & Conditions:</strong><br>
        The customer confirms that the device has been left for diagnosis and/or repair.
        Tech Repair is not responsible for data loss occurring during repair procedures.
        The customer is advised to back up personal data before any technical intervention.
        Repair times may vary depending on the availability of spare parts and technical complexity.
        This document is a repair receipt and does not replace a fiscal invoice where applicable.
    </div>

</div>

<div class="footer">
    Tech Repair — Repair Receipt — {{ $ticket->ticket_number }}
</div>

</body>
</html>
