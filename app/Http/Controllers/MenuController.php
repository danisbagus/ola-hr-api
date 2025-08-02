<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Helpers\ApiResponse;
use App\Models\Module;
use App\Models\Role;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return ApiResponse::unauthorized('User not found');
            }

            $roleID = $user->role_id;

            // get modules by role
            $modules = Module::whereHas('roles', function ($query) use ($roleID) {
                $query->where('roles.id', $roleID);
            })
                ->orderBy('rank')
                ->get();

            // get parent modules according to child modules
            $parentIDs = $modules->pluck('parent_id')->filter()->unique();
            $parentModules = Module::whereIn('id', $parentIDs)->get();

            // merge child  modules + parent modules
            $allModules = $modules->concat($parentModules);

            // static home menu
            $homeMenu = collect([[
                'path' => '/home/index',
                'name' => 'home',
                'meta' => [
                    'icon' => 'HomeFilled',
                    'title' => 'Homepage',
                    'is_link' => false,
                    'is_hide' => false,
                    'is_full' => false,
                ]
            ]]);

            // Group parent-child structure
            $menu = $allModules->whereNull('parent_id')->map(function ($parent) use ($modules) {
                $children = $modules->where('parent_id', $parent->id)->values()->map(function ($child) {
                    return [
                        'path' => $child->path,
                        'name' => $child->code,
                        'meta' => [
                            'icon' => $child->icon,
                            'title' => $child->title,
                            'is_link' => false,
                            'is_hide' => $child->is_hide,
                            'is_full' => false,
                        ]
                    ];
                });

                return [
                    'path' => $parent->path,
                    'name' => $parent->code,
                    'redirect' => $children->isNotEmpty() ? $children->first()['path'] : null,
                    'meta' => [
                        'icon' => $parent->icon,
                        'title' => $parent->title,
                        'is_link' => false,
                        'is_hide' => $parent->is_hide,
                        'is_full' => false,
                    ],
                    'children' => $children->isNotEmpty() ? $children : null,
                ];
            })->values();

            $response = $homeMenu->concat($menu);

            return ApiResponse::success($response, 'Successfully get menu');
        } catch (\Exception $e) {
            return ApiResponse::internalServerError($e, 'Failed to get menu');
        }
    }
}
