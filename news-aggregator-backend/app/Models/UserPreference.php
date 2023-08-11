<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;
    protected $fillable = ['sources', 'categories', 'authors'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
