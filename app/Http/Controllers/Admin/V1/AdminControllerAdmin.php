<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Service\Admin\V1\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isInstanceOf;

class AdminControllerAdmin extends Controller
{

    public function index()
    {
        $admins = Admin::query()->paginate(2);
        $items = collect($admins->items())->map(function ($item){
           return[
             $this->transformAdmin($item)
           ] ;
        });
        return ApiResponseClass::apiResponse(true,'admin retrieved successfully',[
            'items' => $items,
            'meta' => [
                'total' => $admins->total(),
                'current_page' => $admins->currentPage(),
                'per_page' => $admins->perPage(),
                'last_page' => $admins->lastPage()
            ]
        ],200);
    }

    public function show(Admin $admin)
    {
        return ApiResponseClass::apiResponse(true,'Admin retrieved successfully',$this->transformAdmin($admin),200);
    }

    public function store(Request $request)
    {
        $validation = AdminService::validationStore($request);
        if ($validation->fails())
        {
            return ApiResponseClass::errorResponse('validation is fail',$validation->errors(),422);
        }
        $admin = Admin::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $admin->assignRole($request->role);
        return ApiResponseClass::apiResponse(true,'admin created successfully',$admin,201);

    }

    public function update(Request $request,Admin $admin)
    {
        $validation = AdminService::validationUpdate($request);
        if ($validation->fails())
        {
            return ApiResponseClass::errorResponse('validation is fail',$validation->errors(),422);
        }
        $admin->update($request->all());
        return ApiResponseClass::apiResponse(true,'Admin retrieved Successfully',$this->transformAdmin($admin),200);
    }

    public function destroy(Admin $admin)
    {
        return ApiResponseClass::apiResponse(true,'admin deleted successfully',$admin->delete(),200);
    }

    public function transformAdmin($item)
    {
        return[
            'id' => $item->id,
            'name' => $item->name,
            'email' => $item->email,
            'password' => $item->password,
        ];
    }
}
