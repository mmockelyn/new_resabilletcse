<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleTarif extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ["date_debut", "date_fin"];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
