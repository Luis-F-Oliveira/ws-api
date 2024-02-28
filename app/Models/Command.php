<?php

namespace App\Models;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'return',
        'sector_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
