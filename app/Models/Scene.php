<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Scene extends Model
{
    protected $fillable = ['location_id', 'name', 'image_path', 'latitude', 'longitude'];

    protected static function booted()
    {
        static::creating(function ($scene) {
            $scene->uuid = (string) Str::uuid();
        });
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function connections()
    {
        return $this->hasMany(Connection::class, 'scene_from');
    }
}
