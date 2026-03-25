<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Requesttype extends Model
{
      protected $table = 'request_type';
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
        'request_type_name','code'
    ];
      public function setRequestTypeNameAttribute($value)
    {
        $this->attributes['request_type_name'] = strtoupper($value);
    }
      public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
    public function requests()
{
    return $this->hasMany(Formrequest::class, 'request_type_id');
}
}
