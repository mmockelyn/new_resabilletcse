<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class, 'catalogue_id');
    }

    public function subgenres()
    {
        return $this->hasMany(SubGenre::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
