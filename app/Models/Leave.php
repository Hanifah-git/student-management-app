<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = 'leaves';
    protected $primaryKey = 'id';
    protected $fillable = [
        'post_id',
        'startdate',
        'enddate',
        'tag',
        'title',
        'content',
        'stage_id',
        'authorized_id',
        'user_id'
    ];

    protected $casts = [
        'post_id' => 'array',
        'tag' => 'array',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

     public function post(){
        return $this->belongsTo(Post::class);
    }

     public function tag(){
        return $this->belongsTo(User::class);
    }

    public function stage(){
        return $this->belongsTo(Stages::class);
    }

    public function maptagtonames($users=null){
        // dd($this->tag);   // or var_dump($this->tag);

        $tagids = $this->tag;
        $tagnames = collect($tagids)->map(function($id) use ($users){
            return $users[$id] ?? 'Unknown';
        });
        return $tagnames->join(', ');
    }

    public function tagpersons($tagjson){
        $tagids = $tagjson;
        $tags = User::whereIn('id',$tagids)->pluck("name","id");

        
        return $tags;
    }

    public function tagposts($postjson){
        $postids = $postjson;

        $posts = Post::whereIn('id',$postids)->pluck("title","id");

        return $posts;
    }

}
