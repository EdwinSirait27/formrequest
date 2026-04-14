<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Requesttype;
use App\Models\Structuresnew;
use App\Models\User;
use App\Models\Employee;
use App\Models\Requestitem;
use App\Models\Formrequest;
class DashboardController extends Controller
{   
    // public function dashboardPage()
    // {
    //     $requestTypes = Requesttype::withCount([
    //         'requests as requests_count' => fn ($q) => $q->whereNotIn('status', ['rejected', 'cancelled'])
    //     ])->get();
    //     $user = auth()->user();
    // $stats = [
    //     'total'    => Formrequest::where('user_id', $user->id)->count(),
    //     'Submitted'  => Formrequest::where('user_id', $user->id)->where('status', 'Submitted')->count(),
    //     'approved' => Formrequest::where('user_id', $user->id)
    // ->whereIn('status', ['Approved Manager', 'Approved Director'])
    // ->count(),
    //     'rejected' => Formrequest::where('user_id', $user->id)
    // ->whereIn('status', ['Rejected Manager', 'Rejected Director'])
    // ->count(),    
    // 'Done' => Formrequest::where('user_id', $user->id)->where('status', 'Done')->count(),
    // ];


    //     $recentRequests = Formrequest::where('user_id', $user->id)->with(['user.employee', 'requestType'])
    //         ->latest()
    //         ->take(10)
    //         ->get();
    //         if ($user->hasRole('manager')) {

    // $employee = $user->employee;
    // $userIds = collect();

    // if ($employee && $employee->structure_id) {
    //     $structure = Structuresnew::with('allChildren')->find($employee->structure_id);

    //     if ($structure) {
    //         $structureIds = $structure->getAllIds();
    //         $employeeIds  = Employee::whereIn('structure_id', $structureIds)->pluck('id');
    //         $userIds      = User::whereIn('employee_id', $employeeIds)->pluck('id');
    //     }
    // }

    // // Base query dengan logic yang sama seperti index
    // $baseQuery = Formrequest::where(function ($q) use ($userIds) {
    //     // Non-CAPEX: Submitted & Approved Manager dari bawahan
    //     $q->where(function ($q1) use ($userIds) {
    //         $q1->whereIn('user_id', $userIds)
    //            ->whereIn('status', ['Submitted', 'Approved Manager'])
    //            ->whereHas('requestType', fn($rt) => $rt->where('code', '!=', 'CAPEX'));
    //     })
    //     // CAPEX: hanya Submitted dari bawahan
    //     ->orWhere(function ($q2) use ($userIds) {
    //         $q2->whereIn('user_id', $userIds)
    //            ->where('status', 'Submitted')
    //            ->whereHas('requestType', fn($rt) => $rt->where('code', 'CAPEX'));
    //     })
    //     // CAPEX Approved Manager: yang capexType-nya milik manager ini
    //     ->orWhere(function ($q3) {
    //         $q3->where('status', 'Approved Manager')
    //            ->whereHas('requestType', fn($rt) => $rt->where('code', 'CAPEX'))
    //            ->whereHas('capexType', fn($ct) => $ct->where('user_id', auth()->id()));
    //     });
    // });

    // // Hitung stats dari base query yang sama
    // $statusCounts = (clone $baseQuery)
    //     ->selectRaw('status, COUNT(*) as count')
    //     ->groupBy('status')
    //     ->pluck('count', 'status');

    // $stats = [
    //     'total'    => (clone $baseQuery)->count(),
    //     'pending'  => (clone $baseQuery)->where('status', 'Submitted')->count(),
    //     'approved' => (clone $baseQuery)->where('status', 'Approved Manager')->count(),
    //     'rejected' => Formrequest::whereIn('user_id', $userIds)
    //                     ->whereIn('status', ['Rejected Manager', 'Rejected Director'])
    //                     ->count(),
    //     'Done'     => Formrequest::whereIn('user_id', $userIds)
    //                     ->where('status', 'Done')
    //                     ->count(),
    // ];

    // $recentRequests = (clone $baseQuery)
    //     ->with(['user.employee', 'requestType'])
    //     ->latest()
    //     ->take(10)
    //     ->get();

    //     return view('pages.dashboard', compact('requestTypes', 'stats', 'recentRequests'));
    // }
    public function dashboardPage()
{
    $user = auth()->user();

    $requestTypes = Requesttype::withCount([
        'requests as requests_count' => fn ($q) => $q->whereNotIn('status', ['rejected', 'cancelled'])
    ])->get();

    if ($user->hasRole('manager')) {

        $employee = $user->employee;
        $userIds  = collect();
        if ($employee && $employee->structure_id) {
            $structure = Structuresnew::with('allChildren')->find($employee->structure_id);

            if ($structure) {
                $structureIds = $structure->getAllIds();
                $employeeIds  = Employee::whereIn('structure_id', $structureIds)->pluck('id');
                $userIds      = User::whereIn('employee_id', $employeeIds)->pluck('id');
            }
        }

        // Tambahkan user manager itu sendiri
        $userIds = $userIds->push($user->id)->unique();

        $baseQuery = Formrequest::where(function ($q) use ($userIds) {
            $q->where(function ($q1) use ($userIds) {
                $q1->whereIn('user_id', $userIds)
                   ->whereIn('status', ['Submitted', 'Approved Manager'])
                   ->whereHas('requestType', fn($rt) => $rt->where('code', '!=', 'CAPEX'));
            })
            ->orWhere(function ($q2) use ($userIds) {
                $q2->whereIn('user_id', $userIds)
                   ->where('status', 'Submitted')
                   ->whereHas('requestType', fn($rt) => $rt->where('code', 'CAPEX'));
            })
            ->orWhere(function ($q3) {
                $q3->where('status', 'Approved Manager')
                   ->whereHas('requestType', fn($rt) => $rt->where('code', 'CAPEX'))
                   ->whereHas('capexType', fn($ct) => $ct->where('user_id', auth()->id()));
            });
        });

        $stats = [
            'total'    => (clone $baseQuery)->count(),
            'pending'  => (clone $baseQuery)->where('status', 'Submitted')->count(),
            'approved' => (clone $baseQuery)->where('status', 'Approved Manager')->count(),
            'rejected' => Formrequest::whereIn('user_id', $userIds)
                            ->whereIn('status', ['Rejected Manager', 'Rejected Director'])
                            ->count(),
            'Done'     => Formrequest::whereIn('user_id', $userIds)
                            ->where('status', 'Done')
                            ->count(),
        ];

        $recentRequests = (clone $baseQuery)
            ->with(['user.employee', 'requestType'])
            ->latest()
            ->take(10)
            ->get();

    } elseif ($user->hasRole('user|admin')) {

        $statusCounts = Formrequest::where('user_id', $user->id)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $stats = [
            'total'     => $statusCounts->sum(),
            'Submitted' => $statusCounts->get('Submitted', 0),
            'approved'  => $statusCounts->get('Approved Manager', 0) + $statusCounts->get('Approved Director', 0),
            'rejected'  => $statusCounts->get('Rejected Manager', 0) + $statusCounts->get('Rejected Director', 0),
            'Done'      => $statusCounts->get('Done', 0),
        ];

        $recentRequests = Formrequest::where('user_id', $user->id)
            ->with(['user.employee', 'requestType'])
            ->latest()
            ->take(10)
            ->get();

    } else {
        // Fallback jika role tidak dikenali
        $stats          = ['total' => 0, 'pending' => 0, 'approved' => 0, 'rejected' => 0, 'Done' => 0];
        $recentRequests = collect();
    }

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
