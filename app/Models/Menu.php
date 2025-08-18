<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menus';
    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'status_recommended',
        'number_love',
        'category_id',
        'user_id',
        'gallery_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function gallery()
    {
        return $this->hasOne(Gallery::class, 'id', 'gallery_id');
    }
    // Define the many-to-many relationship with Package
    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_menus', 'menu_id', 'package_id');
    }
}
