<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModule extends Model
{
    protected $table = 'role_module';

    protected $fillable = [
        'role_id',
        'module_id',
    ];

    // Relationship ke Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relationship ke Module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
