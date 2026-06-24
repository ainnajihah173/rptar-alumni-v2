<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'title',
        'image_path',
        'description',
        'target_amount',
        'current_amount',
        'start_date',
        'end_date',
        'status',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
