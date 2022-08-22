<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAd extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hosted()
    {
        return $this->belongsTo(User::class, 'hosted_user_id');
    }
}
