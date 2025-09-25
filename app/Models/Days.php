<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Days extends Model
{
   use HasFactory;

    protected $table = 'days';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'slug',
        'status_id',
        'user_id'
    ];

    
    public function status(){
        return $this->belongsTo(Status::class);
    }

    // Gets the name of the user who posted status 
    public function user(){
        return $this->belongsTo(User::class);
    }
}
