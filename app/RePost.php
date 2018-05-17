<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RePost extends Model
{
    protected $table = 'reposts';
    
    protected $fillable = ['user_id', 'post_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
