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
        $requestTypes = Requesttype::withCount([
            'requests as requests_count' => fn ($q) => $q->whereNotIn('status', ['rejected', 'cancelled'])
        ])->get();

        // Summary stats — adjust model/table names to your actual Request model
        // $stats = [
        //     'total'    => Formrequest::count(),
        //     'pending'  => Formrequest::where('status', 'pending')->count(),
        //     'approved' => Formrequest::where('status', 'approved')->count(),
        //     'rejected' => Formrequest::where('status', 'rejected')->count(),
        // ];
        $user = auth()->user();


    $stats = [
        'total'    => Formrequest::where('user_id', $user->id)->count(),
        'Submitted'  => Formrequest::where('user_id', $user->id)->where('status', 'Submitted')->count(),
        'approved' => Formrequest::where('user_id', $user->id)
    ->whereIn('status', ['Approved Manager', 'Approved Director'])
    ->count(),
        'rejected' => Formrequest::where('user_id', $user->id)
    ->whereIn('status', ['Rejected Manager', 'Rejected Director'])
    ->count(),    
    'Done' => Formrequest::where('user_id', $user->id)->where('status', 'Done')->count(),
    ];


        // Recent 10 requests, eager-load relations
        $recentRequests = Formrequest::where('user_id', $user->id)->with(['user.employee', 'requestType'])
            ->latest()
            ->take(10)
            ->get();

        return view('pages.dashboard', compact('requestTypes', 'stats', 'recentRequests'));
    }
//     public function store(Request $request)
// {
//     $request->validate([
//         'request_type_id' => 'required',
//         'request_date' => 'required|date',
//         'items' => 'required|array|min:1',
//         'items.*.request' => 'required|string',
//         'items.*.qty' => 'required|numeric|min:1',
//         'items.*.uom' => 'required',
//         'items.*.price' => 'required|numeric|min:0',
//     ]);

//     DB::beginTransaction();

//     try {

//         $formRequest = Formrequest::create([
//             'request_type_id' => $request->request_type_id,
//             'request_date' => $request->request_date,
//             'user_id' => auth()->id(),
//             'notes' => $request->notes,
//             'vendor_id' => $request->vendor_id,
//             'destination' => $request->destination,
//             'deadline' => $request->deadline,
//             'status' => 'draft'
//         ]);
//         $totalAmount = 0;
//         foreach ($request->items as $item) {

//             $total = $item['qty'] * $item['price'];

//             Requestitem::create([
//                 'form_request_id' => $formRequest->id,
//                 'request' => $item['request'],
//                 'specification' => $item['specification'] ?? null,
//                 'qty' => $item['qty'],
//                 'uom' => $item['uom'],
//                 'price' => $item['price'],
//                 'total' => $total
//             ]);

//             $totalAmount += $total;
//         }
//        if ($request->hasFile('attachments')) {

//     $files = $request->file('attachments');

//     if (!is_array($files)) {
//         $files = [$files];
//     }

//     foreach ($files as $file) {

//         $path = $file->store('request-attachments');

//         DB::table('form_request_attachments')->insert([
//             'id' => \Ramsey\Uuid\Uuid::uuid7()->toString(),
//             'form_request_id' => $formRequest->id,
//             'file_path' => $path,
//             'created_at' => now()
//         ]);
//     }
// }

//         $formRequest->update([
//             'total_amount' => $totalAmount
//         ]);

//         DB::commit();

//         return redirect()
//             ->route('requests.index')
//             ->with('success', 'Request created successfully');

//     } catch (\Exception $e) {

//         DB::rollBack();

//         return back()->with('error', $e->getMessage());
//     }
// }
}
