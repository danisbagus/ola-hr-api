<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\DDLRequest;
use App\Http\Resources\DDLResource;
use App\Models\Division;
use App\Models\Role;


class DDLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function divisions(DDLRequest $request)
    {
        try {
            $pagination = $request->getPagination();

            $divisions = Division::query()->where('is_active', 1)
                ->orderBy('name',  'ASC')
                ->paginate($pagination['size'], ['*'], 'page', $pagination['page']);

            $responseData = [
                'ddl' => DDLResource::collection($divisions),
                'pagination' => [
                    'page' => $divisions->currentPage(),
                    'size' => $divisions->perPage(),
                    'total_data' => $divisions->total(),
                    'total_pages' => $divisions->lastPage(),
                ],
            ];

            return ApiResponse::success($responseData, 'Successfully get ddl divisions');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to get ddl divisions');
        }
    }

    public function roles(DDLRequest $request)
    {
        try {
            $pagination = $request->getPagination();

            $roles = Role::query()->where('is_active', 1)
                ->orderBy('name',  'ASC')
                ->paginate($pagination['size'], ['*'], 'page', $pagination['page']);

            $responseData = [
                'ddl' => DDLResource::collection($roles),
                'pagination' => [
                    'page' => $roles->currentPage(),
                    'size' => $roles->perPage(),
                    'total_data' => $roles->total(),
                    'total_pages' => $roles->lastPage(),
                ],
            ];

            return ApiResponse::success($responseData, 'Successfully get ddl divisions');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to get ddl divisions');
        }
    }
}
