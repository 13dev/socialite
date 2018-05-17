<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cmgmyr\Messenger\Traits\Messagable;

class User extends Authenticatable
{
    use Notifiable, Messagable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'provider', 'provider_id', 'created_at', 'api_token'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function follows($id)
    {
        foreach ($this->following as $following)
        {
            if ($following->id == $id)
            {
                return true;
            }
        }
        return false;
    }

    public function muted($id)
    {
        foreach ($this->mutes as $mutes)
        {
            if ($mutes->muted_id == $id)
            {
                return true;
            }
        }
        return false;
    }

    public function favorited($id)
    {
        foreach ($this->favorites as $favorite)
        {
            if ($favorite->post_id == $id)
            {
                return true;
            }
        }
        return false;
    }

    public function posted($id)
    {
        foreach ($this->posts as $post)
        {
            if ($post->id == $id)
            {
                return true;
            }
        }
        return false;
    }

    public function reposted($id)
    {
        foreach ($this->reposts as $repost)
        {
            if ($repost->post_id == $id)
            {
                return true;
            }
        }
        return false;
    }

    public function getTimelineAttribute($value)
    {
        $posts = $this->posts()->latest()->get();
        $reposts = $this->reposts()->latest()->get();
        
        // problems ? use push()
        return $posts->merge($reposts);
    }

    public function posts()
    {
        return $this->hasMany('App\Post')->orderBy('created_at', 'DESC');
    }

    public function reposts()
    {
        return $this->hasMany('App\RePost');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    public function mutes()
    {
        return $this->hasMany('App\Mute', 'user_id', 'id');
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'user_relations', 'followed_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany('App\User', 'user_relations', 'follower_id', 'followed_id');
    }

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }


    /**
     * Get the user's fullname titleized.
     *
     * @return string
     */
    public function getFullnameAttribute(): string
    {
        return title_case($this->name);
    }

    public function getDisplayNameAttribute()
    {
        $available = false;
        if (isset($this->profile->display_name)
            && !empty($this->profile->display_name))
        {
            $available = true;
        }
        return $available ?
            $this->profile->display_name :
            $this->name;
    }

    public function getWebsiteLinkAttribute()
    {
        $link = $this->profile->website;
        if (!preg_match('#^http(s)?://#', $link)) {
            $link = 'http://' . $link;
        }
        return $link;
    }

    public function getWebsiteAttribute()
    {
        $link = parse_url($this->website_link);
        return $link['host'];
    }

    public function profileImage($size = 'small')
    {
        $webpath = 'images/no-thumb.png';
        try
        {
            $contents = null;
            switch ($size)
            {
                case 'small':
                    $contents = explode('/', $this->profile->image->small);
                    break;
                case 'tiny':
                    $contents = explode('/', $this->profile->image->tiny);
                    break;
                case 'medium':
                    $contents = explode('/', $this->profile->image->medium);
                    break;
                case 'large';
                    $contents = explode('/', $this->profile->image->large);
                    break;
                case 'actual':
                    $contents = explode('/', $this->profile->image->actual);
                    break;
            }
            $filename = array_pop($contents);
            $directory = array_pop($contents);
            $webpath = implode('/', ['images', $directory, $filename]);
        }
        catch (\ErrorException $e) {}
        return $webpath;
    }


    /**
     * Encrypt the user's password.
     *
     * @param string $passwword
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Scope a query to only include users registered last week.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastWeek($query)
    {
        return $query->whereBetween('created_at', [now()->subWeek(), now()])
                     ->latest();
    }

    /**
     * Scope a query to order users by latest registered.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to filter available author users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAuthors($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('roles.name', Role::ROLE_ADMIN)
                  ->orWhere('roles.name', Role::ROLE_EDITOR);
        });
    }


    /**
     * Check if the user has a role
     *
     * @param string $role
     * @return boolean
     */
    public function hasRole($role): bool
    {
        return $this->roles->where('name', $role)->isNotEmpty();
    }

    /**
     * Check if the user has role admin
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(Role::ROLE_ADMIN);
    }


    /**
     * Return the user's roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
