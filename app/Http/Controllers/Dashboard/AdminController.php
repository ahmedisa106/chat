<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Models\Admin;
use App\Traits\upload;
use Illuminate\Http\Request;
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
        $data = DataTables::eloquent($admins)
            ->addIndexColumn()
            ->addColumn('actions', 'dashboard.partials.actions')
            ->addColumn('status', 'dashboard.pages.admins.status')
            ->rawColumns(['actions' => 'actions', 'status' => 'status'])
            ->skipTotalRecords()
            ->toJson();

        return $data;

    }

    public function store(AdminRequest $request)
    {
        $data = $request->safe()->except('photo');
        $data['password'] = bcrypt($request->password);
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->upload($request->photo, 'admins');
        }
        Admin::query()->create($data);

        return response()->json('Admin created successfully');
    }

    public function edit($id)
    {

    }

    public function update(Request $request, Admin $admin)
    {

    }

    public function getSortedAdmins()
    {
        $admins = Admin::query()->whereNot('admins.id', auth('admin')->id())
            ->select('admins.id', 'admins.name', 'admins.photo', 'admin_messages.created_at', 'admin_messages.message_id', 'messages.message')
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
            ->get()
            ->unique('id');

        $view = View::make('dashboard.pages.chat.admins_list', compact('admins'))->render();
        return response()->json($view);
    }
}
