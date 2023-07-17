<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Models\Admin;
use App\Traits\upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    use upload;

    public function index()
    {
        return view('dashboard.pages.admins.index');
    }

    public function data()
    {
        $admins = Admin::query()->select(['id', 'name', 'email', 'status'])->latest('created_at');
        return DataTables::eloquent($admins)
            ->addIndexColumn()
            ->addColumn('actions', 'dashboard.partials.actions')
            ->addColumn('status', 'dashboard.pages.admins.status')
            ->rawColumns(['actions' => 'actions', 'status' => 'status'])
            ->skipTotalRecords()
            ->toJson();


    }

    public function store(AdminRequest $request)
    {
        Admin::query()->create($request->safe()->toArray());
        return response()->json('Admin created successfully');
    }

    public function edit($id)
    {

    }

    public function update(Request $request, Admin $admin)
    {

    }

    public function getSortedAdmins(Request $request)
    {
        $in_chat = (int)$request->in_chat;
        $partner_id = (int)$request->partner_id;
        $admins = Admin::query()->whereNot('admins.id', auth('admin')->id())
            ->select('admins.id', 'admins.name', 'admins.photo', 'admin_messages.created_at', 'admin_messages.message_id', 'messages.message', 'admin_messages.receiver_id', 'admin_messages.sender_id')
            ->leftJoin('admin_messages', function ($q) {
                $q->on('admins.id', 'admin_messages.sender_id')
                    ->where(function ($q) {
                        $q->where('admin_messages.sender_id', auth('admin')->id())
                            ->orWhere('admin_messages.receiver_id', auth('admin')->id());
                    })->where('admin_messages.type', 0)
                    ->orOn('admins.id', 'admin_messages.receiver_id')
                    ->where(function ($q) {
                        $q->where('admin_messages.sender_id', auth('admin')->id())
                            ->orWhere('admin_messages.receiver_id', auth('admin')->id());
                    })->where('admin_messages.type', 0);
            })
            ->leftJoin('messages', 'admin_messages.message_id', 'messages.id')
            ->orderByDesc('admin_messages.created_at')
            ->distinct()
            ->withCount('UnreadMessages as all_un_read_messages_count')
            ->withCount(['messages as un_read_messages_count' => function ($q) {
                $q->where('seen_status', 0)
                    ->where('receiver_id', auth('admin')->id());
            }])
            ->get()
            ->unique('id');


        $view = View::make('dashboard.pages.chat.admins_list', compact('admins', 'in_chat', 'partner_id'))->render();
        return response()->json($view);
    }
}
