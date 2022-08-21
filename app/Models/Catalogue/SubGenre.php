<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubGenre extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
