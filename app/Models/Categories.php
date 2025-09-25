<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';
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
