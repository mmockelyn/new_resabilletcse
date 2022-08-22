<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function genres()
    {
        return $this->hasMany(Genre::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
