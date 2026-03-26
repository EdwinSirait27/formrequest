<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Structuresnew extends Model
{
    protected $connection = 'hrx'; // sesuai koneksi HRIS kamu
    protected $table = 'structures_tables';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'parent_id',
        'structure_code',
        'is_manager',
        'status',
        'submission_position_id',
    ];
    protected $casts = [
        'is_manager' => 'boolean',
    ];
     public function parent()
    {
        return $this->belongsTo(Structuresnew::class, 'parent_id', 'id');
    }
    public function submissionposition()
    {
        return $this->belongsTo(Submissionposition::class, 'submission_position_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(Structuresnew::class, 'parent_id', 'id');
    }
    public function employee()
    {
        return $this->hasMany(Employee::class, 'structure_id', 'id');
    }
    public function employees()
    {
        return $this->hasOne(Employee::class, 'structure_id', 'id');
    }
    public function allChildren()
    {
        return $this->children()->with('allChildren', 'submissionposition.positionRelation');
    }
   
    public function secondarySupervisors()
    {
        return $this->belongsToMany(
            Structuresnew::class,
            'structure_supervisors',
            'structure_id',
            'supervisor_id'
        );
    }



    public function getAllIds()
{
    $ids = [$this->id];

    foreach ($this->allChildren as $child) {
        $ids = array_merge($ids, $child->getAllIds());
    }

    return $ids;
}

}
