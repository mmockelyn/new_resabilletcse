<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ["created_at", "updated_at", "start_manif", "end_manif", "open_vente", "date_debut", "date_fin", "heure_debut", "heure_fin"];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function subgenre()
    {
        return $this->belongsTo(SubGenre::class, 'sub_genre_id');
    }

    public function tarifs()
    {
        return $this->hasMany(ArticleTarif::class);
    }

    public function lieux()
    {
        return $this->hasMany(ArticleLieu::class);
    }
}
