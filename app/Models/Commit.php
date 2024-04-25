<?php

namespace App\Models;

use App\Models\User;
use App\Models\Command;
use App\Models\Sector;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'command_id',
        'sector_id'
    ];

    protected $hidden = [
        'user_id',
        'command_id',
        'sector_id',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function command()
    {
        return $this->belongsTo(Command::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
