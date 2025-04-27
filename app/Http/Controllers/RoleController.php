<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\ListRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListRoleRequest $request)
    {
        try {
            $filters = $request->getFilters();
            $pagination = $request->getPagination();

            $query = Role::query();

            if (!empty($filters['keyword'])) {
                $query->where('name', 'ilike', '%' . $filters['keyword'] . '%');
            }

            if (!is_null($filters['is_active'])) {
                $query->where('is_active', $filters['is_active']);
            }

            $roles = $query->orderBy($pagination['sort_by'], $pagination['sort_order'])
                ->paginate($pagination['size'], ['*'], 'page', $pagination['page']);

            $responseData = [
                'roles' => RoleResource::collection($roles),
                'pagination' => [
                    'page' => $roles->currentPage(),
                    'size' => $roles->perPage(),
                    'total_data' => $roles->total(),
                    'total_pages' => $roles->lastPage(),
                ],
            ];

            return ApiResponse::success($responseData, 'Successfully get roles');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to get roles');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            $role = $request->toDto()->toModel();
            $role->save();

            return ApiResponse::success(null, 'Successfully create role',  Response::HTTP_CREATED,);
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to create role');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return ApiResponse::badRequest('Role not found');
            }

            return ApiResponse::success(new RoleResource($role),  'Successfully get role');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to get role');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return ApiResponse::badRequest('Role not found');
            }

            $role->update($this->toUpdatepayload($request));

            return ApiResponse::success(null, 'Successfully update role');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to update role');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return ApiResponse::badRequest('Role not found');
            }

            $role->delete();

            return ApiResponse::success(null, 'Successfully delete role');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to delete role');
        }
    }

    private function toUpdatepayload(UpdateRoleRequest $request)
    {
        return [
            'name' => $request->name,
            'is_active' => $request->is_active,
        ];
    }
}
