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
        'return'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'sector_id'
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
