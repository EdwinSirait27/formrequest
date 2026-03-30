{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $request->requesttype->request_type_name }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 8.5px;
            background: #fff;
            color: #000;
        }
        .page {
            padding: 20px 28px 20px 28px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 3px 5px;
            font-size: 8.5px;
            overflow: hidden;
            word-break: break-word;
            vertical-align: middle;
        }

        .no-border td {
            border: none;
            padding: 2px 4px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .info-td {
            border: none;
            padding: 1px 2px;
            vertical-align: left;
        }

        .approval-sign {
            height: 60px;
            vertical-align: bottom;
            text-align: center;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <div class="page">

        <table style="margin-bottom:8px;">
            <colgroup>
                <col style="width:15%;">
                <col>
                <col style="width:16%;">
                <col style="width:22%;">
            </colgroup>
            <tr>
                <td rowspan="3" class="center" style="vertical-align:middle; padding:6px;">
                    @if ($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Company Logo"
                            style="max-height:100px; max-width:100%; object-fit:contain;">
                    @endif
                </td>
                <td class="center bold" style="font-size:10px;">
                    {{ $request->user->employee->company->name }}
                </td>
                <td style="padding:3px 5px;">Document No.</td>
                <td style="padding:3px 5px;">{{ $request->document_number }}</td>
            </tr>
            <tr>
                <td class="center bold" style="font-size:11px; letter-spacing:1px;">CASH ADVANCE FORM</td>
                <td style="padding:3px 5px;">Revision No.</td>
                <td style="padding:3px 5px;">{{ $request->revision_number }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding:3px 5px;">Issued Date</td>
                <td style="padding:3px 5px;">{{ $requestDate }}</td>
            </tr>
        </table>
        <table style="margin-bottom:8px; border-collapse:collapse;">
            <colgroup>
                <col style="width:13%;">
                <col style="width:2%;">
                <col style="width:28%;">
                <col style="width:13%;">
                <col style="width:2%;">
                <col>
            </colgroup>
            <tr>
                <td class="info-td">Employee : </td>
                <td class="info-td">{{ $request->user->employee->employee_name }}</td>
                <td class="info-td">Request Date : </td>
                <td class="info-td">{{ $requestDate }}</td>
            </tr>
            <tr>
                <td class="info-td">Position : </td>
                <td class="info-td">{{ $request->user->employee->position->name }}</td>
                <td class="info-td">Deadline : </td>
                <td class="info-td">{{ $Deadline }}</td>
            </tr>
            <tr>
                <td class="info-td">Departement : </td>
                <td class="info-td">{{ $request->user->employee->department->department_name }}</td>
                <td class="info-td">Towards : </td>
                <td class="info-td">{{ $request->vendor->vendor_name }}</td>
            </tr>
            <tr>
                <td class="info-td">NPWP : </td>
                <td class="info-td">{{ $request->vendor->npwp }}</td>
                <td class="info-td">Bank Name : </td>
                <td class="info-td">{{ $request->vendor->bank_name }}</td>
            </tr>
            <tr>
                <td class="info-td">From : </td>
                <td class="info-td">{{ $request->transfer }}</td>
                <td class="info-td">CA NO. : </td>
                <td class="info-td">{{ $request->document_number }}</td>
            </tr>
        </table>

        <table style="margin-bottom:8px;">
            <colgroup>
                <col style="width:5%;">
                <col style="width:25%;">
                <col style="width:20%;">
                <col style="width:7%;">
                <col style="width:10%;">
                <col style="width:16.5%;">
                <col style="width:16.5%;">
            </colgroup>
            <thead>
                <tr>
                    <th class="center">No</th>
                    <th class="center">Items</th>
                    <th class="center">Specification</th>
                    <th class="center">Qty</th>
                    <th class="center">UOM</th>
                    <th class="center">Unit Price</th>
                    <th class="center">Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($request->items as $i => $item)
                    <tr>
                        <td class="center">{{ $i + 1 }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->specification }}</td>
                        <td class="center">{{ number_format($item->qty, 2, '.', ',') }}</td>
                        <td class="center">{{ $item->uom }}</td>
                        <td class="right">{{ number_format($item->price, 2, '.', ',') }}</td>
                        <td class="right">{{ number_format($item->total_price, 2, '.', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="center bold" style="font-size:9px; letter-spacing:1px;">GRAND TOTAL</td>
                    <td class="right bold">Rp {{ number_format($total, 2, '.', ',') }}</td>
                </tr>
            </tfoot>
        </table>

        <table style="margin-bottom:6px;">
            <tr>
                <td style="padding:4px 6px; font-size:8.5px;">
                    This Budget Request is intended for/will be allocated to : {{ $request->title }}
                </td>
            </tr>
        </table>

        <table style="margin-bottom:8px; border-collapse:collapse;">
            <colgroup>
                <col style="width:1%;">
                <col style="width:1%;">
                <col>
            </colgroup>

            <tr>
                <td class="info-td">Notes Requester : {{ $request->notes }}</td>
            </tr>
        </table>

        <table style="margin-bottom:6px;">
            <colgroup>
                <col style="width:25%;">
                <col style="width:25%;">
                <col style="width:25%;">
                <col style="width:25%;">
            </colgroup>
            <tr>
                <td class="center bold" style="font-size:8.5px; padding:4px;">Request by,</td>
                <td class="center bold" style="font-size:8.5px; padding:4px;">Approve I</td>
                <td class="center bold" style="font-size:8.5px; padding:4px;">Approve II</td>
                <td class="center bold" style="font-size:8.5px; padding:4px;"></td>
            </tr>
            <tr>
                <td class="approval-sign" style="height:65px;">
                    @if ($signatureBase64)
                        <img src="{{ $signatureBase64 }}" style="max-height:55px; max-width:90%;">
                    @endif
                </td>
                <td class="approval-sign" style="height:65px;">
                    @if ($managerSignatureBase64)
                        <img src="{{ $managerSignatureBase64 }}" style="max-height:55px; max-width:90%;">
                    @endif
                </td>
                <td style="height:65px;"></td>
                <td style="height:65px;"></td>
            </tr>
            <tr>
                <td class="center" style="font-size:8.5px; padding:3px;">
                    {{ optional($request->user->employee)->employee_name }}
                </td>
                <td class="center" style="font-size:8.5px; padding:3px;">
                    {{ $managerName ?? 'Manager Requester / Department' }}</td>
                <td class="center" style="font-size:8.5px; padding:3px;">FAT Directors / AM</td>
                <td class="center" style="font-size:8.5px; padding:3px;"></td>
            </tr>
            <tr>
                <td class="center" style="font-size:8.5px; padding:3px;">
                    {{ optional($request->user->employee->position)->name }}
                </td>
                <td class="center" style="font-size:8.5px; padding:3px;">{{ $positionName ?? 'Manager Department' }}
                </td>
                <td class="center" style="font-size:8.5px; padding:3px;">FAT Departments</td>
                <td class="center" style="font-size:8.5px; padding:3px;"></td>
            </tr>
        </table>
        <table style="margin-bottom:6px;">
            <tr>
                <td style="height:45px; vertical-align:top; padding:4px 6px; font-size:8.5px;">Catatan FA :</td>
            </tr>
        </table>
        <div style="margin-top:4px; font-size:7.5px; line-height:1.6;">
            <p><strong>Note:</strong></p>
            <p>* Pembelian kurang dari atau sama dengan 1,000,000.00 cukup sampai ttd Manager FAT</p>
            <p>* Pembelian diatas 1.000.000 wajib beri ttd Head FAT dan Direktur</p>
        </div>
    </div>
</body>

</html> --}}
{{-- ini final belum ada pginasi dan header muncul setiap halaman --}}
{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $request->requesttype->request_type_name }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 9px;
            background: #fff;
            color: #111;
        }

        /* ══════════════════════════════════════════
           KOP SURAT — fixed di atas setiap halaman
           ══════════════════════════════════════════ */
        #kop-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            /* Sesuaikan margin kiri-kanan dengan .page */
            margin: 0 36px;
            background: #fff;
            z-index: 100;
        }

        /* ── KOP TABLE ── */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            padding-top: 28px; /* top margin halaman */
        }

        .kop-table td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .kop-company {
            font-size: 15px;
            font-weight: bold;
            color: #111;
            letter-spacing: 0.3px;
            margin-bottom: 3px;
            line-height: 1.2;
        }

        .kop-sub {
            font-size: 8px;
            color: #555;
            margin-bottom: 5px;
        }

        .kop-docrows td {
            border: none;
            padding: 1px 0;
            font-size: 8.5px;
            color: #333;
            vertical-align: middle;
        }

        .kop-docrows .dl { color: #555; width: 78px; }
        .kop-docrows .dc { width: 14px; color: #333; }
        .kop-docrows .dv { font-weight: bold; color: #111; }

        /* Garis bawah kop */
        .kop-border {
            border-top: 2px solid #111;
            border-bottom: 0.75px solid #888;
            height: 4px;
            margin: 10px 0 0 0; /* margin-bottom ditiadakan; diatur lewat page-top-padding */
        }

        /* ══════════════════════════════════════════
           KONTEN UTAMA
           ══════════════════════════════════════════ */
        .page {
            /*
             * padding-top harus >= tinggi #kop-fixed agar konten
             * tidak tertimpa kop. Ukur tinggi kop Anda lalu sesuaikan.
             * Estimasi: kop (~100px) + kop-border (~14px) = ~114px.
             * Tambah sedikit ruang: set 128px.
             */
            padding: 128px 36px 28px 36px;
        }

        /* ── INFO FIELDS ── */
        .info-outer {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .info-outer > tbody > tr > td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .info-block {
            width: 100%;
            border-collapse: collapse;
        }

        .info-block td {
            border: none;
            padding: 2.5px 0;
            font-size: 9px;
            vertical-align: top;
        }

        .info-block .lbl { width: 76px; color: #555; }
        .info-block .col { width: 12px; color: #555; text-align: center; }
        .info-block .val {
            font-weight: bold;
            color: #111;
            border-bottom: 0.5px solid #ccc;
            padding-bottom: 1px;
        }

        /* ── JUDUL ── */
        .form-title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 14px;
            color: #111;
        }

        /* ── ITEMS TABLE ── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            table-layout: fixed;
        }

        .items-table th {
            background: #e9e5dc;
            color: #111;
            font-size: 8.5px;
            font-weight: bold;
            text-align: center;
            padding: 4px 5px;
            border: 1px solid #888;
        }

        .items-table td {
            border: 1px solid #bbb;
            padding: 3px 5px;
            font-size: 8.5px;
            vertical-align: middle;
        }

        .items-table tbody tr:nth-child(even) td {
            background: #f7f5f0;
        }

        .items-table tfoot td {
            border: 1px solid #888;
            background: #e9e5dc;
            font-weight: bold;
            font-size: 9px;
            padding: 4px 5px;
        }

        /* Ulangi header kolom tabel di halaman baru */
        .items-table thead {
            display: table-header-group;
        }

        .center { text-align: center; }
        .right   { text-align: right; }
        .bold    { font-weight: bold; }

        /* ── NOTES ── */
        .notes-wrap {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .notes-wrap td {
            border: 1px solid #bbb;
            padding: 5px 7px;
            font-size: 8.5px;
            vertical-align: top;
        }

        .notes-lbl {
            font-weight: bold;
            font-size: 8px;
            color: #444;
            display: block;
            margin-bottom: 2px;
        }

        /* ── APPROVAL ── */
        .approval-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .approval-table td {
            border: 1px solid #999;
            font-size: 8.5px;
            text-align: center;
            padding: 3px 4px;
            vertical-align: bottom;
        }

        .ap-head {
            background: #e9e5dc;
            font-weight: bold;
            font-size: 8.5px;
            vertical-align: middle !important;
            height: 20px;
        }

        .ap-sign {
            height: 64px;
            vertical-align: bottom !important;
        }

        .ap-name {
            font-weight: bold;
            font-size: 8.5px;
            border-top: 0.5px solid #aaa;
            padding: 2px 4px !important;
            vertical-align: middle !important;
        }

        .ap-pos {
            font-size: 8px;
            color: #555;
            font-style: italic;
            padding: 2px 4px !important;
            vertical-align: middle !important;
        }

        /* ── FA NOTES ── */
        .fa-box {
            border: 1px solid #bbb;
            padding: 5px 7px;
            min-height: 42px;
            font-size: 8.5px;
            margin-bottom: 10px;
        }

        /* ── FOOTER ── */
        .footer-note {
            border-top: 0.75px solid #ccc;
            padding-top: 5px;
            font-size: 7.5px;
            color: #666;
            line-height: 1.8;
            font-style: italic;
        }

        /* Hindari baris terpotong di tengah halaman */
        tr { page-break-inside: avoid; }
    </style>
</head>
<body>

    <!-- ══ KOP SURAT — tampil di setiap halaman ══ -->
    <div id="kop-fixed">
        <table class="kop-table">
            <colgroup>
                <col style="width:auto;">
                <col style="width:1px;">
                <col style="width:auto;">
            </colgroup>
            <tr>
                <!-- Logo -->
                <td style="padding-right:14px; padding-top:28px; vertical-align:middle; width:1%;">
                    @if ($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo"
                             style="max-height:80px; max-width:110px; object-fit:contain; display:block;">
                    @endif
                </td>

                <!-- Garis vertikal -->
                <td style="width:1px; padding:28px 14px 0; vertical-align:middle;">
                    <div style="width:1px; background:#999; height:72px;"></div>
                </td>

                <!-- Info Perusahaan + Doc Info -->
                <td style="vertical-align:top; padding-top:30px;">
                    <div class="kop-company">{{ $request->user->employee->company->name }}</div>
                    <div class="kop-sub">Finance &amp; Administration Department</div>
                    <table class="kop-docrows">
                        <tr>
                            <td class="dl">Document No.</td>
                            <td class="dc">:</td>
                            <td class="dv">{{ $request->document_number }}</td>
                        </tr>
                        <tr>
                            <td class="dl">Revision No.</td>
                            <td class="dc">:</td>
                            <td class="dv">{{ $request->revision_number }}</td>
                        </tr>
                        <tr>
                            <td class="dl">Issued Date</td>
                            <td class="dc">:</td>
                            <td class="dv">{{ $requestDate }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Garis bawah kop -->
        <div class="kop-border"></div>
    </div>
    <!-- ══ END KOP SURAT ══ -->


    <!-- ══ KONTEN UTAMA ══ -->
    <div class="page">

        <!-- JUDUL -->
        <div class="form-title">Cash Advance Form</div>

        <!-- INFO PEMOHON -->
        <table class="info-outer">
            <tr>
                <!-- Kiri -->
                <td style="width:48%; padding-right:16px;">
                    <table class="info-block">
                        <tr>
                            <td class="lbl">Employee</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->user->employee->employee_name }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Position</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->user->employee->position->name }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Department</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->user->employee->department->department_name }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">NPWP</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->vendor->npwp }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">From</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->transfer }}</td>
                        </tr>
                    </table>
                </td>

                <!-- Kanan -->
                <td style="width:52%;">
                    <table class="info-block">
                        <tr>
                            <td class="lbl">Request Date</td>
                            <td class="col">:</td>
                            <td class="val">{{ $requestDate }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Deadline</td>
                            <td class="col">:</td>
                            <td class="val">{{ $Deadline }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Towards</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->vendor->vendor_name }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Bank Name</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->vendor->bank_name }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">CA No.</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->document_number }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- TABEL ITEM -->
        <table class="items-table">
            <colgroup>
                <col style="width:5%;">
                <col style="width:24%;">
                <col style="width:20%;">
                <col style="width:7%;">
                <col style="width:9%;">
                <col style="width:17.5%;">
                <col style="width:17.5%;">
            </colgroup>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Items</th>
                    <th>Specification</th>
                    <th>Qty</th>
                    <th>UOM</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($request->items as $i => $item)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->specification }}</td>
                    <td class="center">{{ number_format($item->qty, 2, '.', ',') }}</td>
                    <td class="center">{{ $item->uom }}</td>
                    <td class="right">{{ number_format($item->price, 2, '.', ',') }}</td>
                    <td class="right">{{ number_format($item->total_price, 2, '.', ',') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="center" style="letter-spacing:1px;">GRAND TOTAL</td>
                    <td class="right">Rp {{ number_format($total, 2, '.', ',') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- TUJUAN -->
        <table class="notes-wrap">
            <tr>
                <td>
                    <span class="notes-lbl">Tujuan / Purpose</span>
                    {{ $request->title }}
                </td>
            </tr>
        </table>

        <!-- CATATAN PEMOHON -->
        <table class="notes-wrap">
            <tr>
                <td>
                    <span class="notes-lbl">Catatan Pemohon / Notes</span>
                    {{ $request->notes }}
                </td>
            </tr>
        </table>

        <!-- APPROVAL -->
        <table class="approval-table">
            <tr>
                <td class="ap-head">Request by</td>
                <td class="ap-head">Approve I</td>
                <td class="ap-head">Approve II</td>
                <td class="ap-head">&nbsp;</td>
            </tr>
            <tr>
                <td class="ap-sign">
                    @if ($signatureBase64)
                        <img src="{{ $signatureBase64 }}" style="max-height:54px; max-width:88%;">
                    @endif
                </td>
                <td class="ap-sign">
                    @if ($managerSignatureBase64)
                        <img src="{{ $managerSignatureBase64 }}" style="max-height:54px; max-width:88%;">
                    @endif
                </td>
                <td class="ap-sign"></td>
                <td class="ap-sign"></td>
            </tr>
            <tr>
                <td class="ap-name">{{ optional($request->user->employee)->employee_name }}</td>
                <td class="ap-name">{{ $managerName ?? 'Manager Requester / Department' }}</td>
                <td class="ap-name">FAT Directors / AM</td>
                <td class="ap-name">&nbsp;</td>
            </tr>
            <tr>
                <td class="ap-pos">{{ optional($request->user->employee->position)->name }}</td>
                <td class="ap-pos">{{ $positionName ?? 'Manager Department' }}</td>
                <td class="ap-pos">FAT Departments</td>
                <td class="ap-pos">&nbsp;</td>
            </tr>
        </table>

        <!-- CATATAN FA -->
        <div class="fa-box">
            <span class="notes-lbl">Catatan FA :</span>
        </div>

        <!-- FOOTER -->
        <div class="footer-note">
            * Pembelian kurang dari atau sama dengan Rp 1.000.000,00 cukup sampai tanda tangan Manager FAT.<br>
            * Pembelian di atas Rp 1.000.000,00 wajib tanda tangan Head FAT dan Direktur.
        </div>

    </div>
    <!-- ══ END KONTEN UTAMA ══ -->

</body>
</html> --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $request->requesttype->request_type_name }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 9px;
            background: #fff;
            color: #111;
        }

        /* ══════════════════════════════════════════
           KOP SURAT — fixed di atas setiap halaman
           ══════════════════════════════════════════ */
        #kop-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            /* Sesuaikan margin kiri-kanan dengan .page */
            margin: 0 36px;
            background: #fff;
            z-index: 100;
        }

        /* ── KOP TABLE ── */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            padding-top: 28px;
            /* top margin halaman */
        }

        .kop-table td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .kop-company {
            font-size: 15px;
            font-weight: bold;
            color: #111;
            letter-spacing: 0.3px;
            margin-bottom: 3px;
            line-height: 1.2;
        }

        .kop-sub {
            font-size: 8px;
            color: #555;
            margin-bottom: 5px;
        }

        .kop-docrows td {
            border: none;
            padding: 1px 0;
            font-size: 8.5px;
            color: #333;
            vertical-align: middle;
        }

        .kop-docrows .dl {
            color: #555;
            width: 78px;
        }

        .kop-docrows .dc {
            width: 14px;
            color: #333;
        }

        .kop-docrows .dv {
            font-weight: bold;
            color: #111;
        }

        /* Garis bawah kop */
        .kop-border {
            border-top: 2px solid #111;
            border-bottom: 0.75px solid #888;
            height: 4px;
            margin: 10px 0 0 0;
            /* margin-bottom ditiadakan; diatur lewat page-top-padding */
        }

        /* ══════════════════════════════════════════
           KONTEN UTAMA
           ══════════════════════════════════════════ */
        .page {
            /*
             * padding-top harus >= tinggi #kop-fixed agar konten
             * tidak tertimpa kop. Ukur tinggi kop Anda lalu sesuaikan.
             * Estimasi: kop (~100px) + kop-border (~14px) = ~114px.
             * Tambah sedikit ruang: set 128px.
             */
            padding: 128px 36px 28px 36px;
        }

        /* ── INFO FIELDS ── */
        .info-outer {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .info-outer>tbody>tr>td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .info-block {
            width: 100%;
            border-collapse: collapse;
        }

        .info-block td {
            border: none;
            padding: 2.5px 0;
            font-size: 9px;
            vertical-align: top;
        }

        .info-block .lbl {
            width: 76px;
            color: #555;
        }

        .info-block .col {
            width: 12px;
            color: #555;
            text-align: center;
        }

        .info-block .val {
            font-weight: bold;
            color: #111;
            border-bottom: 0.5px solid #ccc;
            padding-bottom: 1px;
        }

        /* ── JUDUL ── */
        .form-title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 14px;
            color: #111;
        }

        /* ── ITEMS TABLE ── */
        /* .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            table-layout: fixed;
        } */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .items-table th {
            background: #e9e5dc;
            color: #111;
            font-size: 8.5px;
            font-weight: bold;
            text-align: center;
            padding: 4px 5px;
            border: 1px solid #888;
        }

        .items-table td {
            border: 1px solid #bbb;
            padding: 3px 5px;
            font-size: 8.5px;
            vertical-align: middle;
        }

        .items-table tbody tr:nth-child(even) td {
            background: #f7f5f0;
        }

        .items-table tfoot td {
            border: 1px solid #888;
            background: #e9e5dc;
            font-weight: bold;
            font-size: 9px;
            padding: 4px 5px;
        }

        /* Ulangi header kolom tabel di halaman baru */
        .items-table thead {
            display: table-header-group;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        /* ── NOTES ── */
        .notes-wrap {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .notes-wrap td {
            border: 1px solid #bbb;
            padding: 5px 7px;
            font-size: 8.5px;
            vertical-align: top;
        }

        .notes-lbl {
            font-weight: bold;
            font-size: 8px;
            color: #444;
            display: block;
            margin-bottom: 2px;
        }

        .notes-lbl2 {
            font-weight: bold;
            font-size: 8px;
            color: #444;
            display: block;
            margin-bottom: 2px;
        }

        /* ── APPROVAL ── */
        /* .approval-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        } */
        .approval-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* WAJIB */
            margin-bottom: 2px;

        }

        .approval-table td {
            border: 1px solid #999;
            font-size: 8.5px;
            text-align: center;
            padding: 3px 4px;
            vertical-align: bottom;
        }

        .ap-head {
            background: #e9e5dc;
            font-weight: bold;
            font-size: 8.5px;
            vertical-align: middle !important;
            height: 20px;
        }

        .ap-sign {
            height: 64px;
            vertical-align: bottom !important;
        }

        .ap-name {
            font-weight: bold;
            font-size: 8.5px;
            border-top: 0.5px solid #aaa;
            padding: 2px 4px !important;
            vertical-align: middle !important;
        }

        .ap-pos {
            font-size: 8px;
            color: #555;
            font-style: italic;
            padding: 2px 4px !important;
            vertical-align: middle !important;
        }

        /* ── FA NOTES ── */
        .fa-box {
            border: 1px solid #bbb;
            padding: 5px 7px;
            min-height: 42px;
            font-size: 8.5px;
            margin-bottom: 10px;
        }

        .fa-box2 {
            border: 1px solid #bbb;
            padding: 5px 7px;
            min-height: 42px;
            font-size: 8.5px;
            margin-bottom: 10px;
        }

        /* ── FOOTER ── */
        .footer-note {
            border-top: 0.75px solid #ccc;
            padding-top: 5px;
            font-size: 7.5px;
            color: #666;
            line-height: 1.8;
            font-style: italic;
        }

        /* Hindari baris terpotong di tengah halaman */
        tr {
            page-break-inside: avoid;
        }

        /* ── PAGE NUMBER ── */
        #page-number {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            margin: 0 36px;
            text-align: right;
            font-size: 8px;
            color: #666;
            font-style: italic;
            border-top: 0.5px solid #ccc;
            padding-top: 4px;
        }

        /* Counter CSS untuk Dompdf / wkhtmltopdf */
        @page {
            margin: 0;
        }

        /*
         * Dompdf: gunakan CSS content counter
         * Ini hanya aktif di Dompdf — wkhtmltopdf pakai JS di bawah
         */
        .page-num::before {
            content: counter(page);
        }

        .page-count::before {
            content: counter(pages);
        }

        .col-no {
            width: 25px !important;
            max-width: 25px !important;
            min-width: 25px !important;
            padding: 2px !important;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- ══ PAGE NUMBER — tampil di setiap halaman ══ -->
    {{-- <div id="page-number">
        Pages <span class="page-num"></span> from <span class="page-count"></span>
    </div> --}}
    <div id="page-number">
        Pages <span class="page-num"></span>
    </div>

    <!-- ══ KOP SURAT — tampil di setiap halaman ══ -->
    <div id="kop-fixed">
        <table class="kop-table">
            <colgroup>
                <col style="width:auto;">
                <col style="width:1px;">
                <col style="width:auto;">
            </colgroup>
            <tr>
                <!-- Logo -->
                <td style="padding-right:14px; padding-top:28px; vertical-align:middle; width:1%;">
                    @if ($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo"
                            style="max-height:80px; max-width:110px; object-fit:contain; display:block;">
                    @endif
                </td>

                <!-- Garis vertikal -->
                <td style="width:1px; padding:28px 14px 0; vertical-align:middle;">
                    <div style="width:1px; background:#999; height:72px;"></div>
                </td>

                <!-- Info Perusahaan + Doc Info -->
                <td style="vertical-align:top; padding-top:30px;">
                    <div class="kop-company">{{ $request->company->name }}</div>
                    <div class="kop-sub">Form Request - {{ $request->requesttype->request_type_name }}</div>
                    <table class="kop-docrows">
                        <tr>
                            <td class="dl">Document No.</td>
                            <td class="dc">:</td>
                            <td class="dv">{{ $request->document_number }}</td>
                        </tr>
                        <tr>
                            <td class="dl">Revision No.</td>
                            <td class="dc">:</td>
                            <td class="dv">{{ $request->revision_number }}</td>
                        </tr>
                        <tr>
                            <td class="dl">Issued Date</td>
                            <td class="dc">:</td>
                            <td class="dv">{{ $requestDate }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Garis bawah kop -->
        <div class="kop-border"></div>
    </div>
    <!-- ══ END KOP SURAT ══ -->


    <!-- ══ KONTEN UTAMA ══ -->
    <div class="page">

        <!-- JUDUL -->
        <div class="form-title">Form Request - {{ $request->requesttype->request_type_name }}</div>

        <!-- INFO PEMOHON -->
        <table class="info-outer">
            <tr>
                <!-- Kiri -->
                <td style="width:48%; padding-right:16px;">
                    <table class="info-block">
                        <tr>
                            <td class="lbl">Applicant</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->user->employee->employee_name }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Position</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->user->employee->position->name }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Department</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->user->employee->department->department_name }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">NPWP</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->vendor->npwp }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">From</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->transfer }}</td>
                        </tr>
                    </table>
                </td>

                <!-- Kanan -->
                <td style="width:52%;">
                    <table class="info-block">
                        <tr>
                            <td class="lbl">Request Date</td>
                            <td class="col">:</td>
                            <td class="val">{{ $requestDate }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Deadline</td>
                            <td class="col">:</td>
                            <td class="val">{{ $Deadline }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Towards</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->vendor->vendor_name }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Bank Name</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->vendor->bank_name }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">CA No.</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->ca_number }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- TABEL ITEM -->
        <table class="items-table">
            <colgroup>
                {{-- <col style="width:1%;">
                <col style="width:24%;">
                <col style="width:20%;">
                <col style="width:1%;">
                <col style="width:1%;">
                <col style="width:17.5%;">
                <col style="width:17.5%;"> --}}
                {{-- <colgroup> --}}
                <col style="width:25px;"> <!-- FIXED PIXEL -->
                <col style="width:auto;">
                <col style="width:auto;">
                <col style="width:60px;">
                <col style="width:50px;">
                <col style="width:90px;">
                <col style="width:100px;">
                {{-- </colgroup> --}}
            </colgroup>
            <thead>
                <tr>

                    {{-- <th>No</th> --}}
                    <th class="col-no">No.</th>
                    <th>Items</th>
                    <th>Specification</th>
                    <th>Qty</th>
                    <th>UOM</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($request->items as $i => $item)
                    <tr>
                        {{-- <td class="center">{{ $i + 1 }}</td> --}}
                        <td class="col-no center">{{ $i + 1 }}</td>
                        <td class="center">{{ $item->item_name }}</td>
                        <td class="center">{{ $item->specification }}</td>
                        <td class="center">{{ number_format($item->qty, 2, '.', ',') }}</td>
                        <td class="center">{{ $item->uom }}</td>
                        <td class="center">Rp {{ number_format($item->price, 2, '.', ',') }}</td>
                        <td class="center">Rp {{ number_format($item->total_price, 2, '.', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="center" style="letter-spacing:1px;">GRAND TOTAL</td>
                    <td class="right">Rp {{ number_format($total, 2, '.', ',') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- TUJUAN -->
        <table class="notes-wrap">
            <tr>
                <td>
                    <span class="notes-lbl">Purpose</span>
                    {{ $request->title }}
                </td>
            </tr>
        </table>

        <!-- CATATAN PEMOHON -->
        <table class="notes-wrap">
            <tr>
                <td>
                    <span class="notes-lbl">Applcant Notes</span>
                    {{ $request->notes }}
                </td>
            </tr>
        </table>

        <!-- APPROVAL -->
        <table class="approval-table">
            <tr>
                <td class="ap-head">Request by</td>
                <td class="ap-head">Approver I</td>
                <td class="ap-head">Approver II</td>
                <td class="ap-head">Approver III</td>
            </tr>
            <tr>
                <td class="ap-sign">
                    @if ($signatureBase64)
                        <img src="{{ $signatureBase64 }}" style="max-height:54px; max-width:88%;">
                    @endif
                </td>
                <td class="ap-sign">
                    @if ($managerSignatureBase64)
                        <img src="{{ $managerSignatureBase64 }}" style="max-height:54px; max-width:88%;">
                    @endif
                </td>
                <td class="ap-sign">
                    @if ($signatories['approver2']['signature'])
                        <img src="{{ $signatories['approver2']['signature'] }}"
                            style="max-height:54px; max-width:88%;"><br>
                    @endif
                </td>
                <td class="ap-sign"></td>
            </tr>
            <tr>
                <td class="ap-name">{{ optional($request->user->employee)->employee_name }}</td>
                <td class="ap-name">{{ $managerName ?? 'Manager Applicant / Department' }}</td>
                <td class="ap-name">{{ $signatories['approver2']['name'] ?? 'Manager FAT / Head of FAT' }}
                </td>
                <td class="ap-name">
                    {{-- {{ collect([$signatories['headfat']['name'] ?? null, $signatories['astfat']['name'] ?? null])->filter()->implode(' || ') ?:
                        '-' }} --}}
                </td>
                {{-- <td class="ap-name"></td> --}}
            </tr>
            <tr>
                <td class="ap-pos">{{ optional($request->user->employee->position)->name }}</td>
                <td class="ap-pos">{{ $positionName ?? 'Manager Department' }}</td>
                <td class="ap-pos">{{ $signatories['approver2']['position'] ?? 'Manager FAT / Head of FAT' }}</td>
                <td class="ap-pos"></td>
            </tr>
        </table>
        <br>
        <!-- CATATAN FA -->
        <div class="fa-box">
            <span class="notes-lbl">FAT Notes : {{ $request->notes_fa }}</span>
        </div>
        <div class="fa-box2">
            <span class="notes-lbl2">Diretor Notes : {{ $request->notes_fa }}</span>
        </div>

        <!-- FOOTER -->
        <div class="footer-note">
            * Purchases of less than or equal to IDR 1,000,000.00 are sufficient until the signature of the FAT
            Manager.<br>
            * Purchases above IDR 1,000,000.00 require the signature of the Head of FAT and Director.
        </div>

    </div>
    <!-- ══ END KONTEN UTAMA ══ -->
    {{-- <script>
    (function () {
        var nums  = document.querySelectorAll('.page-num');
        var tots  = document.querySelectorAll('.page-count');
        if (typeof window.pageNum !== 'undefined') {
            for (var i = 0; i < nums.length; i++) nums[i].textContent  = window.pageNum;
            for (var j = 0; j < tots.length; j++) tots[j].textContent = window.pageCount;
        }
    })();
</script> --}}
</body>

</html>
