<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fellow extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'birth_date',
        'guest_id',
    ];

    public function guest(){
        return $this->belongsTo('App\Guest');
    }
}
