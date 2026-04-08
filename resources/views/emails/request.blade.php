{{-- <!DOCTYPE html>
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

        <div class="header">
            <div class="header-bg-accent"></div>
            <div class="header-bg-accent2"></div>
            <div class="header-inner">
                <div class="header-top">
                  
                        <div class="header-company">{{ $formrequest->company->name }}</div>
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
                @isset($formrequest->requesttype)
    @if ($formrequest->requesttype->code === 'CA')
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
                            <td class="tr grand-total-amount">Rp {{ number_format($formrequest->total_amount, 2, ',', '.')}}</td>
                        </tr>
                    </tfoot>
                    
                </table>
                 @endif
                  @if ($formrequest->requesttype->code === 'CAPEX')
            <table class="items">
                <thead>
                    <tr>
                        <th style="width:36px; text-align:center;">No.</th>
                        <th style="text-align:center;">Item</th>
                        <th style="text-align:center;" class="tr">Qty</th>
                        <th style="text-align:center;" class="tr">UOM</th>
                        <th style="text-align:center;" class="tr">Vendor I</th>
                        <th style="text-align:center;" class="tr">Vendor II</th>
                        <th style="text-align:center;" class="tr">Vendor III</th>
                        <th style="text-align:center;" class="tr">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formrequest->items as $index => $item)
                        @php $vendors = $capexVendors[$item->id] ?? collect(); @endphp
                        <tr>
                            <td class="no-col">{{ $index + 1 }}</td>
                            <td>
                                <div class="item-name">{{ $item->item_name }}</div>
                                @if ($item->specification)
                                    <div class="spec">{{ $item->specification }}</div>
                                @endif
                            </td>
                            <td class="tr qty-cell">{{ number_format($item->qty, 2, ',', '.') }}</td>
                            <td class="tr">{{ $item->uom }}</td>
                            @for ($v = 0; $v < 3; $v++)
                                <td class="tr price-cell">
                                    @if (isset($vendors[$v]))
                                        Rp {{ number_format($vendors[$v]['price'], 2, ',', '.') }}<br>
                                        <small>{{ $vendors[$v]['vendor_name'] }}</small>
                                    @else
                                        -
                                    @endif
                                </td>
                            @endfor
                            <td class="tr subtotal-cell">
    Rp {{ number_format(optional($item)->total_price ?? 0, 2, ',', '.') }}
</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        @endif
    @endisset
            </div>

            <div class="cta-wrap">
                <div class="btn-wrap">
                    <a href="{{ $detailUrl }}" class="btn">View &amp; Process Request</a>
                </div>
                <div class="cta-sub">Click the button above to review and approve or reject this request</div>
            </div>

            <div class="note">
                This email was sent automatically. Please do not reply directly.<br>
                Need help? <a href="https://tix.asianbay.co.id">IT Ticketing &mdash; Asian Bay Development</a>
            </div>

        </div>

        <div class="footer">
            <div class="footer-left">&copy; {{ date('Y') }} PT Asian Bay Development &nbsp;&middot;&nbsp; Form Request System</div>
            <div class="footer-right">Created by Edwin Sirait</div>
        </div>

    </div>
</div>
</body>
</html>


 --}}
{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Request Approval</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f0ede8;
            color: #1a1a1a;
            -webkit-text-size-adjust: 100%;
        }

        /* ── OUTER ── */
        .outer {
            padding: 48px 16px;
            background: #f0ede8;
        }

        .wrapper {
            max-width: 794px; /* A4 width equivalent */
            width: 100%;
            margin: 0 auto;
            background: #fff;
        }

        /* ── HEADER ── */
        .header {
            background: #1c1c1e;
            padding: 40px 56px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .header-left {}

        .brand {
            font-family: 'DM Serif Display', serif;
            font-size: 13px;
            color: rgba(255,255,255,0.35);
            letter-spacing: 3px;
            margin-bottom: 20px;
        }

        .header-title {
            font-family: 'DM Serif Display', serif;
            font-size: 34px;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -0.5px;
        }

        .header-title em {
            font-style: italic;
            color: #c9a55a;
        }

        .header-right {
            text-align: right;
            flex-shrink: 0;
            padding-top: 6px;
        }

        .doc-label {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 2.5px;
            color: rgba(255,255,255,0.25);
            margin-bottom: 6px;
        }

        .doc-number {
            font-family: 'DM Serif Display', serif;
            font-size: 18px;
            color: #c9a55a;
            letter-spacing: 0.5px;
        }

        .type-tag {
            display: inline-block;
            margin-top: 14px;
            padding: 5px 14px;
            border: 1px solid rgba(201,165,90,0.4);
            color: rgba(201,165,90,0.8);
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 2px;
        }

        /* ── ACCENT BAR ── */
        .accent-bar {
            height: 3px;
            background: linear-gradient(90deg, #c9a55a 0%, #e8d5a0 50%, #c9a55a 100%);
        }

        /* ── META ROW ── */
        .meta-row {
            background: #f7f5f1;
            border-bottom: 1px solid #ebe7e0;
            padding: 16px 56px;
            display: flex;
            gap: 0;
        }

        .meta-item {
            flex: 1;
            padding: 0 24px 0 0;
            border-right: 1px solid #ddd9d2;
        }

        .meta-item:first-child {
            padding-left: 0;
        }

        .meta-item:last-child {
            border-right: none;
            padding-right: 0;
            padding-left: 24px;
        }

        .meta-item:not(:first-child):not(:last-child) {
            padding-left: 24px;
        }

        .meta-label {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 2px;
            color: #b0aa9f;
            margin-bottom: 4px;
        }

        .meta-value {
            font-size: 12.5px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .meta-value.gold { color: #a07a20; }

        /* ── BODY ── */
        .body {
            padding: 48px 56px;
        }

        /* greeting */
        .greeting {
            padding: 22px 28px;
            background: #faf9f6;
            border-left: 3px solid #c9a55a;
            margin-bottom: 40px;
            font-size: 13px;
            line-height: 1.85;
            color: #555;
        }

        .greeting strong { color: #1a1a1a; font-weight: 600; }

        /* section */
        .section-title {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 3px;
            color: #c9a55a;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #ebe7e0;
        }

        /* detail table */
        .detail-block {
            border: 1px solid #ebe7e0;
            margin-bottom: 36px;
        }

        .detail-row {
            display: flex;
            border-bottom: 1px solid #f2efea;
            font-size: 12.5px;
        }

        .detail-row:last-child { border-bottom: none; }

        .detail-key {
            width: 130px;
            flex-shrink: 0;
            padding: 13px 20px;
            background: #faf9f6;
            color: #9e9890;
            font-size: 11px;
            font-weight: 500;
            border-right: 1px solid #f2efea;
        }

        .detail-val {
            padding: 13px 20px;
            color: #1a1a1a;
            font-weight: 500;
            flex: 1;
            font-size: 12.5px;
        }

        .detail-val.muted {
            color: #666;
            font-weight: 400;
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 4px 14px;
            background: #fdf6e3;
            border: 1px solid #e5c66a;
            font-size: 10.5px;
            font-weight: 700;
            color: #8a6a10;
            letter-spacing: 0.5px;
        }

        .status-chip::before {
            content: '';
            width: 5px;
            height: 5px;
            background: #c9a55a;
            border-radius: 50%;
        }

        /* items table */
        .table-outer {
            border: 1px solid #ebe7e0;
            margin-bottom: 36px;
            overflow: hidden;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
        }

        table.items thead tr {
            background: #1c1c1e;
        }

        table.items thead th {
            padding: 11px 16px;
            color: rgba(255,255,255,0.4);
            font-size: 8.5px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-align: left;
        }

        table.items thead th.right { text-align: right; }

        table.items tbody tr {
            border-bottom: 1px solid #f2efea;
        }

        table.items tbody tr:last-child { border-bottom: none; }

        table.items tbody tr:nth-child(even) {
            background: #faf9f6;
        }

        table.items tbody td {
            padding: 13px 16px;
            color: #333;
            vertical-align: top;
        }

        table.items tfoot tr {
            background: #f2ede3;
            border-top: 2px solid #ddd5c0;
        }

        table.items tfoot td {
            padding: 13px 16px;
            font-weight: 700;
            font-size: 12px;
            color: #1a1a1a;
        }

        .right { text-align: right; }
        .center { text-align: center; }

        .no-col {
            color: #c9bfaa;
            text-align: center;
            font-size: 10px;
            font-weight: 600;
        }

        .item-name {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 12px;
        }

        .spec {
            font-size: 10px;
            color: #b5b0a8;
            margin-top: 3px;
            font-style: italic;
        }

        .vendor-name {
            display: block;
            font-size: 9.5px;
            color: #b5b0a8;
            margin-top: 2px;
            font-style: italic;
        }

        .total-label {
            font-style: italic;
            color: #a09880;
            font-size: 11px;
            font-weight: 400;
        }

        .grand-amount {
            font-family: 'DM Serif Display', serif;
            font-size: 15px;
            color: #1a1a1a;
        }

        /* CTA */
        .cta-wrap {
            text-align: center;
            padding: 4px 0 36px;
        }

        .btn {
            display: inline-block;
            padding: 14px 48px;
            background: #1c1c1e;
            color: #c9a55a !important;
            text-decoration: none;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 3px;
        }

        .cta-note {
            margin-top: 12px;
            font-size: 10.5px;
            color: #b5b0a8;
        }

        /* disclaimer */
        .disclaimer {
            padding: 18px 28px;
            background: #faf9f6;
            border: 1px solid #ebe7e0;
            font-size: 10.5px;
            color: #b5b0a8;
            line-height: 1.8;
            text-align: center;
        }

        .disclaimer a {
            color: #9e9890;
            text-decoration: underline;
        }

        /* ── FOOTER ── */
        .footer {
            background: #1c1c1e;
            padding: 20px 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-left {
            font-size: 10px;
            color: rgba(255,255,255,0.18);
            letter-spacing: 0.3px;
        }

        .footer-right {
            font-size: 10px;
            color: #6a5820;
            letter-spacing: 0.5px;
        }

        @media (max-width: 600px) {
            .outer { padding: 0; }
            .header, .body, .footer { padding-left: 24px; padding-right: 24px; }
            .meta-row { padding: 16px 24px; flex-wrap: wrap; gap: 16px; }
            .meta-item { border-right: none; padding: 0; flex: none; width: 45%; }
            .header-right { display: none; }
        }
    </style>
</head>

<body>
<div class="outer">
<div class="wrapper">

    <div class="header">
        <div class="header-left">
            <div class="brand">{{ $formrequest->company->name ?? 'Asian Bay' }}</div>
            <div class="header-title">Form <em>Request</em><br>Approval</div>
        </div>
        <div class="header-right">
            <div class="doc-label">Document No.</div>
            <div class="doc-number">{{ $formrequest->document_number ?? '—' }}</div>
            <div class="type-tag">{{ $formrequest->requesttype->request_type_name ?? '—' }}</div>
        </div>
    </div>

    <div class="accent-bar"></div>

    <div class="meta-row">
        <div class="meta-item">
            <div class="meta-label">Submitted By</div>
            <div class="meta-value">{{ $formrequest->user->employee->employee_name ?? '—' }}</div>
        </div>
        <div class="meta-item">
            <div class="meta-label">NIP</div>
            <div class="meta-value">{{ $formrequest->user->employee->employee_pengenal ?? '—' }}</div>
        </div>
        <div class="meta-item">
            <div class="meta-label">Request Date</div>
            <div class="meta-value">{{ $requestDate }}</div>
        </div>
        <div class="meta-item">
            <div class="meta-label">Status</div>
            <div class="meta-value gold">{{ $formrequest->status }}</div>
        </div>
    </div>

    <div class="body">

        <div class="greeting">
            A <strong>new Form Request</strong> has been submitted and is awaiting your approval.
            Filed by <strong>{{ $formrequest->user->employee->employee_name ?? '—' }}</strong>
            (NIP: <strong>{{ $formrequest->user->employee->employee_pengenal ?? '—' }}</strong>).
            Please review the details below and take action accordingly.
        </div>

        <div class="section-title">Request Detail</div>
        <div class="detail-block">
            <div class="detail-row">
                <div class="detail-key">Title</div>
                <div class="detail-val">{{ $formrequest->title }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Applicant</div>
                <div class="detail-val">{{ $formrequest->user->employee->employee_name ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Request Date</div>
                <div class="detail-val">{{ $requestDate }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Deadline</div>
                <div class="detail-val">{{ $deadline }}</div>
            </div>
            @if ($formrequest->notes)
            <div class="detail-row">
                <div class="detail-key">Notes</div>
                <div class="detail-val muted">{{ $formrequest->notes }}</div>
            </div>
            @endif
            <div class="detail-row">
                <div class="detail-key">Status</div>
                <div class="detail-val">
                    <span class="status-chip">{{ $formrequest->status }}</span>
                </div>
            </div>
        </div>

        <div class="section-title">Item Details</div>
        <div class="table-outer">
            @isset($formrequest->requesttype)

                @if ($formrequest->requesttype->code === 'CA')
                <table class="items">
                    <thead>
                        <tr>
                            <th style="width:32px;" class="center">No.</th>
                            <th>Item</th>
                            <th class="right">Qty</th>
                            <th class="right">Unit Price</th>
                            <th class="right">Total</th>
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
                            <td class="right" style="white-space:nowrap; color:#555;">
                                {{ number_format($item->qty, 2, ',', '.') }} {{ $item->uom }}
                            </td>
                            <td class="right" style="white-space:nowrap; color:#555;">
                                Rp {{ number_format($item->price, 2, ',', '.') }}
                            </td>
                            <td class="right" style="white-space:nowrap; font-weight:600;">
                                Rp {{ number_format($item->qty * $item->price, 2, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="right">
                                <span class="total-label">Grand Total</span>
                            </td>
                            <td class="right grand-amount">
                                Rp {{ number_format($formrequest->total_amount, 2, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                @endif

                @if ($formrequest->requesttype->code === 'CAPEX')
                <table class="items">
                    <thead>
                        <tr>
                            <th style="width:32px;" class="center">No.</th>
                            <th>Item</th>
                            <th class="right">Qty</th>
                            <th class="right">UOM</th>
                            <th class="right">Vendor I</th>
                            <th class="right">Vendor II</th>
                            <th class="right">Vendor III</th>
                            <th class="right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formrequest->items as $index => $item)
                        @php $vendors = $capexVendors[$item->id] ?? collect(); @endphp
                        <tr>
                            <td class="no-col">{{ $index + 1 }}</td>
                            <td>
                                <div class="item-name">{{ $item->item_name }}</div>
                                @if ($item->specification)
                                    <div class="spec">{{ $item->specification }}</div>
                                @endif
                            </td>
                            <td class="right" style="color:#555;">
                                {{ number_format($item->qty, 2, ',', '.') }}
                            </td>
                            <td class="right" style="color:#555;">{{ $item->uom }}</td>
                            @for ($v = 0; $v < 3; $v++)
                            <td class="right">
                                @if (isset($vendors[$v]))
                                    <span style="font-weight:500; color:#333;">
                                        Rp {{ number_format($vendors[$v]['price'], 2, ',', '.') }}
                                    </span>
                                    <span class="vendor-name">{{ $vendors[$v]['vendor_name'] }}</span>
                                @else
                                    <span style="color:#ccc;">—</span>
                                @endif
                            </td>
                            @endfor
                            <td class="right" style="font-weight:600; white-space:nowrap;">
                                Rp {{ number_format(optional($item)->total_price ?? 0, 2, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="right">
                                <span class="total-label">Grand Total</span>
                            </td>
                            <td class="right grand-amount">
                                Rp {{ number_format($formrequest->total_amount, 2, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                @endif

            @endisset
        </div>

        <div class="cta-wrap">
            <a href="{{ $detailUrl }}" class="btn">View &amp; Process Request</a>
            <div class="cta-note">Click the button above to review and approve or reject this request</div>
        </div>

        <div class="disclaimer">
            This email was sent automatically. Please do not reply directly.<br>
            Need help? <a href="https://tix.asianbay.co.id">IT Ticketing — Asian Bay Development</a>
        </div>

    </div>

    <div class="footer">
        <div class="footer-left">&copy; {{ date('Y') }} PT Asian Bay Development &nbsp;&middot;&nbsp; Form Request System</div>
        <div class="footer-right">Asian Bay Development</div>
    </div>

</div>
</div>
</body>
</html> --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Approval Form Request</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: "Times New Roman", Times, serif;
            background-color: #f0ede6;
            color: #111;
            -webkit-text-size-adjust: 100%;
        }

        .wrapper {
            max-width: 800px;
            width: 100%;
            margin: 32px auto;
            background: #fff;
            border: 1px solid #ccc;
        }

        /* ── HEADER / KOP ── */
        .header {
            padding: 26px 40px 18px 40px;
            border-bottom: 2px solid #111;
        }

        .header-company {
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 0.3px;
            color: #111;
            margin-bottom: 2px;
        }

        .header-dept {
            font-size: 8.5px;
            color: #777;
            letter-spacing: 0.2px;
            margin-bottom: 10px;
        }

        .header-thin {
            border-top: 0.75px solid #bbb;
            margin-bottom: 10px;
        }

        .header-subject {
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1.5px;
            /* text-transform: uppercase; */
            color: #111;
        }

        /* ── BODY ── */
        .body {
            padding: 26px 40px;
        }

        .greeting {
            font-size: 13px;
            line-height: 1.85;
            color: #333;
            margin-bottom: 22px;
        }

        /* Section title */
        .section-title {
            font-size: 9px;
            font-weight: bold;
            /* text-transform: uppercase; */
            letter-spacing: 1.2px;
            color: #555;
            border-left: 2.5px solid #111;
            padding-left: 6px;
            margin-bottom: 8px;
        }

        /* Info block */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12.5px;
        }

        .info-table tr {
            border-bottom: 1px solid #eee;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table td {
            padding: 7px 10px;
            vertical-align: top;
        }

        .info-table .ik {
            width: 110px;
            color: #888;
            font-style: italic;
        }

        .info-table .ic {
            width: 12px;
            color: #888;
        }

        .info-table .iv {
            font-weight: bold;
            color: #111;
        }

        .info-wrap {
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }

        .badge {
            display: inline-block;
            padding: 1px 8px;
            background: #f0ede6;
            color: #111;
            border: 1px solid #bbb;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        /* Items table */
        .table-wrap {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            min-width: 560px;
        }

        table.items thead th {
            background: #e9e5dc;
            color: #111;
            padding: 8px 10px;
            text-align: left;
            font-size: 10.5px;
            font-weight: bold;
            border-bottom: 1px solid #bbb;
            white-space: nowrap;
        }

        table.items tbody tr:nth-child(even) {
            background: #f7f5f0;
        }

        table.items tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #eee;
            color: #222;
            vertical-align: top;
        }

        table.items tfoot td {
            padding: 8px 10px;
            font-weight: bold;
            color: #111;
            background: #e9e5dc;
            border-top: 1px solid #bbb;
            font-size: 12.5px;
        }

        .tr  { text-align: right; }
        .spec { font-size: 10.5px; color: #aaa; margin-top: 2px; font-style: italic; }

        /* CTA */
        .cta {
            text-align: center;
            padding: 4px 0 18px;
        }

        .btn {
            display: inline-block;
            padding: 10px 28px;
            background: #111;
            color: #fff !important;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1px;
            /* text-transform: uppercase; */
            font-family: "Times New Roman", Times, serif;
        }

        /* Note */
        .note {
            border: 1px solid #ddd;
            padding: 10px 14px;
            font-size: 11px;
            color: #999;
            line-height: 1.75;
            text-align: center;
            background: #fafaf8;
            font-style: italic;
        }

        .note a {
            color: #111;
            text-decoration: underline;
            font-weight: bold;
        }

        /* ── FOOTER ── */
        .footer {
            padding: 10px 40px;
            background: #f0ede6;
            border-top: 1px solid #ccc;
            font-size: 10.5px;
            color: #999;
            text-align: center;
            font-style: italic;
        }

        @media (max-width: 480px) {
            .wrapper { margin: 0; border: none; }
            .body { padding: 16px; }
            .header { padding: 16px; }
            .btn { display: block; text-align: center; }
        }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- ══ HEADER / KOP ══ -->
    <div class="header">
        <div class="header-company">{{ $formrequest->company->name ?? 'Asian Bay Development' }}</div>
        <div class="header-dept">Form Request Approval</div>
        <div class="header-thin">Document Number : {{ $formrequest->document_number ?? '—' }}</div>
        <div class="header-subject">{{ $formrequest->requesttype->request_type_name ?? '—' }}</div>
    </div>

    <!-- ══ BODY ══ -->
    <div class="body">

        <p class="greeting">
            Hello,<br>
            A <strong>new Form Request</strong> has been submitted and is awaiting your approval.
            Filed by <strong>{{ $formrequest->user->employee->employee_name ?? '—' }}</strong>
            Please review the details below and take action for this request:
        </p>

        <!-- Detail Request -->
        <div class="section-title">Request Detail</div>
        <div class="info-wrap">
            <table class="info-table">
                <tr>
                    <td class="ik">Title</td>
                    <td class="ic">:</td>
                    <td class="iv">{{ $formrequest->title }}</td>
                </tr>
                <tr>
                    <td class="ik">Applicant</td>
                    <td class="ic">:</td>
                    <td class="iv">{{ $formrequest->user->employee->employee_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="ik">Department</td>
                    <td class="ic">:</td>
                    <td class="iv">{{ $formrequest->user->employee->department->department_name ?? '-' }}</td>
                </tr>
                {{-- <tr>
                    <td class="ik">Location</td>
                    <td class="ic">:</td>
                    <td class="iv">{{ $formrequest->user->employee->store->name ?? '-' }}</td>
                </tr> --}}
                <tr>
                    <td class="ik">Request Date</td>
                    <td class="ic">:</td>
                    <td class="iv">{{$requestDate}}</td>
                </tr>
                <tr>
                    <td class="ik">Deadline</td>
                    <td class="ic">:</td>
                    {{-- <td class="iv">{{ Carbon::parse($formrequest->deadline)->translatedFormat('d F Y') }}</td> --}}
                    <td class="iv">{{ $deadline }}</td>

                </tr>
                @if($formrequest->notes)
                <tr>
                    <td class="ik">Applicant Notes</td>
                    <td class="ic">:</td>
                    <td class="iv" style="font-weight:normal; color:#444;">{{ $formrequest->notes }}</td>
                </tr>
                @endif
                @if ($formrequest->requesttype->code === 'CAPEX')
                <tr>
                    <td class="ik">Capex Type</td>
                    <td class="ic">:</td>
                    <td class="iv">{{ $formrequest->capextype->code }}</td>
                </tr>
                <tr>
                    <td class="ik">Assets</td>
                    <td class="ic">:</td>
                    <td class="iv">{{ $assetsLabel }}</td>
                </tr>
                @endif
                <tr>
                    <td class="ik">Status</td>
                    <td class="ic">:</td>
                    <td class="iv"><span class="badge">{{ $formrequest->status }}</span></td>
                </tr>
                {{-- <tr>
                    <td class="ik">Approved by Manager</td>
                    <td class="ic">:</td>
                    <td class="iv"><span class="badge">{{ $formrequest->approval->approver1}}</span></td>
                </tr>
                <tr>
                    <td class="ik">Approved At</td>
                    <td class="ic">:</td>
                    <td class="iv"><span class="badge">{{ $approved1_at}}</span></td>
                </tr> --}}
                {{-- @if($approved1)

                <tr>
        <td class="ik">Approved by Manager</td>
        <td class="ic">:</td>
        <td class="iv">
            <span class="badge">{{ $approved1}}</span>
        </td>
    </tr>
    <tr>
        <td class="ik">Approved At</td>
        <td class="ic">:</td>
        <td class="iv">
            <span class="badge">{{ $approved1_at }}</span>
        </td>
    </tr>
@endif --}}
@if(!empty($approver1) && $approver1 !== 'Not Approved yet' && $approver1 !== '-')
<tr>
    <td class="ik">Approved by Manager</td>
    <td class="ic">:</td>
    <td class="iv">
        <span class="badge">
            {{ $approver1 }}
            @if(!empty($approver1_at) && $approver1_at !== '-')
                <br><small>{{ $approver1_at }}</small>
            @endif
        </span>
    </td>
</tr>
@endif
            </table>
        </div>

        <!-- Rincian Item -->
        <div class="section-title">Item Details</div>
        <div class="table-wrap">
            {{-- <table class="items">
                <thead>
                    <tr>
                        <th style="width:28px">No</th>
                        <th>Items</th>
                        <th class="tr">Qty</th>
                        <th class="tr">Price</th>
                        <th class="tr">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($formrequest->items as $index => $item)
                    <tr>
                        <td style="color:#bbb; text-align:center;">{{ $index + 1 }}</td>
                        <td>
                            {{ $item->item_name }}
                            @if($item->specification)
                                <div class="spec">{{ $item->specification }}</div>
                            @endif
                        </td>
                        <td class="tr">{{ number_format($item->qty, 2, '.', ',') }} {{ $item->uom }}</td>
                        <td class="tr">Rp {{ number_format($item->price, 2, '.', ',') }}</td>
                        <td class="tr">Rp {{ number_format($item->qty * $item->price, 2, '.', ',') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="tr">Total Amount</td>
                        <td class="tr">Rp {{ number_format($formrequest->total_amount, 2, '.', ',') }}</td>
                    </tr>
                </tfoot>
            </table> --}}
            @isset($formrequest->requesttype)

                @if ($formrequest->requesttype->code === 'CA')
                <table class="items">
                    <thead>
                        <tr>
                            <th style="width:32px;" class="center">No.</th>
                            <th>Item</th>
                            <th class="right">Qty</th>
                            <th class="right">Unit Price</th>
                            <th class="right">Total</th>
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
                            <td class="right" style="white-space:nowrap; color:#555;">
                                {{ number_format($item->qty, 2, ',', '.') }} {{ $item->uom }}
                            </td>
                            <td class="right" style="white-space:nowrap; color:#555;">
                                Rp {{ number_format($item->price, 2, ',', '.') }}
                            </td>
                            <td class="right" style="white-space:nowrap; font-weight:600;">
                                Rp {{ number_format($item->qty * $item->price, 2, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="right">
                                <span class="total-label">Grand Total</span>
                            </td>
                            <td class="right grand-amount">
                                Rp {{ number_format($formrequest->total_amount, 2, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                @endif

                @if ($formrequest->requesttype->code === 'CAPEX')
                <table class="items">
                    <thead>
                        <tr>
                            <th style="width:32px;" class="center">No.</th>
                            <th>Item</th>
                            <th class="right">Qty</th>
                            <th class="right">UOM</th>
                            <th class="right">Vendor I</th>
                            <th class="right">Vendor II</th>
                            <th class="right">Vendor III</th>
                            {{-- <th class="right">Total</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formrequest->items as $index => $item)
                        @php $vendors = $capexVendors[$item->id] ?? collect(); @endphp
                        <tr>
                            <td class="no-col">{{ $index + 1 }}</td>
                            <td>
                                <div class="item-name">{{ $item->item_name }}</div>
                                {{-- @if ($item->specification)
                                    <div class="spec">{{ $item->specification }}</div>
                                @endif --}}
                            </td>
                            <td class="right" style="color:#555;">
                                {{ number_format($item->qty, 2, ',', '.') }}
                            </td>
                            <td class="right" style="color:#555;">{{ $item->uom }}</td>
                            @for ($v = 0; $v < 3; $v++)
                            <td class="right">
                                @if (isset($vendors[$v]))
                                    <span style="font-weight:500; color:#333;">
                                        Rp {{ number_format($vendors[$v]['price'], 2, ',', '.') }}
                                    </span>
                                    <span class="vendor-name">{{ $vendors[$v]['vendor_name'] }}</span>
                                @else
                                    <span style="color:#ccc;">—</span>
                                @endif
                            </td>
                            @endfor
                            {{-- <td class="right" style="font-weight:600; white-space:nowrap;">
                                Rp {{ number_format(optional($item)->total_price ?? 0, 2, ',', '.') }}
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <tr>
                            <td colspan="7" class="right">
                                <span class="total-label">Grand Total</span>
                            </td>
                            <td class="right grand-amount">
                                Rp {{ number_format($formrequest->total_amount, 2, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot> --}}
                </table>
                @endif

            @endisset
        </div>

        <!-- CTA -->
        <div class="cta">
            <a href="{{ $detailUrl }}" class="btn">Approve Now</a>
        </div>

        <!-- Note -->
        <div class="note">
            This email was sent automatically. Please do not reply directly.<br>
            Need help? <a href="https://tix.asianbay.co.id">IT Ticketing Asian Bay Development</a>
        </div>

    </div>

    <!-- ══ FOOTER ══ -->
    <div class="footer">
        &copy; {{ date('Y') }} PT Asian Bay Development &nbsp;&middot;&nbsp; Created by Edwin Sirait
    </div>

</div>

</body>
</html>