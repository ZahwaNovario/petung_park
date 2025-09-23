<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuLike extends Model
{
    protected $fillable = ['user_id', 'menu_id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

