<?php

namespace App\Models;

use App\Models\User;
use App\Models\Command;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'command_id',
        'number_from',
        'answered'
    ];

    protected $hidden = [
        'user_id',
        'command_id',
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
    
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->subHours(4)->format('d/m/Y-H:i:s');
    }
}
