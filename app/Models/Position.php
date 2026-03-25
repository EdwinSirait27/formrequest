<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
      protected $connection = 'hrx'; // sesuai koneksi HRIS kamu
    protected $table = 'position_tables';
    protected $primaryKey = 'id';
    public $incrementing = false; // kalau kamu pakai UUID
    protected $keyType = 'string';

    protected $fillable = [
        'name',
    ];
}
