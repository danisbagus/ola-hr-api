<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use  SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'name',
        'user_id',
        'division_id',
        'employee_number',
        'phone_number',
        'employment_status',
        'gender',
        'hire_date',
        'birth_date',
        'address',
        'is_active',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
