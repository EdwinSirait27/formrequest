<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Capextype extends Model
{
    protected $table = 'capex_type';
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
        'code',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
}
