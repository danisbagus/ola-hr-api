<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeDetailResource;
use App\Http\Requests\ListEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListEmployeeRequest $request)
    {
        try {
            $filters = $request->getFilters();
            $pagination = $request->getPagination();

            $query = Employee::with(['user.role', 'division']);

            // Filter: keyword (name or employee_number)
            if (!empty($filters['keyword'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('name', 'ILIKE', "%{$filters['keyword']}%")
                        ->orWhere('employee_number', 'ILIKE', "%{$filters['keyword']}%");
                });
            }

            // Filter: gender
            if (!empty($filters['gender'])) {
                $query->where('gender', $filters['gender']);
            }

            // Filter: division_id
            if (!empty($filters['division_id'])) {
                $query->where('division_id', $filters['division_id']);
            }

            // Filter: role_id (via user relations)
            if (!empty($filters['role_id'])) {
                $query->whereHas('user', function ($q) use ($filters) {
                    $q->where('role_id', $filters['role_id']);
                });
            }

            // Filter: employment_status
            if (!empty($filters['employment_status'])) {
                $query->where('employment_status', $filters['employment_status']);
            }

            // Filter: is_active
            if (!is_null($filters['is_active'])) {
                $query->where('is_active', $filters['is_active']);
            }

            // Order by updated_at DESC, fallback to created_at
            $query->orderByRaw('COALESCE(employees.updated_at, employees.created_at) DESC');

            // Paginate
            $employees = $query->paginate($pagination['size'], ['*'], 'page', $pagination['page']);

            $responseData = [
                'employees' => EmployeeResource::collection($employees),
                'pagination' => [
                    'page' => $employees->currentPage(),
                    'size' => $employees->perPage(),
                    'total_data' => $employees->total(),
                    'total_pages' => $employees->lastPage(),
                ],
            ];

            return ApiResponse::success($responseData, 'Successfully get employees');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to get employees');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        DB::beginTransaction();

        try {
            $generatedPassword = 'tempPassword#123'; // todo: generate password and send email to user
            $user = $request->toUserDto($generatedPassword)->toModel();
            $user->save();

            $employeeNumber = 'OLA-' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
            $employee = $request->toEmployeeDto($user->id, $employeeNumber)->toModel();
            $employee->user_id = $user->id;
            $employee->save();

            DB::commit();
            return ApiResponse::success(null, 'Successfully create employee',  Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::internalServerError($e, 'Failed to create employee');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $employee = Employee::with(['user.role', 'division'])->find($id);
            if (!$employee) {
                return ApiResponse::badRequest('Employee not found');
            }

            return ApiResponse::success(new EmployeeDetailResource($employee),  'Successfully get employee');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to get employee');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            $employee = Employee::find($id);
            if (!$employee) {
                DB::rollBack();
                return ApiResponse::badRequest('Employee not found');
            }
            $user = $employee->user;

            $employee->update($this->toUpdateEmployeepayload($request));
            if ($user) {
                $user->update($this->toUpdateUserpayload($request));
            }

            DB::commit();
            return ApiResponse::success(null, 'Successfully update employee');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::internalServerError($e, 'Failed to update employee');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::find($id);
            if (!$employee) {
                DB::rollBack();
                return ApiResponse::badRequest('Employee not found');
            }

            $user = $employee->user;

            $employee->delete();
            if ($user) {
                $user->delete();
            }

            DB::commit();
            return ApiResponse::success(null, 'Successfully delete employee');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::internalServerError($e, 'Failed to delete employee');
        }
    }

    private function toUpdateEmployeepayload(UpdateEmployeeRequest $request)
    {
        return [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'employment_status' => $request->employment_status,
            'gender' => $request->gender,
            'division_id' => $request->division_id,
            'role_id' => $request->role_id,
            'hire_date' => $request->hire_date,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'is_active' => $request->is_active,
        ];
    }

    private function toUpdateUserpayload(UpdateEmployeeRequest $request)
    {
        return [
            'role_id' => $request->role_id,
            'email' => $request->email,
            'is_active' => $request->is_active,
        ];
    }
}
