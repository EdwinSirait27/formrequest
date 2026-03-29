<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
class Requestapproval extends Model
{
    protected $table = 'request_approval';
    public $incrementing = false;
    protected $connection = 'mysql';
    protected $keyType = 'string';
    public $timestamps = false;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::uuid7()->toString();
            }
        });
    }
     protected $fillable = [
        'request_id','approver1','approver2','approver1_at','approver2_at'];
    public function request()
        {
            return $this->belongsTo(Formrequest::class, 'request_id','id');
        }
    // public function approver1()
    public function approver1User()

        {
            return $this->belongsTo(User::class, 'approver1','id');
        }
    // public function approver2()
    public function approver2User()

        {
            return $this->belongsTo(User::class, 'approver2','id');
        }
    }