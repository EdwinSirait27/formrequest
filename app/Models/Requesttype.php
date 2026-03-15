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

    public function getSlugAttribute()
    {
        if (!empty($this->code)) {
            return strtoupper($this->code);
        }

        $rawName = strtoupper($this->request_type_name);

        if (str_contains($rawName, 'CASH ADVANCE FORM')) {
            return 'CA';
        }

        if (str_contains($rawName, 'CAPITAL EXPENDITURE REQUEST FORM')) {
            return 'CAPEX';
        }

        if (str_contains($rawName, 'PURCHASE REQUEST FORM')) {
            return 'PR';
        }

        if (str_contains($rawName, 'PAYMENT REQUEST FORM')) {
            return 'PAYREQ';
        }

        if (str_contains($rawName, 'REIMBURSE FORM')) {
            return 'RE';
        }

        return str_replace(' ', '-', $rawName);
    }

    public function getColorAttribute()
    {
        $colorMap = [
            'CA' => [
                'pill' => 'from-amber-500 to-orange-500',
                'icon' => 'text-amber-400',
                'ring' => 'ring-amber-500',
            ],
            'CAPEX' => [
                'pill' => 'from-violet-500 to-purple-600',
                'icon' => 'text-violet-400',
                'ring' => 'ring-violet-500',
            ],
            'PR' => [
                'pill' => 'from-blue-500 to-cyan-500',
                'icon' => 'text-blue-400',
                'ring' => 'ring-blue-500',
            ],
            'PAYREQ' => [
                'pill' => 'from-emerald-500 to-teal-500',
                'icon' => 'text-emerald-400',
                'ring' => 'ring-emerald-500',
            ],
            'RE' => [
                'pill' => 'from-rose-500 to-pink-500',
                'icon' => 'text-rose-400',
                'ring' => 'ring-rose-500',
            ],
        ];

        return $colorMap[$this->slug] ?? [
            'pill' => 'from-slate-500 to-slate-600',
            'icon' => 'text-slate-400',
            'ring' => 'ring-slate-500',
        ];
    }
}
