<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'stripe_payment_details' => 'array',
        'stripe_billing_details' => 'array',
    ];

    public function magazine() {
        return $this->hasOne(Magazine::class, 'id', 'magazine_id')->withDefault();
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }
}
