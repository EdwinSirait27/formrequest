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
    protected $attributes = [
    'qty' => 0.0,
    'price' => 0.00,
];
    protected $casts = [
    'qty' => 'decimal:2',
    'price' => 'decimal:2',
    'total_price' => 'decimal:2',
];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::uuid7()->toString();
            }
      });
      static::saving(function ($model) {
        // $model->total_price = ($model->qty ?? 0) * ($model->price ?? 0);
        $model->total_price = round(
    (float) ($model->qty ?? 0) * (float) ($model->price ?? 0),
    2
);
    });
    }
     protected $fillable = [
        'request_id','item_name','specification','qty','uom','price','total_price'
    ];
     
  public static function getUomOptions()
{
    return ['pieces', 'unit', 'set', 'pack', 'box', 'rim','kg','liter','meter','roll'];
}
public function request()
    {
        return $this->belongsTo(Formrequest::class, 'request_id');
    }
}