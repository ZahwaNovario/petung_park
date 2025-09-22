<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'slug'];

    public function scenes()
    {
        return $this->hasMany(Scene::class);
    }
}
