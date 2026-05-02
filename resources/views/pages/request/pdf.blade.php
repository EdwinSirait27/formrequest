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
        #kop-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            margin: 0 36px;
            background: #fff;
            z-index: 100;
        }
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            padding-top: 28px;
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

        .kop-border {
            border-top: 2px solid #111;
            border-bottom: 0.75px solid #888;
            height: 4px;
            margin: 10px 0 0 0;
        }

        .page {
            padding: 128px 36px 28px 36px;
        }

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

        .form-title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 14px;
            color: #111;
        }

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

        .approval-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
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

        tr {
            page-break-inside: avoid;
        }

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

        @page {
            margin: 0;
        }

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
    <div id="page-number">
        Pages <span class="page-num"></span>
    </div>
    <div id="kop-fixed">
        <table class="kop-table">
            <colgroup>
                <col style="width:auto;">
                <col style="width:1px;">
                <col style="width:auto;">
            </colgroup>
            <tr>
                <td style="padding-right:14px; padding-top:28px; vertical-align:middle; width:1%;">
                    @if ($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo"
                            style="max-height:80px; max-width:110px; object-fit:contain; display:block;">
                    @endif
                </td>
                <td style="width:1px; padding:28px 14px 0; vertical-align:middle;">
                    <div style="width:1px; background:#999; height:72px;"></div>
                </td>
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
        <div class="kop-border"></div>
    </div>
    <div class="page">
        <div class="form-title">Form Request - {{ $request->requesttype->request_type_name }}</div>
        <table class="info-outer">
            <tr>
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
                            <td class="lbl">Mail</td>
                            <td class="col">:</td>
                            <td class="val">{{ $companymail ?? 'Empty'}}</td>
                        </tr>
                        <tr>
                            <td class="lbl">From</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->transfer }}</td>
                        </tr>
                    </table>
                </td>
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
                            <td class="val">{{ $request->vendor->vendor_name ?? 'Need Approval'}}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Bank Name</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->vendor->bank_name ?? 'Need Approval'}}</td>
                        </tr>
                        @isset($request->requesttype)
                            @if ($request->requesttype->code === 'CA')
                                <tr>
                                    <td class="lbl">CA No.</td>
                                    <td class="col">:</td>
                                    <td class="val">{{ $request->ca_number }}</td>
                                </tr>
                            @endif
                        @endisset
                    </table>
                </td>
            </tr>
        </table>
        @isset($request->requesttype)
            @if ($request->requesttype->code === 'CA')
                <table class="items-table">
                    <colgroup>
                        <col style="width:25px;">
                        <col style="width:auto;">
                        <col style="width:auto;">
                        <col style="width:60px;">
                        <col style="width:50px;">
                        <col style="width:90px;">
                        <col style="width:100px;">
                    </colgroup>
                    <thead>
                        <tr>
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
                                <td class="col-no center">{{ $i + 1 }}</td>
                                <td class="center">{{ $item->item_name }}</td>
                                <td class="center">{{ $item->specification }}</td>
                                <td class="center">{{ number_format($item->qty, 2, ',', '.') }}</td>
                                <td class="center">{{ $item->uom }}</td>
                                <td class="center">Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                <td class="center">Rp {{ number_format($item->total_price, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="center" style="letter-spacing:1px;">GRAND TOTAL</td>
                            <td class="right">Rp {{ number_format($total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        @if ($request->requesttype->code === 'CAPEX')
        <table class="items-table">
            <colgroup>
                <col style="width:25px;">
                <col style="width:auto;">
                <col style="width:60px;">
                <col style="width:50px;">
                <col style="width:90px;">
                <col style="width:90px;">
                <col style="width:90px;">
                <col style="width:100px;">
            </colgroup>
            <thead>
                <tr>
                    <th class="col-no">No.</th>
                    <th>Items</th>
                    <th>Qty</th>
                    <th>UOM</th>
                    <th>Vendor I</th>
                    <th>Vendor II</th>
                    <th>Vendor III</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($request->items as $i => $item)
                    @php $vendors = $capexVendors[$item->id] ?? collect(); @endphp
                    <tr>
                        <td class="col-no center">{{ $i + 1 }}</td>
                        <td class="center">{{ $item->item_name }}</td>
                        <td class="center">{{ number_format($item->qty, 2, ',', '.') }}</td>
                        <td class="center">{{ $item->uom }}</td>
                      
@for ($v = 0; $v < 3; $v++)
    <td class="center">
        @if (isset($vendors[$v]))
            Rp {{ number_format($vendors[$v]['price'], 2, ',', '.') }}<br>
            <small @if ($vendors[$v]['is_selected']) style="color: #1a7f3c; font-weight: bold;" @endif>
                {{ $vendors[$v]['vendor_name'] }}
            </small>
        @else
            -
        @endif
    </td>
@endfor
                        <td class="center">Rp {{ number_format($item->total_price, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="center" style="letter-spacing:1px;">GRAND TOTAL</td>
                    <td class="right">Rp {{ number_format($total, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    @endif
@endisset
        <table class="notes-wrap">
            <tr>
                <td>
                    <span class="notes-lbl">Purpose</span>
                    {{ $request->title }}
                </td>
            </tr>
        </table>
        <table class="notes-wrap">
            <tr>
                <td>
                    <span class="notes-lbl">Applcant Notes</span>
                    {{ $request->notes }}
                </td>
            </tr>
        </table>
         @isset($request->requesttype)
            @if ($request->requesttype->code === 'CAPEX')
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
                </td>
            </tr>
            <tr>
                <td class="ap-pos">{{ optional($request->user->employee->position)->name }}</td>
                <td class="ap-pos">{{ $positionName ?? 'Manager Department' }}</td>
                <td class="ap-pos">{{ $signatories['approver2']['position'] ?? 'Manager FAT / Head of FAT' }}</td>
                <td class="ap-pos"></td>
            </tr>
        </table>
        <br>
        <div class="fa-box">
            <span class="notes-lbl">FAT Notes : {{ $request->notes_fa }}</span>
        </div>
        <div class="fa-box2">
            <span class="notes-lbl2">Diretor Notes : {{ $request->notes_fa }}</span>
        </div>
        @if ($request->links && $request->links->count())
            <div style="margin-top:10px;">
                <span style="font-weight:bold;">Links Reference:</span>

                <ul style="margin-top:5px; padding-left:15px;">
                    @foreach ($request->links as $i => $link)
                        <li>
                            <a href="{{ $link->link }}" target="_blank" style="color:rgb(0, 0, 0);">
                                {{ $link->link }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="footer-note">
            * Purchases of less than or equal to IDR 1,000,000.00 are sufficient until the signature of the FAT
            Manager.<br>
            * Purchases above IDR 1,000,000.00 require the signature of the Head of FAT and Director.
        </div>
    </div>
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

        #kop-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            margin: 0 36px;
            background: #fff;
            z-index: 100;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
            padding-top: 28px;
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

        .kop-border {
            border-top: 2px solid #111;
            border-bottom: 0.75px solid #888;
            height: 4px;
            margin: 10px 0 0 0;
        }

        .page {
            padding: 128px 36px 28px 36px;
        }

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

        .form-title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 14px;
            color: #111;
        }

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

        .approval-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
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

        .fa-box3 {
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

        tr {
            page-break-inside: avoid;
        }

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

        @page {
            margin: 0;
        }

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
    <div id="page-number">
        Pages <span class="page-num"></span>
    </div>
    <div id="kop-fixed">
        <table class="kop-table">
            <colgroup>
                <col style="width:auto;">
                <col style="width:1px;">
                <col style="width:auto;">
            </colgroup>
            <tr>
                <td style="padding-right:14px; padding-top:28px; vertical-align:middle; width:1%;">
                    @if ($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo"
                            style="max-height:80px; max-width:110px; object-fit:contain; display:block;">
                    @endif
                </td>
                <td style="width:1px; padding:28px 14px 0; vertical-align:middle;">
                    <div style="width:1px; background:#999; height:72px;"></div>
                </td>
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
        <div class="kop-border"></div>
    </div>
    <div class="page">
        <div class="form-title">Form Request - {{ $request->requesttype->request_type_name }}</div>
        <table class="info-outer">
            <tr>
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
                            <td class="lbl">Mail</td>
                            <td class="col">:</td>
                            <td class="val">{{ $companymail ?? 'Empty' }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">From</td>
                            <td class="col">:</td>
                            <td class="val">{{ $requestcompany }}</td>
                        </tr>
                    </table>
                </td>
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
                            <td class="val">{{ $request->vendor->vendor_name ?? 'Need Approval' }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Bank Name</td>
                            <td class="col">:</td>
                            <td class="val">{{ $request->vendor->bank_name ?? 'Need Approval' }}</td>
                        </tr>
                        @isset($request->requesttype)
                            @if ($request->requesttype->code === 'CAPEX')
                                <tr>
                                    <td class="lbl">Capex Type</td>
                                    <td class="col">:</td>
                                    <td class="val">{{ $request->capextype->code ?? 'Need Approval' }}</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Assets</td>
                                    <td class="col">:</td>
                                    <td class="val">{{ $request->assets ?? 'Need Approval' }}</td>
                                </tr>
                            @endif
                        @endisset
                        @isset($request->requesttype)
                            @if ($request->requesttype->code === 'CA')
                                <tr>
                                    <td class="lbl">CA No.</td>
                                    <td class="col">:</td>
                                    <td class="val">{{ $request->ca_number }}</td>
                                </tr>
                            @endif
                        @endisset
                        @isset($request->requesttype)
                            @if ($request->requesttype->code === 'PAYRREQ')
                                <tr>
                                    <td class="lbl">Payment Type</td>
                                    <td class="col">:</td>
                                    <td class="val">{{ $request->payment_type_payreq }}</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Document Type</td>
                                    <td class="col">:</td>
                                    <td class="val">{{ $request->documenttype->document_type_name }}</td>
                                </tr>
                            @endif
                        @endisset
                    </table>
                </td>
            </tr>
        </table>
        @isset($request->requesttype)
            @if ($request->requesttype->code === 'CA')
                <table class="items-table">
                    <colgroup>
                        <col style="width:25px;">
                        <col style="width:auto;">
                        <col style="width:auto;">
                        <col style="width:60px;">
                        <col style="width:50px;">
                        <col style="width:90px;">
                        <col style="width:100px;">
                    </colgroup>
                    <thead>
                        <tr>
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
                                <td class="col-no center">{{ $i + 1 }}</td>
                                <td class="center">{{ $item->item_name }}</td>
                                <td class="center">{{ $item->specification }}</td>
                                <td class="center">{{ number_format($item->qty, 2, ',', '.') }}</td>
                                <td class="center">{{ $item->uom }}</td>
                                <td class="center">Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                <td class="center">Rp {{ number_format($item->total_price, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="center" style="letter-spacing:1px;">GRAND TOTAL</td>
                            <td class="right">Rp {{ number_format($total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            @endif
            @if ($request->requesttype->code === 'PAYREQ')
                <table class="items-table">
                    <colgroup>
                        <col style="width:25px;">
                        <col style="width:auto;">
                        <col style="width:auto;">
                        <col style="width:60px;">
                        <col style="width:50px;">
                        <col style="width:90px;">
                        <col style="width:100px;">
                    </colgroup>
                    <thead>
                        <tr>
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
                                <td class="col-no center">{{ $i + 1 }}</td>
                                <td class="center">{{ $item->item_name }}</td>
                                <td class="center">{{ $item->specification }}</td>
                                <td class="center">{{ number_format($item->qty, 2, ',', '.') }}</td>
                                <td class="center">{{ $item->uom }}</td>
                                <td class="center">Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                <td class="center">Rp {{ number_format($item->total_price, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="center" style="letter-spacing:1px;">GRAND TOTAL</td>
                            <td class="right">Rp {{ number_format($total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            @endif
            @if ($request->requesttype->code === 'CAPEX')
                <table class="items-table">
                    <colgroup>
                        <col style="width:25px;">
                        <col style="width:auto;">
                        <col style="width:60px;">
                        <col style="width:50px;">
                        <col style="width:90px;">
                        <col style="width:90px;">
                        <col style="width:90px;">
                        <col style="width:100px;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="col-no">No.</th>
                            <th>Items</th>
                            <th>Qty</th>
                            <th>UOM</th>
                            <th>Vendor I</th>
                            <th>Vendor II</th>
                            <th>Vendor III</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($request->items as $i => $item)
                            @php $vendors = $capexVendors[$item->id] ?? collect(); @endphp
                            <tr>
                                <td class="col-no center">{{ $i + 1 }}</td>
                                <td class="center">{{ $item->item_name }}</td>
                                <td class="center">{{ number_format($item->qty, 2, ',', '.') }}</td>
                                <td class="center">{{ $item->uom }}</td>

                                @for ($v = 0; $v < 3; $v++)
                                    <td class="center">
                                        @if (isset($vendors[$v]))
                                            Rp {{ number_format($vendors[$v]['price'], 2, ',', '.') }}<br>
                                            <small
                                                @if ($vendors[$v]['is_selected']) style="color: #1a7f3c; font-weight: bold;" @endif>
                                                {{ $vendors[$v]['vendor_name'] }}
                                            </small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endfor
                                <td class="center">Rp {{ number_format($item->total_price, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="center" style="letter-spacing:1px;">GRAND TOTAL</td>
                            <td class="right">Rp {{ number_format($total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            @endif
            @if ($request->requesttype->code === 'PR')
                <table class="items-table">
                    <colgroup>
                        <col style="width:25px;">
                        <col style="width:auto;">
                        <col style="width:60px;">
                        <col style="width:50px;">
                        <col style="width:90px;">
                        <col style="width:90px;">
                        <col style="width:90px;">
                        <col style="width:100px;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="col-no">No.</th>
                            <th>Items</th>
                            <th>Qty</th>
                            <th>UOM</th>
                            <th>Vendor I</th>
                            <th>Vendor II</th>
                            <th>Vendor III</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($request->items as $i => $item)
                            @php $vendors = $capexVendors[$item->id] ?? collect(); @endphp
                            <tr>
                                <td class="col-no center">{{ $i + 1 }}</td>
                                <td class="center">{{ $item->item_name }}</td>
                                <td class="center">{{ number_format($item->qty, 2, ',', '.') }}</td>
                                <td class="center">{{ $item->uom }}</td>

                                @for ($v = 0; $v < 3; $v++)
                                    <td class="center">
                                        @if (isset($vendors[$v]))
                                            Rp {{ number_format($vendors[$v]['price'], 2, ',', '.') }}<br>
                                            <small
                                                @if ($vendors[$v]['is_selected']) style="color: #1a7f3c; font-weight: bold;" @endif>
                                                {{ $vendors[$v]['vendor_name'] }}
                                            </small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endfor
                                <td class="center">Rp {{ number_format($item->total_price, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="center" style="letter-spacing:1px;">GRAND TOTAL</td>
                            <td class="right">Rp {{ number_format($total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        @endisset
        <table class="notes-wrap">
            <tr>
                <td>
                    <span class="notes-lbl">Purpose</span>
                    {{ $request->title }}
                </td>
            </tr>
        </table>
        <table class="notes-wrap">
            <tr>
                <td>
                    <span class="notes-lbl">Applcant Notes</span>
                    {{ $request->notes }}
                </td>
            </tr>
        </table>
        @isset($request->requesttype)
            @if ($request->requesttype->code === 'CA')
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
                        </td>
                    </tr>
                    <tr>
                        <td class="ap-pos">{{ optional($request->user->employee->position)->name }}</td>
                        <td class="ap-pos">{{ $positionName ?? 'Manager Department' }}</td>
                        <td class="ap-pos">{{ $signatories['approver2']['position'] ?? 'Manager FAT / Head of FAT' }}</td>
                        <td class="ap-pos"></td>
                    </tr>
                </table>
            @endif
            @if ($request->requesttype->code === 'PR')
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
                        </td>
                    </tr>
                    <tr>
                        <td class="ap-pos">{{ optional($request->user->employee->position)->name }}</td>
                        <td class="ap-pos">{{ $positionName ?? 'Manager Department' }}</td>
                        <td class="ap-pos">{{ $signatories['approver2']['position'] ?? 'Manager FAT / Head of FAT' }}</td>
                        <td class="ap-pos"></td>
                    </tr>
                </table>
            @endif
            @if ($request->requesttype->code === 'PAYREQ')
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
                        </td>
                    </tr>
                    <tr>
                        <td class="ap-pos">{{ optional($request->user->employee->position)->name }}</td>
                        <td class="ap-pos">{{ $positionName ?? 'Manager Department' }}</td>
                        <td class="ap-pos">{{ $signatories['approver2']['position'] ?? 'Manager FAT / Head of FAT' }}</td>
                        <td class="ap-pos"></td>
                    </tr>
                </table>
            @endif
            @if ($request->requesttype->code === 'RE')
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
                        </td>
                    </tr>
                    <tr>
                        <td class="ap-pos">{{ optional($request->user->employee->position)->name }}</td>
                        <td class="ap-pos">{{ $positionName ?? 'Manager Department' }}</td>
                        <td class="ap-pos">{{ $signatories['approver2']['position'] ?? 'Manager FAT / Head of FAT' }}</td>
                        <td class="ap-pos"></td>
                    </tr>
                </table>
            @endif
            {{-- @if ($request->requesttype->code === 'CAPEX')
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
                        </td>
                    </tr>
                    <tr>
                        <td class="ap-pos">{{ optional($request->user->employee->position)->name }}</td>
                        <td class="ap-pos">{{ $positionName ?? 'Manager Department' }}</td>
                        <td class="ap-pos">{{ $signatories['approver2']['position'] ?? 'Manager FAT / Head of FAT' }}</td>
                        <td class="ap-pos"></td>
                    </tr>
                </table>
            @endif --}}
            @if ($request->requesttype->code === 'CAPEX')
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
        {{-- Approver II → PIC CAPEX --}}
        <td class="ap-sign">
            @if ($picCapexSignatureBase64)
                <img src="{{ $picCapexSignatureBase64 }}" style="max-height:54px; max-width:88%;">
            @endif
        </td>
        {{-- Approver III → Director --}}
        <td class="ap-sign">
            @if ($signatories['approver2']['signature'])
                <img src="{{ $signatories['approver2']['signature'] }}" style="max-height:54px; max-width:88%;">
            @endif
        </td>
    </tr>
    <tr>
        <td class="ap-name">{{ optional($request->user->employee)->employee_name }}</td>
        <td class="ap-name">{{ $managerName ?? 'Manager Applicant / Department' }}</td>
        {{-- Approver II → PIC CAPEX --}}
        <td class="ap-name">{{ $picCapexName ?? 'PIC CAPEX' }}</td>
        {{-- Approver III → Director --}}
        <td class="ap-name">{{ $signatories['approver2']['name'] ?? 'Manager FAT / Head of FAT' }}</td>
    </tr>
    <tr>
        <td class="ap-pos">{{ optional($request->user->employee->position)->name }}</td>
        <td class="ap-pos">{{ $positionName ?? 'Manager Department' }}</td>
        {{-- Approver II → PIC CAPEX --}}
        <td class="ap-pos">{{ 'PIC CAPEX' }}</td>
        {{-- Approver III → Director --}}
        <td class="ap-pos">{{ $signatories['approver2']['position'] ?? 'Manager FAT / Head of FAT' }}</td>
    </tr>
</table>
@endif
        @endisset
        <br>
        <div class="fa-box">
            <span class="notes-lbl">FAT Notes : {{ $request->notes_fa }}</span>
        </div>
        @isset($request->requesttype)
            @if ($request->requesttype->code === 'CAPEX')
                <div class="fa-box2">
                    <span class="notes-lbl2">PIC CAPEX Notes : {{ $request->pic_capex_notes }}</span>
                </div>
            @endif
        @endisset

        <div class="fa-box3">
            <span class="notes-lbl2">Diretor Notes : {{ $request->notes_dir }}</span>
        </div>
        @if ($request->links && $request->links->count())
            <div style="margin-top:10px;">
                <span style="font-weight:bold;">Links Reference:</span>

                <ul style="margin-top:5px; padding-left:15px;">
                    @foreach ($request->links as $i => $link)
                        <li>
                            <a href="{{ $link->link }}" target="_blank" style="color:rgb(0, 0, 0);">
                                {{ $link->link }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="footer-note">
            * Purchases of less than or equal to IDR 1,000,000.00 are sufficient until the signature of the FAT
            Manager.<br>
            * Purchases above IDR 1,000,000.00 require the signature of the Head of FAT and Director.
        </div>
    </div>
</body>

</html>
