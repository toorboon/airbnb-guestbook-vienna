<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use Notifiable;
    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id','accommodation_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.email' => 10
        ]
    ];

    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function accommodation(){
        return $this->belongsTo('App\Accommodation');
    }

    public function guests(){
        return $this->hasMany('App\Guest');
    }

    public function hasAnyRole($roles)
    {
        if ($this->role()->whereIn('name', $roles)->first()) {
            return true;
        }
        return false;
    }

    public function hasRole($role){
        if ($this->role()->where('name', $role)->first()){
            return true;
        }
        return false;
    }

}
