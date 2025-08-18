<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;
use App\Models\Article;
use App\Models\Travel;
use App\Models\SliderHome;
use App\Models\GalleryShow;
use App\Models\User;
use App\Models\Package;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'galleries';
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'gallery_id', 'id');
    }
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_gallery', 'gallery_id', 'article_id');
    }
    public function travels()
    {
        return $this->belongsToMany(Travel::class, 'travel_gallery', 'gallery_id', 'travel_id');
    }
    public function slidersHome()
    {
        return $this->hasMany(SliderHome::class, 'gallery_id', 'id');
    }
    public function galleriesShow()
    {
        return $this->hasMany(GalleryShow::class, 'gallery_id', 'id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'gallery_id', 'id');
    }
    public function packages()
    {
        return $this->hasMany(Package::class, 'gallery_id', 'id');
    }
}
