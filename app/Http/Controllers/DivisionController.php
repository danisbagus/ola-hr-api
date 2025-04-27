<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\ListDivisionRequest;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Http\Resources\DivisionResource;
use App\Models\Division;
use Symfony\Component\HttpFoundation\Response;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListDivisionRequest $request)
    {
        try {
            $filters = $request->getFilters();
            $pagination = $request->getPagination();

            $query = Division::query();

            if (!empty($filters['keyword'])) {
                $query->where('name', 'ilike', '%' . $filters['keyword'] . '%');
            }

            if (!is_null($filters['is_active'])) {
                $query->where('is_active', $filters['is_active']);
            }

            $divisions = $query->orderBy($pagination['sort_by'], $pagination['sort_order'])
                ->paginate($pagination['size'], ['*'], 'page', $pagination['page']);

            $responseData = [
                'divisions' => DivisionResource::collection($divisions),
                'pagination' => [
                    'page' => $divisions->currentPage(),
                    'size' => $divisions->perPage(),
                    'total_data' => $divisions->total(),
                    'total_pages' => $divisions->lastPage(),
                ],
            ];

            return ApiResponse::success($responseData, 'Successfully get divisions');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to get divisions');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDivisionRequest $request)
    {
        try {
            $division = $request->toDto()->toModel();
            $division->save();

            return ApiResponse::success(null, 'Successfully create division',  Response::HTTP_CREATED,);
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to create division');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $division = Division::find($id);
            if (!$division) {
                return ApiResponse::badRequest('Division not found');
            }

            return ApiResponse::success(new DivisionResource($division),  'Successfully get division');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to get division');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDivisionRequest $request, string $id)
    {
        try {
            $division = Division::find($id);
            if (!$division) {
                return ApiResponse::badRequest('Division not found');
            }

            $division->update($this->toUpdatepayload($request));

            return ApiResponse::success(null, 'Successfully update division');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to update division');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $division = Division::find($id);
            if (!$division) {
                return ApiResponse::badRequest('Division not found');
            }

            $division->delete();

            return ApiResponse::success(null, 'Successfully delete division');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to delete division');
        }
    }


    private function toUpdatepayload(UpdateDivisionRequest $request): array
    {
        return [
            'name' => $request->name,
            'is_active' => $request->is_active,
            'updated_at' => now(),
        ];
    }
}
