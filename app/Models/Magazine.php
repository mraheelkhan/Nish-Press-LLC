<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    protected static function booted()
    {
//        parent::boot();
        static::creating(function($magazine){
            $magazine->user_id = auth()->id();
        });
    }
}
