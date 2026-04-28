<!DOCTYPE html>
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
                        <td class="iv">{{ $requestDate }}</td>
                    </tr>
                    <tr>
                        <td class="ik">Deadline</td>
                        <td class="ic">:</td>
                        {{-- <td class="iv">{{ Carbon::parse($formrequest->deadline)->translatedFormat('d F Y') }}</td> --}}
                        <td class="iv">{{ $deadline }}</td>

                    </tr>
                    @if ($formrequest->notes)
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
                    @if ($formrequest->requesttype->code === 'PR')
                    @if(!empty($document_type_name))
                        <tr>
                            <td class="ik">Document Type</td>
                            <td class="ic">:</td>
                            <td class="iv">{{ $document_type_name }}</td>
                        </tr>
                        @endif
                        @if(!empty($payment_type_payreq))
                        <tr>
                            <td class="ik">Payment Type </td>
                            <td class="ic">:</td>
                            <td class="iv">{{ $payment_type_payreq }}</td>
                        </tr>
                        @endif
                    @endif
                    <tr>
                        <td class="ik">Status</td>
                        <td class="ic">:</td>
                        <td class="iv"><span class="badge">{{ $formrequest->status }}</span></td>
                    </tr>
                   
                    @if (!empty($approver1) && $approver1 !== 'Not Approved yet' && $approver1 !== '-')
                        <tr>
                            <td class="ik">Approved by Manager</td>
                            <td class="ic">:</td>
                            <td class="iv">
                                <span class="badge">
                                    {{ $approver1 }}
                                    @if (!empty($approver1_at) && $approver1_at !== '-')
                                        <br><small>{{ $approver1_at }}</small>
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @endif
                     @if ($formrequest->requesttype->code === 'CAPEX')
                    @if(!empty($capex_approver))
                        <tr>
                           <td class="ik">Approved by PIC CAPEX</td>
                            <td class="ic">:</td>
                            <td class="iv">
                                <span class="badge">
                                    {{ $capex_approver }}
                                    @if (!empty($capex_approver_at) && $capex_approver_at !== '-')
                                        <br><small>{{ $capex_approver_at }}</small>
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @endif
                    @endif
                </table>
            </div>

            <!-- Rincian Item -->
            <div class="section-title">Item Details</div>
            <div class="table-wrap">
               
                @isset($formrequest->requesttype)

                    {{-- @if ($formrequest->requesttype->code === 'CA') --}}
                    @if (in_array($formrequest->requesttype->code, ['CA', 'PAYREQ','RE']))
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

                    @if (in_array($formrequest->requesttype->code, ['CAPEX', 'PR']))

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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($formrequest->items as $index => $item)
                                    @php 
    $vendors = ($capexpayreqVendors[$item->id] ?? collect())->values(); 
@endphp
                                    <tr>
                                        <td class="no-col">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="item-name">{{ $item->item_name }}</div>
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

                                    </tr>
                                @endforeach
                            </tbody>
                         
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
            &copy; {{ date('Y') }} Form Request &nbsp;&middot;&nbsp; PT Asian Bay Development &nbsp;&middot;&nbsp; Created by Edwin Sirait
        </div>

    </div>

</body>

</html>
