<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleLieu extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
