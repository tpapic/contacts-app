<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label', 'number'
    ];

    public function contact() {
        return $this->belongsTo(Contact::class);
    }
}
