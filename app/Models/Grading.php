<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grading extends Model
{
        protected $connection = 'hrx'; // sesuai koneksi HRIS kamu
    protected $table = 'grading';
    protected $primaryKey = 'id';
    public $incrementing = false; // kalau kamu pakai UUID
    protected $keyType = 'string';
    protected $fillable = [
        'grading_name',
        'meal_allowance',
    ];
     protected $casts = [
        'meal_allowance' => 'decimal:2',
    ];
}