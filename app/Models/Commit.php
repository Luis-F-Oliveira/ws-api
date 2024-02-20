<?php

namespace App\Models;

use App\Models\User;
use App\Models\Command;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'command_id',
        'number_from'
    ];

    protected $hidden = [
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
}
