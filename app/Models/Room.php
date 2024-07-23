<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function users() {
        return $this->hasMany(User::class, 'id_childdata', 'id');
    }

    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }
}
