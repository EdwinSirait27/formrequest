<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ItemVendorQuotation extends Model
{
    protected $table = 'item_vendor_quotations';
    public $incrementing = false;
    protected $connection = 'mysql';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $attributes = [
        'price' => 0.00,
        'is_selected' => false,
    ];
    protected $casts = [
        'price' => 'decimal:2',
        'is_selected' => 'boolean',
    ];
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
        'request_item_id',
        'vendor_id',
        'price',
        'notes',
        'is_selected'
        ];
       
    public function item()
{
    return $this->belongsTo(Requestitem::class, 'request_item_id');
}
public function vendor()
{
    return $this->belongsTo(Vendor::class, 'vendor_id');
}
 protected function price(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return floatval(str_replace('.', '', str_replace(',', '.', $value)));
            }
        );
    }
}
