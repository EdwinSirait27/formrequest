{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Approval Form Request</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            -webkit-text-size-adjust: 100%;
        }

        .wrapper {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            background: #fff;
        }

        /* Header */
        .header {
            background: #1C3D6E;
            padding: 20px 24px;
        }
        .header-top {
            font-size: 10px;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            margin-bottom: 6px;
        }
        .header h1 {
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.4;
        }

        /* Body */
        .body {
            padding: 24px;
        }

        .greeting {
            font-size: 13.5px;
            line-height: 1.75;
            color: #555;
            margin-bottom: 22px;
        }

        /* Section label */
        .label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: #1C3D6E;
            margin-bottom: 6px;
        }

        /* Info rows */
        .info-block {
            border: 1px solid #E0E0E0;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            font-size: 13px;
            border-bottom: 1px solid #F0F0F0;
        }
        .info-row:last-child { border-bottom: none; }
        .info-key {
            width: 130px;
            min-width: 130px;
            padding: 9px 12px;
            color: #999;
            background: #FAFAFA;
            border-right: 1px solid #F0F0F0;
        }
        .info-val {
            padding: 9px 12px;
            color: #222;
            font-weight: 500;
            flex: 1;
        }

        .badge {
            display: inline-block;
            padding: 1px 8px;
            background: #EBF0FA;
            color: #1C3D6E;
            border: 1px solid #C2D0EC;
            font-size: 11.5px;
            font-weight: 600;
        }

        /* Table */
        .table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 20px;
            border: 1px solid #E0E0E0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
            min-width: 460px;
        }
        thead th {
            background: #1C3D6E;
            color: #fff;
            padding: 9px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            white-space: nowrap;
        }
        tbody tr:nth-child(even) { background: #F8FAFB; }
        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #F0F0F0;
            color: #333;
            vertical-align: top;
        }
        tfoot td {
            padding: 9px 10px;
            font-weight: 700;
            color: #1C3D6E;
            background: #F0F4FA;
            border-top: 1px solid #C2D0EC;
            font-size: 13px;
        }
        .tr { text-align: right; }
        .spec { font-size: 11px; color: #aaa; margin-top: 2px; }

        /* CTA */
        .cta {
            text-align: center;
            padding: 4px 0 16px;
        }
        .btn {
            display: inline-block;
            padding: 11px 28px;
            background: #1C3D6E;
            color: #fff !important;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
        }

        /* Note */
        .note {
            background: #F8F8F8;
            border: 1px solid #E8E8E8;
            padding: 12px 16px;
            font-size: 11.5px;
            color: #aaa;
            line-height: 1.7;
            text-align: center;
        }
        .note a { color: #1C3D6E; text-decoration: none; font-weight: 600; }

        /* Footer */
        .footer {
            padding: 12px 24px;
            background: #F5F5F5;
            border-top: 1px solid #E0E0E0;
            font-size: 11px;
            color: #bbb;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .body { padding: 16px; }
            .header { padding: 16px; }
            .header h1 { font-size: 14px; }
            .info-key { width: 110px; min-width: 110px; font-size: 12px; }
            .info-val { font-size: 12px; }
            .btn { display: block; text-align: center; }
        }
    </style>
</head>
<body>

<div class="wrapper">

    <div class="header">
        <div class="header-top">PT Asian Bay Development</div>
        <h1>Purchase Request &mdash; Perlu Persetujuan</h1>
    </div>

    <div class="body">

        <p class="greeting">
            Halo,<br><br>
            Terdapat <strong>form request baru</strong> yang memerlukan persetujuan Anda. Berikut ringkasan detail pengajuan:
        </p>

        <p class="label">Detail Request</p>
        <div class="info-block">
            <div class="info-row">
                <div class="info-key">Judul</div>
                <div class="info-val">{{ $formrequest->title }}</div>
            </div>
            <div class="info-row">
                <div class="info-key">Pemohon</div>
                <div class="info-val">{{ $formrequest->user->employee->employee_name ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-key">Tanggal</div>
                <div class="info-val">{{ \Carbon\Carbon::parse($formrequest->request_date)->translatedFormat('d F Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-key">Deadline</div>
                <div class="info-val">{{ \Carbon\Carbon::parse($formrequest->deadline)->translatedFormat('d F Y') }}</div>
            </div>
            @if ($formrequest->notes)
            <div class="info-row">
                <div class="info-key">Catatan</div>
                <div class="info-val">{{ $formrequest->notes }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-key">Status</div>
                <div class="info-val"><span class="badge">{{ $formrequest->status }}</span></div>
            </div>
        </div>

        <p class="label">Rincian Item</p>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:28px">No</th>
                        <th>Item</th>
                        <th class="tr">Qty</th>
                        <th class="tr">Harga Satuan</th>
                        <th class="tr">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formrequest->items as $index => $item)
                    <tr>
                        <td style="color:#ccc">{{ $index + 1 }}</td>
                        <td>
                            {{ $item->item_name }}
                            @if ($item->specification)
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
            </table>
        </div>

        <div class="cta">
            <a href="{{ $detailUrl }}" class="btn">Lihat Detail &amp; Proses Request</a>
        </div>

        <div class="note">
            Email ini dikirim secara otomatis. Mohon untuk tidak membalas.<br>
            Bantuan teknis: <a href="https://tix.asianbay.co.id">IT Ticketing Asian Bay</a>
        </div>

    </div>

    <div class="footer">
        &copy; {{ date('Y') }} PT Asian Bay Development &nbsp;&middot;&nbsp; Created by Edwin Sirait
    </div>

</div>

</body>
</html> --}}
{{-- ini yang benar --}}
{{-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Approval Form Request</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            background-color: #f0ede6;
            color: #111;
            -webkit-text-size-adjust: 100%;
        }

        .wrapper {
            max-width: 620px;
            width: 100%;
            margin: 32px auto;
            background: #fff;
            border: 1px solid #ccc;
        }

        /* ── HEADER / KOP ── */
        .header {
            padding: 22px 28px 16px 28px;
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
            text-transform: uppercase;
            color: #111;
        }

        /* ── BODY ── */
        .body {
            padding: 22px 28px;
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
            text-transform: uppercase;
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
            min-width: 420px;
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

        .tr {
            text-align: right;
        }

        .spec {
            font-size: 10.5px;
            color: #aaa;
            margin-top: 2px;
            font-style: italic;
        }

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
            text-transform: uppercase;
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
            padding: 10px 28px;
            background: #f0ede6;
            border-top: 1px solid #ccc;
            font-size: 10.5px;
            color: #999;
            text-align: center;
            font-style: italic;
        }

        @media (max-width: 480px) {
            .wrapper {
                margin: 0;
                border: none;
            }

            .body {
                padding: 16px;
            }

            .header {
                padding: 16px;
            }

            .btn {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <!-- ══ HEADER / KOP ══ -->
        <div class="header">
            <div class="header-company">PT. Asian Bay Development</div>
            <div class="header-thin"></div>
            <div class="header-subject">Form Request &mdash; {{ $formrequest->requesttype->request_type_name }}</div>
        </div>

        <!-- ══ BODY ══ -->
        <div class="body">

            <p class="greeting">
                Hello,<br><br>
                There is<strong>new form request</strong> which requires approval.
                The following is a detailed summary of the application from
                {{ $formrequest->user->employee->employee_name ?? '-' }}
                NIP {{ $formrequest->user->employee->employee_pengenal ?? '-' }} :
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
                        <td class="ik">Request Date</td>
                        <td class="ic">:</td>
                        <td class="iv">{{ $requestDate }}</td>
                    </tr>
                    <tr>
                        <td class="ik">Deadline</td>
                        <td class="ic">:</td>
                        <td class="iv">{{ $deadline }}</td>
                    </tr>
                    @if ($formrequest->notes)
                        <tr>
                            <td class="ik">Notes</td>
                            <td class="ic">:</td>
                            <td class="iv" style="font-weight:normal; color:#444;">{{ $formrequest->notes }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="ik">Status</td>
                        <td class="ic">:</td>
                        <td class="iv"><span class="badge">{{ $formrequest->status }}</span></td>
                    </tr>
                </table>
            </div>

            <!-- Rincian Item -->
            <div class="section-title">Item Details</div>
            <div class="table-wrap">
                <table class="items">
                    <thead>
                        <tr>
                            <th style="width:28px">No.</th>
                            <th>Item</th>
                            <th class="tr">Qty</th>
                            <th class="tr">Unit Price</th>
                            <th class="tr">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formrequest->items as $index => $item)
                            <tr>
                                <td style="color:#bbb; text-align:center;">{{ $index + 1 }}</td>
                                <td>
                                    {{ $item->item_name }}
                                    @if ($item->specification)
                                        <div class="spec">{{ $item->specification }}</div>
                                    @endif
                                </td>
                                <td class="tr">{{ number_format($item->qty, 2, '.', ',') }} {{ $item->uom }}
                                </td>
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
                </table>
            </div>
            <!-- CTA -->
            <div class="cta">
                <a href="{{ $detailUrl }}" class="btn">View Details &amp; Request Process</a>
            </div>
            <!-- Note -->
            <div class="note">
                This email was sent automatically. Please do not reply..<br>
                Technical assistance: <a href="https://tix.asianbay.co.id">IT Ticketing Asian Bay Development</a>
            </div>
        </div>
        <!-- ══ FOOTER ══ -->
        <div class="footer">
            &copy; {{ date('Y') }} Form Request, PT Asian Bay Development &nbsp;&middot;&nbsp; Created by Edwin
            Sirait
        </div>
    </div>
</body>
</html> --}}
{{-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Approval Form Request</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "DM Sans", sans-serif;
            font-weight: 400;
            background-color: #f0ede6;
            color: #111;
            -webkit-text-size-adjust: 100%;
        }

        .wrapper {
            max-width: 600px;
            width: 100%;
            margin: 32px auto;
            background: #fff;
            border-radius: 4px;
            overflow: hidden;
            border: 1px solid #ddd;
        }

        /* ── HEADER ── */
        .header {
            padding: 28px 32px 24px;
            background: #111;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .header-company {
            font-family: "DM Serif Display", serif;
            font-size: 20px;
            color: #fff;
            letter-spacing: 0.2px;
        }

        .header-divider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 2px 0;
        }

        .header-subject {
            font-size: 10px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.45);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .type-pill {
            display: inline-block;
            margin-top: 2px;
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
            font-size: 12px;
            font-weight: 500;
            border-radius: 2px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            letter-spacing: 0.3px;
        }

        /* ── BODY ── */
        .body {
            padding: 28px 32px;
        }

        .greeting {
            font-size: 13.5px;
            line-height: 1.85;
            color: #555;
            margin-bottom: 28px;
        }

        .greeting strong {
            color: #111;
            font-weight: 600;
        }

        /* Section label */
        .section-label {
            font-size: 9.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.8px;
            color: #aaa;
            margin-bottom: 10px;
        }

        /* Info card */
        .card {
            border: 1px solid #e8e8e8;
            border-radius: 4px;
            margin-bottom: 24px;
            overflow: hidden;
        }

        .info-row {
            display: flex;
            align-items: baseline;
            padding: 10px 16px;
            border-bottom: 1px solid #f2f2f2;
            font-size: 12.5px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-key {
            width: 120px;
            flex-shrink: 0;
            color: #bbb;
            font-style: italic;
            font-size: 12px;
        }

        .info-sep {
            width: 16px;
            color: #ddd;
            flex-shrink: 0;
        }

        .info-val {
            color: #111;
            font-weight: 600;
            flex: 1;
        }

        .info-val.light {
            font-weight: 400;
            color: #555;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 10px;
            background: #f4f1ea;
            border: 1px solid #d8d4cc;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.4px;
            color: #555;
            border-radius: 2px;
        }

        /* Items table */
        .table-wrap {
            border: 1px solid #e8e8e8;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table.items thead th {
            background: #f7f5f0;
            color: #aaa;
            padding: 9px 14px;
            text-align: left;
            font-size: 9.5px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            border-bottom: 1px solid #e8e8e8;
        }

        table.items tbody tr {
            border-bottom: 1px solid #f5f5f5;
        }

        table.items tbody tr:last-child {
            border-bottom: none;
        }

        table.items tbody td {
            padding: 10px 14px;
            color: #333;
            vertical-align: top;
        }

        table.items tfoot td {
            padding: 11px 14px;
            font-weight: 600;
            color: #111;
            background: #f4f1ea;
            border-top: 1px solid #ddd;
            font-size: 12.5px;
        }

        .tr {
            text-align: right;
        }

        .no-col {
            color: #ccc;
            text-align: center;
            width: 28px;
        }

        .spec {
            font-size: 10.5px;
            color: #bbb;
            margin-top: 3px;
            font-style: italic;
            font-weight: 300;
        }

        .total-label {
            font-style: italic;
            color: #999;
            font-size: 11px;
            font-weight: 400;
        }

        /* CTA */
        .cta-wrap {
            text-align: center;
            padding: 4px 0 22px;
        }

        .btn {
            display: inline-block;
            padding: 12px 36px;
            background: #111;
            color: #fff !important;
            text-decoration: none;
            font-family: "DM Sans", sans-serif;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border-radius: 2px;
        }

        /* Note */
        .note {
            background: #fafaf8;
            border: 1px solid #ebebea;
            border-radius: 4px;
            padding: 12px 20px;
            font-size: 11px;
            color: #bbb;
            line-height: 1.85;
            text-align: center;
            font-style: italic;
        }

        .note a {
            color: #666;
            text-decoration: underline;
            font-weight: 500;
        }

        /* ── FOOTER ── */
        .footer {
            padding: 12px 32px;
            background: #f7f5f0;
            border-top: 1px solid #e8e5e0;
            font-size: 10px;
            color: #ccc;
            text-align: center;
            letter-spacing: 0.2px;
        }

        @media (max-width: 480px) {
            .wrapper {
                margin: 0;
                border-radius: 0;
            }

            .body,
            .header {
                padding: 18px;
            }

            .btn {
                display: block;
                text-align: center;
            }

            .info-key {
                width: 90px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <!-- ══ HEADER ══ -->
        <div class="header">
            <div class="header-company">{{ $formrequest->company->name }}</div>
            <hr class="header-divider" />
            <div class="header-subject">Form Request</div>
            <span class="type-pill">{{ $formrequest->requesttype->request_type_name }}</span>
        </div>

        <!-- ══ BODY ══ -->
        <div class="body">

            <p class="greeting">
                Hello,<br><br>
                There is a <strong>new form request</strong> that requires your approval.
                Below is a detailed summary of the application submitted by
                <strong>{{ $formrequest->user->employee->employee_name ?? '-' }}</strong>
                &mdash; NIP {{ $formrequest->user->employee->employee_pengenal ?? '-' }}.
            </p>

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
                            <th style="width:32px; text-align:center;">#</th>
                            <th>Item</th>
                            <th class="tr">Qty</th>
                            <th class="tr">Unit Price</th>
                            <th class="tr">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formrequest->items as $index => $item)
                            <tr>
                                <td class="no-col">{{ $index + 1 }}</td>
                                <td>
                                    {{ $item->item_name }}
                                    @if ($item->specification)
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
                            <td colspan="4" class="tr">
                                <span class="total-label">Grand Total</span>
                            </td>
                            <td class="tr">Rp {{ number_format($formrequest->total_amount, 2, '.', ',') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- CTA -->
            <div class="cta-wrap">
                <a href="{{ $detailUrl }}" class="btn">View Details &amp; Process Request</a>
            </div>

            <!-- Note -->
            <div class="note">
                This email was sent automatically. Please do not reply.<br>
                Need help? <a href="https://tix.asianbay.co.id">IT Ticketing Asian Bay Development</a>
            </div>

        </div>

        <!-- ══ FOOTER ══ -->
        <div class="footer">
            &copy; {{ date('Y') }} Form Request &nbsp;&middot;&nbsp; PT Asian Bay Development &nbsp;&middot;&nbsp; Created by Edwin Sirait
        </div>

    </div>
</body>

</html> --}}
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
                    {{-- <div class="company-logo-wrap"> --}}
                        {{-- <div class="company-icon">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7v10l10 5 10-5V7L12 2zm0 2.18L20 8.5v7L12 19.82 4 15.5v-7L12 4.18z"/>
                            </svg>
                        </div> --}}
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
                    A <strong>new form request</strong> has been submitted and is awaiting your approval.
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
                                <td class="tr qty-cell">{{ number_format($item->qty, 2, '.', ',') }} {{ $item->uom }}</td>
                                <td class="tr price-cell">Rp {{ number_format($item->price, 2, '.', ',') }}</td>
                                <td class="tr subtotal-cell">Rp {{ number_format($item->qty * $item->price, 2, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="tr">
                                <span class="total-label">Grand Total</span>
                            </td>
                            <td class="tr grand-total-amount">Rp {{ number_format($formrequest->total_amount, 2, '.', ',') }}</td>
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