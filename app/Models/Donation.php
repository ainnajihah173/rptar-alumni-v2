<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'user_id',
        'amount',
        'payment_method',
        'is_anonymous',
        'receipt_number',
        'payment_status',
        'bill_code',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
