<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'date_of_birth',
        'contact_number',
        'gender',
        'address',
        'job',
        'profile_pic',
        'bio',
        'facebook',
        'instagram',
        'linkedin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function isComplete()
    // {
    //     return $this->full_name && $this->contact_number && $this->gender && $this->bio; // Add required fields
    // }
}
