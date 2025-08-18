<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelGallery extends Pivot
{
    use HasFactory;

    public function travel()
    {
        return $this->belongsTo(Travel::class, 'travel_id');
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }

}
