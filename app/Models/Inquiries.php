<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiries extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assign_id',
        'category',
        'title',
        'image_path',
        'description',
        'resolved_date',
        'solution',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assign_id');
    }

}
