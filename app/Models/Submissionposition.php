<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submissionposition extends Model
{
    protected $connection = 'hrx'; // sesuai koneksi HRIS kamu
    protected $table = 'submission_position_tables';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
     public function submitter()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function positionRelation()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }
    public function approver1()
    {
        return $this->belongsTo(Employee::class, 'approver_1', 'id');
    }
    public function approver2()
    {
        return $this->belongsTo(Employee::class, 'approver_2', 'id');
    }
}
// Structuresnew.php
