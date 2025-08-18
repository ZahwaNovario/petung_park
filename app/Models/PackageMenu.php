<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageMenu extends Pivot
{   
    // use HasFactory;
    protected $table = 'package_menus';
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

}
