<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Formrequest extends Model
{
    protected $table = 'form_request';
    public $incrementing = false;
    protected $connection = 'mysql';
    protected $keyType = 'string';
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::uuid7()->toString();
            }
            if (!$model->document_number) {
                DB::transaction(function () use ($model) {
                    $date = Carbon::parse($model->request_date);
                    $year = $date->format('Y');
                    $month = $date->format('m');
                    $requestType = RequestType::find($model->request_type_id);
                    $last = self::where('request_type_id', $model->request_type_id)
                        ->whereYear('request_date', $year)
                        ->lockForUpdate()
                        ->orderBy('document_number', 'desc')
                        ->first();
                    if ($last) {
                        $lastNumber = (int) substr($last->document_number, -4);
                        $nextNumber = $lastNumber + 1;
                    } else {
                        $nextNumber = 1;
                    }
                    $sequence = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
                    $model->document_number =
                        $requestType->code . '-' . $year . '-' . $month . '-' . $sequence;
                });
            }
        });
    }
    protected $fillable = [
        'request_type_id',
        'document_number',
        'request_date',
        'user_id',
        'total_amount',
        'notes',
        'vendor_id',
        'destination',
        'deadline',
        'status'
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function requestitem()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
