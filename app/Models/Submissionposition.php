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
    
}
// Structuresnew.php
