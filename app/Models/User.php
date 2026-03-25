<?php

namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;
    protected $connection = 'hrx';
    protected $table = 'users';
    protected $guard_name = 'web';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'username',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function Employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function findForAuth($username)
    {
        return $this->where('username', $username)->first();
    }
}
