<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Module;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $modules = Module::orderBy('rank',  'ASC')->get();

            // build Tree Recursively
            $responseData = $this->buildModuleTree($modules);
            return ApiResponse::success($responseData, 'Successfully get modules');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to get ddl modules');
        }
    }

    private function buildModuleTree($modules, $parentId = null)
    {
        return $modules->where('parent_id', $parentId)->map(function ($module) use ($modules) {
            return [
                'id' => $module->id,
                'name' => $module->title,
                'children' => $this->buildModuleTree($modules, $module->id)->values(),
            ];
        })->values();
    }
}
