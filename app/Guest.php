<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Guest extends Model
{
    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'gender',
        'birth_date',
        'citizenship',
        'document_type',
        'document',
        'address',
        'arrival_date',
        'est_departure_date',
        'act_departure_date',
        'signature',
        'notes',
        'user_id',
        'accommodation_id',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'guests.first_name' => 10,
            'guests.last_name' => 10,
            'guests.citizenship' => 5,
            'guests.document' => 15,
            'guests.address' => 10,
            'guests.notes' => 5, //notes search only works for the first word
            'guests.gender' => 5,
        ]
    ];

    public function fellows(){
        return $this->hasMany('App\Fellow');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function accommodation(){
        return $this->belongsTo('App\Accommodation');
    }


}
