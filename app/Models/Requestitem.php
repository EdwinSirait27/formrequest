<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Requestitem extends Model
{
         protected $table = 'request_item';
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
        'request_id','item_name','spesification','qty','uom','price','total_price'
    ];
      public function setRequestTypeNameAttribute($value)
    {
        $this->attributes['request_type_name'] = strtoupper($value);
    }
      public function setCodeAttribute($value)
    {;
        $this->attributes['code'] = strtoupper($value);
    }
  public static function getUomOptions()
{
    return ['pieces', 'unit', 'set', 'pack', 'box', 'rim','kg','liter','meter','roll'];
}
public function request()
    {
        return $this->belongsTo(Formrequest::class, 'request_id');
    }
}
