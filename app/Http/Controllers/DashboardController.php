<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Requesttype;
use App\Models\Requestitem;
use App\Models\Formrequest;
class DashboardController extends Controller
{
    public function dashboardPage()
    {
        $user = Auth::user();
            $requestTypes = RequestType::all();
            $uomOptions = Requestitem::getUomOptions();
        return view('pages.dashboard', compact(
            'user','requestTypes','uomOptions'
        ));
    }
    public function store(Request $request)
{
    $request->validate([
        'request_type_id' => 'required',
        'request_date' => 'required|date',
        'items' => 'required|array|min:1',
        'items.*.request' => 'required|string',
        'items.*.qty' => 'required|numeric|min:1',
        'items.*.uom' => 'required',
        'items.*.price' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {

        $formRequest = Formrequest::create([
            'request_type_id' => $request->request_type_id,
            'request_date' => $request->request_date,
            'user_id' => auth()->id(),
            'notes' => $request->notes,
            'vendor_id' => $request->vendor_id,
            'destination' => $request->destination,
            'deadline' => $request->deadline,
            'status' => 'draft'
        ]);
        $totalAmount = 0;
        foreach ($request->items as $item) {

            $total = $item['qty'] * $item['price'];

            Requestitem::create([
                'form_request_id' => $formRequest->id,
                'request' => $item['request'],
                'specification' => $item['specification'] ?? null,
                'qty' => $item['qty'],
                'uom' => $item['uom'],
                'price' => $item['price'],
                'total' => $total
            ]);

            $totalAmount += $total;
        }
       if ($request->hasFile('attachments')) {

    $files = $request->file('attachments');

    if (!is_array($files)) {
        $files = [$files];
    }

    foreach ($files as $file) {

        $path = $file->store('request-attachments');

        DB::table('form_request_attachments')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid7()->toString(),
            'form_request_id' => $formRequest->id,
            'file_path' => $path,
            'created_at' => now()
        ]);
    }
}

        $formRequest->update([
            'total_amount' => $totalAmount
        ]);

        DB::commit();

        return redirect()
            ->route('requests.index')
            ->with('success', 'Request created successfully');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());
    }
}
}
