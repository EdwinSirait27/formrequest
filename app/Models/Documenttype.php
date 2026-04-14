<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Documenttype extends Model
{
       protected $table = 'document_type';
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
        'document_type_name'
    ];
      public function setDocumentTypeNameAttribute($value)
    {
        $this->attributes['document_type_name'] = strtoupper($value);
    }
     public function requests()
{
    return $this->hasMany(Formrequest::class, 'request_type_id');
}
}
