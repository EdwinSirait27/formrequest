<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
            $model->total_price = round(
                (float) ($model->qty ?? 0) * (float) ($model->price ?? 0),
                2
            );
        });
    }
    protected $fillable = [
        'request_id',
        'item_name',
        'specification',
        'qty',
        'uom',
        'price',
        'total_price'
    ];
    public static function getUomOptions()
    {
        return ['pieces', 'unit', 'set', 'pack', 'box', 'rim', 'kg', 'liter', 'meter', 'roll','monthly','3 month','6 month','yearly'];
    }
    public function request()
    {
        return $this->belongsTo(Formrequest::class, 'request_id');
    }
    protected function qty(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return floatval(str_replace(',', '.', $value));
            }
        );
    }
    protected function price(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return floatval(str_replace('.', '', str_replace(',', '.', $value)));
            }
        );
    }
    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            set: fn($value) => round($value, 2)
        );
    }
    public function vendors()
{
    return $this->hasMany(ItemVendorQuotation::class, 'request_item_id');
}
}
