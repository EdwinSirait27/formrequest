<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Requestlink extends Model
{
    protected $table = 'link_request';
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
        'request_id',
        'link'
    ];
    public function request()
    {
        return $this->belongsTo(Formrequest::class, 'request_id');
    }
}
