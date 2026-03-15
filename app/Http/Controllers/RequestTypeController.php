<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Requesttype;
use Illuminate\Support\Facades\Log;
class RequestTypeController extends Controller
{
     public function index()
    {
        return view('pages.requesttype.requesttype');
    }
    public function getRequesttypes(Request $request)
    {
        $query = Requesttype::select([
            'id',
            'request_type_name',
            'code',
            ]);
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($requesttype) {
                $idHashed = substr(hash('sha256', $requesttype->id . env('APP_KEY')), 0, 8);
                {
                    $editBtn = '
            <a href="' . route('editrequesttype', $idHashed) . '"
               class="inline-flex items-center justify-center p-2
                      text-slate-500 hover:text-indigo-600
                      hover:bg-indigo-50 rounded-full transition"
               title="Edit Ticket: ' . e($requesttype->request_type_name) . '">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.862 3.487a2.1 2.1 0 013.001 2.949
                             L7.125 19.174 3 21l1.826-4.125
                             L16.862 3.487z" />
                </svg>
            </a>';
                }
                $showBtn = '
        <a href="' . route('showrequesttype', $idHashed) . '"
           class="inline-flex items-center justify-center p-2
                  text-slate-500 hover:text-emerald-600
                  hover:bg-emerald-50 rounded-full transition"
           title="Show Ticket: ' . e($requesttype->request_type_name) . '">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 12s3.75-6.75 9.75-6.75
                         S21.75 12 21.75 12
                         18 18.75 12 18.75
                         2.25 12 2.25 12z" />
                <circle cx="12" cy="12" r="3.25" />
            </svg>
        </a>';
                return $editBtn . $showBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function edit($hash)
    {
        $requesttype = Requesttype::all()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
        abort_if(!$requesttype, 404);
        return view('pages.requesttype.editrequesttype', compact('requesttype'));
    }
    public function show($hash)
    {
        $requesttype = Requesttype::all()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
        abort_if(!$requesttype, 404);
        return view('pages.requesttype.showrequesttype', compact('requesttype'));
    }
    public function create()
    {
        return view('pages.requesttype.createrequesttype');
    }
    public function update(Request $request, $hash)
    {
        $requesttype = Requesttype::all()->first(function ($v) use ($hash) {
            return substr(hash('sha256', $v->id . config('app.key')), 0, 8) === $hash;
        });

        abort_if(!$requesttype, 404);

        $validated = $request->validate([
            'request_type_name' => 'required|string|max:255|unique:request_type,request_type_name,' . $requesttype->id,
            'code' => 'required|string|max:255|unique:request_type,code,' . $requesttype->id,
        ]);

        $requesttype->update($validated);

        return redirect()
            ->route('requesttype')
            ->with('success', 'Request Type Updated Successfully');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_type_name' => 'required|string|max:255|unique:request_type,request_type_name',
            'code' => 'required|string|max:255|unique:request_type,code',
           
        ]);
        Requesttype::create($validated);
        return redirect()
            ->route('requesttype')
            ->with('success', 'Request Type Created Successfully');
    }
}
