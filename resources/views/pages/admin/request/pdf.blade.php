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
                        <td class="center">{{ $item->qty }}</td>
                        <td class="center">{{ $item->uom }}</td>
                        <td class="right">{{ number_format($item->price, 2, ',', '.') }}</td>
                        <td class="right">{{ number_format($item->total_price, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="center bold" style="font-size:9px; letter-spacing:1px;">GRAND TOTAL</td>
                    <td class="right bold">Rp {{ number_format($total, 2, ',', '.') }}</td>
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
            <p>* Pembelian kurang dari atau sama dengan 1.000.000 cukup sampai ttd Manager FAT</p>
            <p>* Pembelian diatas 1.000.000 wajib beri ttd Head FAT dan Direktur</p>
        </div>
    </div>
</body>

</html>
