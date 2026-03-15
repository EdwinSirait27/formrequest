<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
class Vendor extends Model
{
    protected $table = 'vendor';
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
        });
    }
    protected $fillable = [
        'vendor_name',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'npwp',
        'bank_name',
        'bank_account_number',
        'transfer',
        'bank_account_name'
    ];
    public function setVendorNameAttribute($value)
    {
        $this->attributes['vendor_name'] = strtoupper($value);
    }
    public function setBankNameAttribute($value)
    {
        $this->attributes['bank_name'] = strtoupper($value);
    }
    public function setBankAccountNameAttribute($value)
    {
        $this->attributes['bank_account_name'] = strtoupper($value);
    }
}
