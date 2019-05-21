<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RePost extends Model
{
    protected $table = 'reposts';
    protected $dates = ['created_at'];

    protected $fillable = ['user_id', 'post_id', 'created_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
