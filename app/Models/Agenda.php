<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $table = 'agendas';
    protected $fillable = [
        'event_name',
        'event_start_date',
        'event_end_date',
        'event_location',
        'status',
        'description',
        'user_id',
    ];

    // Define the relationship with Staff
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function articles()
    {
        return $this->hasMany(Article::class, 'agenda_id', 'id');
    }
}
