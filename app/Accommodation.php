<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Accommodation extends Model
{
    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'capacity',
    ];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function guests(){
        return $this->hasMany('App\Guest');
    }

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'accommodations.name' => 10
        ]
    ];
}
