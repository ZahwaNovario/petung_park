<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';
    use HasFactory;
    protected $fillable = ['name', 'price', 'status', 'number_love', 'gallery_id'];
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'package_menus', 'package_id', 'menu_id');            
    }
    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'id');
    }
}
