<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'image',
        'is_active',
        'views',
        'published_date',
    ];

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
