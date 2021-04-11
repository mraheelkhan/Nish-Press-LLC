<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Magazine extends Model
{
    use HasFactory;
    use SoftDeletes;
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
