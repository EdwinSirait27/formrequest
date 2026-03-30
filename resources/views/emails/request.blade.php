<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Approval Form Request</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Outfit", sans-serif;
            font-weight: 400;
            background-color: #0f0f13;
            color: #111;
            -webkit-text-size-adjust: 100%;
        }

        .outer {
            padding: 40px 16px;
            background: #0f0f13;
        }

        .wrapper {
            max-width: 620px;
            width: 100%;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(0,0,0,0.5);
        }

        /* ── HEADER ── */
        .header {
            position: relative;
            padding: 0;
            background: #0d0d12;
            overflow: hidden;
        }

        .header-bg-accent {
            display: none;
        }

        .header-bg-accent2 {
            display: none;
        }

        .header-inner {
            position: relative;
            z-index: 2;
            padding: 36px 40px 32px;
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .company-logo-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .company-icon {
            width: 36px;
            height: 36px;
            background: #c9a840;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .company-icon svg {
            width: 18px;
            height: 18px;
            fill: #0d0d12;
        }

        .header-company {
            font-family: "Playfair Display", serif;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.3px;
        }

        .header-date-badge {
            font-size: 10px;
            font-weight: 500;
            color: rgba(255,255,255,0.35);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border: 1px solid rgba(255,255,255,0.1);
            padding: 5px 12px;
            border-radius: 100px;
        }

        .header-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.07);
            margin-bottom: 24px;
        }

        .header-title-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .header-eyebrow {
            font-size: 9px;
            font-weight: 600;
            color: #c9a840;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .header-title {
            font-family: "Playfair Display", serif;
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }

        .header-title span {
            color: #c9a840;
        }

        .type-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 4px;
            padding: 7px 14px;
            background: rgba(201,168,64,0.1);
            color: #c9a840;
            font-size: 11px;
            font-weight: 600;
            border-radius: 100px;
            border: 1px solid rgba(201,168,64,0.3);
            letter-spacing: 0.5px;
            width: fit-content;
        }

        .type-pill::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #c9a840;
            border-radius: 50%;
            display: inline-block;
        }

        /* ── STATUS STRIP ── */
        .status-strip {
            background: #16161e;
            padding: 14px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e8e5e0;
        }

        .strip-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .strip-label {
            font-size: 9px;
            font-weight: 600;
            color: rgba(255,255,255,0.3);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .strip-val {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
        }

        .strip-val.gold {
            color: #c9a840;
        }

        .strip-divider {
            width: 1px;
            height: 28px;
            background: rgba(255,255,255,0.08);
        }

        /* ── BODY ── */
        .body {
            padding: 36px 40px;
            background: #fff;
        }

        /* greeting */
        .greeting-wrap {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            padding: 20px 22px;
            background: #f8f7f4;
            border-radius: 12px;
            border: 1px solid #eeece8;
            margin-bottom: 32px;
        }

        .greeting-icon {
            width: 38px;
            height: 38px;
            background: #0d0d12;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .greeting-icon svg {
            width: 18px;
            height: 18px;
            fill: #d4af52;
        }

        .greeting {
            font-size: 13px;
            line-height: 1.9;
            color: #666;
        }

        .greeting strong {
            color: #0d0d12;
            font-weight: 600;
        }

        /* Section label */
        .section-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            color: #bbb;
            margin-bottom: 12px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #f0ede8;
        }

        /* Info card */
        .card {
            border: 1px solid #eeece8;
            border-radius: 12px;
            margin-bottom: 28px;
            overflow: hidden;
            background: #fff;
        }

        .info-row {
            display: flex;
            align-items: center;
            padding: 13px 20px;
            border-bottom: 1px solid #f5f3ef;
            font-size: 12.5px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-key {
            width: 110px;
            flex-shrink: 0;
            color: #c0bdb8;
            font-size: 11.5px;
            font-weight: 500;
        }

        .info-sep {
            width: 20px;
            color: #e0ddd8;
            flex-shrink: 0;
            font-size: 11px;
        }

        .info-val {
            color: #111;
            font-weight: 600;
            flex: 1;
            font-size: 13px;
        }

        .info-val.light {
            font-weight: 400;
            color: #555;
            font-size: 12.5px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            background: #fdf6e0;
            border: 1px solid #c9a840;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #8a6e10;
            border-radius: 100px;
        }

        .status-badge::before {
            content: '';
            width: 5px;
            height: 5px;
            background: #c9a840;
            border-radius: 50%;
        }

        /* Items table */
        .table-wrap {
            border: 1px solid #eeece8;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 28px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table.items thead th {
            background: #0d0d12;
            color: rgba(255,255,255,0.45);
            padding: 12px 16px;
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        table.items thead th:first-child {
            border-radius: 0;
        }

        table.items tbody tr {
            border-bottom: 1px solid #f7f5f1;
            transition: background 0.15s;
        }

        table.items tbody tr:last-child {
            border-bottom: none;
        }

        table.items tbody tr:nth-child(even) {
            background: #fdfcfb;
        }

        table.items tbody td {
            padding: 13px 16px;
            color: #333;
            vertical-align: top;
        }

        table.items tfoot td {
            padding: 14px 16px;
            font-weight: 700;
            color: #0d0d12;
            background: #f2ede3;
            border-top: 1px solid #ddd8cc;
            font-size: 13px;
        }

        .tr {
            text-align: right;
        }

        .no-col {
            color: #d0cdc8;
            text-align: center;
            width: 28px;
            font-size: 11px;
            font-weight: 600;
        }

        .item-name {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 12.5px;
        }

        .spec {
            font-size: 10.5px;
            color: #bbb;
            margin-top: 3px;
            font-style: italic;
            font-weight: 300;
        }

        .qty-cell {
            font-weight: 500;
            color: #555;
            white-space: nowrap;
        }

        .price-cell {
            color: #555;
            white-space: nowrap;
            font-weight: 400;
        }

        .subtotal-cell {
            font-weight: 600;
            color: #1a1a1a;
            white-space: nowrap;
        }

        .total-label {
            font-style: italic;
            color: #888;
            font-size: 11px;
            font-weight: 400;
        }

        .grand-total-amount {
            color: #0d0d12;
            font-weight: 700;
            font-size: 14px;
        }

        /* CTA */
        .cta-wrap {
            text-align: center;
            padding: 8px 0 28px;
        }

        .btn-wrap {
            display: inline-block;
            background: #c9a840;
            padding: 2px;
            border-radius: 12px;
        }

        .btn {
            display: inline-block;
            padding: 14px 44px;
            background: #0d0d12;
            color: #c9a840 !important;
            text-decoration: none;
            font-family: "Outfit", sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-radius: 10px;
        }

        .cta-sub {
            margin-top: 12px;
            font-size: 10.5px;
            color: #c0bdb8;
            letter-spacing: 0.3px;
        }

        /* Note */
        .note {
            background: #fafaf8;
            border: 1px solid #eeece8;
            border-radius: 12px;
            padding: 14px 24px;
            font-size: 11px;
            color: #c0bdb8;
            line-height: 1.9;
            text-align: center;
        }

        .note a {
            color: #888;
            text-decoration: underline;
            font-weight: 500;
        }

        /* ── FOOTER ── */
        .footer {
            padding: 20px 40px;
            background: #0d0d12;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .footer-left {
            font-size: 10px;
            color: rgba(255,255,255,0.2);
            letter-spacing: 0.3px;
        }

        .footer-right {
            font-size: 10px;
            color: #6a5820;
            letter-spacing: 0.5px;
        }

        @media (max-width: 480px) {
            .outer {
                padding: 0;
            }

            .wrapper {
                border-radius: 0;
            }

            .body,
            .header-inner {
                padding: 24px 20px;
            }

            .status-strip {
                padding: 12px 20px;
                flex-wrap: wrap;
                gap: 12px;
            }

            .btn {
                padding: 14px 28px;
            }

            .info-key {
                width: 85px;
            }

            .header-date-badge {
                display: none;
            }

            .footer {
                padding: 16px 20px;
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>
<div class="outer">
    <div class="wrapper">

        <!-- ══ HEADER ══ -->
        <div class="header">
            <div class="header-bg-accent"></div>
            <div class="header-bg-accent2"></div>
            <div class="header-inner">
                <div class="header-top">
                  
                        <div class="header-company">{{ $formrequest->company->name }}</div>
                    {{-- </div> --}}
                    <div class="header-date-badge">{{ date('d M Y') }}</div>
                </div>

                <hr class="header-divider" />

                <div class="header-title-group">
                    <div class="header-eyebrow">Approval Required</div>
                    <div class="header-title">Form <span>Request</span></div>
                    <div class="type-pill">{{ $formrequest->requesttype->request_type_name }}</div>
                </div>
            </div>
        </div>

        <!-- ══ STATUS STRIP ══ -->
        <div class="status-strip">
            <div class="strip-item">
                <div class="strip-label">Submitted By</div>
                <div class="strip-val">{{ $formrequest->user->employee->employee_name ?? '-' }}</div>
            </div>
            <div class="strip-divider"></div>
            <div class="strip-item">
                <div class="strip-label">NIP</div>
                <div class="strip-val">{{ $formrequest->user->employee->employee_pengenal ?? '-' }}</div>
            </div>
            <div class="strip-divider"></div>
            <div class="strip-item">
                <div class="strip-label">Status</div>
                <div class="strip-val gold">{{ $formrequest->status }}</div>
            </div>
        </div>

        <!-- ══ BODY ══ -->
        <div class="body">

            <!-- Greeting -->
            <div class="greeting-wrap">
                <div class="greeting-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                </div>
                <p class="greeting">
                    Hello,<br>
                    A <strong>New Form Request</strong> has been submitted and is awaiting your approval.
                    The request was filed by <strong>{{ $formrequest->user->employee->employee_name ?? '-' }}</strong>
                    &mdash; NIP <strong>{{ $formrequest->user->employee->employee_pengenal ?? '-' }}</strong>.
                    Please review the details below and take action accordingly.
                </p>
            </div>

            <!-- Request Detail -->
            <div class="section-label">Request Detail</div>
            <div class="card">
                <div class="info-row">
                    <span class="info-key">Title</span>
                    <span class="info-sep">:</span>
                    <span class="info-val">{{ $formrequest->title }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Applicant</span>
                    <span class="info-sep">:</span>
                    <span class="info-val">{{ $formrequest->user->employee->employee_name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Request Date</span>
                    <span class="info-sep">:</span>
                    <span class="info-val">{{ $requestDate }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Deadline</span>
                    <span class="info-sep">:</span>
                    <span class="info-val">{{ $deadline }}</span>
                </div>
                @if ($formrequest->notes)
                    <div class="info-row">
                        <span class="info-key">Notes</span>
                        <span class="info-sep">:</span>
                        <span class="info-val light">{{ $formrequest->notes }}</span>
                    </div>
                @endif
                <div class="info-row">
                    <span class="info-key">Status</span>
                    <span class="info-sep">:</span>
                    <span class="info-val">
                        <span class="status-badge">{{ $formrequest->status }}</span>
                    </span>
                </div>
            </div>

            <!-- Item Details -->
            <div class="section-label">Item Details</div>
            <div class="table-wrap">
                <table class="items">
                    <thead>
                        <tr>
                            <th style="width:36px; text-align:center;">No.</th>
                            <th style="text-align:center;">Item</th>
                            <th style="text-align:center;" class="tr">Qty</th>
                            <th style="text-align:center;" class="tr">Unit Price</th>
                            <th style="text-align:center;" class="tr">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formrequest->items as $index => $item)
                            <tr>
                                <td class="no-col">{{ $index + 1 }}</td>
                                <td>
                                    <div class="item-name">{{ $item->item_name }}</div>
                                    @if ($item->specification)
                                        <div class="spec">{{ $item->specification }}</div>
                                    @endif
                                </td>
                                <td class="tr qty-cell">{{ number_format($item->qty, 2, ',', '.') }} {{ $item->uom }}</td>
                                <td class="tr price-cell">Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                <td class="tr subtotal-cell">Rp {{ number_format($item->qty * $item->price, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="tr">
                                <span class="total-label">Grand Total</span>
                            </td>
                            <td class="tr grand-total-amount">Rp {{ number_format($formrequest->total_amount, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- CTA -->
            <div class="cta-wrap">
                <div class="btn-wrap">
                    <a href="{{ $detailUrl }}" class="btn">View &amp; Process Request</a>
                </div>
                <div class="cta-sub">Click the button above to review and approve or reject this request</div>
            </div>

            <!-- Note -->
            <div class="note">
                This email was sent automatically. Please do not reply directly.<br>
                Need help? <a href="https://tix.asianbay.co.id">IT Ticketing &mdash; Asian Bay Development</a>
            </div>

        </div>

        <!-- ══ FOOTER ══ -->
        <div class="footer">
            <div class="footer-left">&copy; {{ date('Y') }} PT Asian Bay Development &nbsp;&middot;&nbsp; Form Request System</div>
            <div class="footer-right">Created by Edwin Sirait</div>
        </div>

    </div>
</div>
</body>
</html>