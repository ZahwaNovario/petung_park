<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    protected $fillable = ['location_id', 'name', 'image_path', 'latitude', 'longitude'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function connections()
    {
        return $this->hasMany(Connection::class, 'scene_from');
    }
}
