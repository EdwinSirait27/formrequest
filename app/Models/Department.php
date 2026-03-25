<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
         protected $connection = 'hrx'; // sesuai koneksi HRIS kamu
    protected $table = 'departments_tables';
    protected $primaryKey = 'id';
    public $incrementing = false; // kalau kamu pakai UUID
    protected $keyType = 'string';
    protected $fillable = [
        'department_name',
    ];
}