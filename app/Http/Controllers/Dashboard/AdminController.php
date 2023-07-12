<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Models\Admin;
use App\Traits\upload;
use Illuminate\Http\Request;
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
            ->rawColumns(['actions' => 'actions'/*, 'status' => 'status'*/])
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
}
