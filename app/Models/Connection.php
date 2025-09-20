<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $fillable = ['scene_from', 'scene_to', 'pitch', 'yaw', 'label'];

    public function sceneFrom()
    {
        return $this->belongsTo(Scene::class, 'scene_from');
    }

    public function sceneTo()
    {
        return $this->belongsTo(Scene::class, 'scene_to');
    }
}
