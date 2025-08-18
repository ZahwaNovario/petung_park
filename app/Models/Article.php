<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';
    protected $fillable=  [
        'title',
        'main_content',
        'number_love',
        'status',
        'agenda_id',
        'user_id',
    ];
    public function galleries()
    {
        return $this->belongsToMany(Gallery::class, 'article_gallery', 'article_id', 'gallery_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id', 'id');
    }
}

