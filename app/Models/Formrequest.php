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
        static::updating(function ($model) {
            $originalStatus = $model->getOriginal('status');
            $newStatus = $model->status;
            $rejectedStatuses = [
                'Rejected Manager',
                'Rejected Director'
            ];
            if ($originalStatus !== $newStatus && in_array($newStatus, $rejectedStatuses)) {
                $model->revision_number = ($model->revision_number ?? 0) + 1;
            }
        });
    }
    protected $fillable = [
        'request_type_id',
        'document_number',
        'request_date',
        'user_id',
        'transfer',
        'company_id',
        'user_id',
        'total_amount',
        'title',
        'ca_number',
        'addressed_to',
        'notes',
        'notes_fa',
        'notes_dir',
        'vendor_id',
        'destination',
        'assets',
        'towards_to',
        'revision_number',
        'deadline',
        'status'
    ];
    protected $casts = [
        'request_date' => 'date',
        'deadline' => 'date',
        'total_amount' => 'decimal:2',
    ];
      public static function getAssetOptions()
    {
        return ['Bangunan',
            'Peralatan & Inventaris',
            'IT Hardware & Software',
            'Kendaraan',
            'Machine & Equipment'];
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function towards()
    {
        return $this->belongsTo(User::class, 'towards_to');
    }
    public function setTransferAttribute($value)
    {
        $this->attributes['transfer'] = strtoupper($value);
    }
    public function items()
    {
        return $this->hasMany(Requestitem::class, 'request_id');
    }
    public function links()
    {
        return $this->hasMany(Requestlink::class, 'request_id');
    }
    public function approval()
    {
        return $this->hasOne(Requestapproval::class, 'request_id');
    }
    public function requesttype()
    {
        return $this->belongsTo(Requesttype::class, 'request_type_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function addressedto()
    {
        return $this->belongsTo(User::class, 'addressed_to');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
