<?php

namespace App\Models;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'return',
        'sector_id',
        'parent_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Command::class, 'parent_id')->with('replies');
    }

    public function parent()
    {
        return $this->belongsTo(Command::class, 'parent_id');
    }
}
