<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'name',
        'created_by',
        'image_path',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'capacity',
        'registered_count',
        'is_active',
        'status',
    ];

    public function organizers(){
        return $this->belongsTo(EventOrganizer::class, 'organizer_id', 'id');
    }

    public function participants(){
        return $this->hasMany(EventParticipant::class, 'event_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
