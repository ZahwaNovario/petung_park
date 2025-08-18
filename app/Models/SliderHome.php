<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderHome extends Model
{
    use HasFactory;
    protected $table = 'sliders_home';
    protected $fillable = ['gallery_id', 'name', 'status', 'created_at', 'updated_at'];
    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'id');
    }
}
