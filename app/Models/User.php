<?php

namespace App\Models;

use App\Models\Access;
use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_bot',
        'access_id',
        'sector_id'
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];

    public function access()
    {
        return $this->belongsTo(Access::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
