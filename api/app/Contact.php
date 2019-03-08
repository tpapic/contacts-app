<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
      'first_name', 'last_name', 'email', 'profile_photo', 'favorite', 'user_id'
    ];

    protected $appends = [
      'full_path_profile_photo', 'full_name'
    ];

    protected $with = ['numbers'];

    public function getFullPathProfilePhotoAttribute() {
      $fileName = 'storage/' . $this->profile_photo;
      return url($fileName); 
    }

    public function getFullNameAttribute() {
      return $this->first_name . ' ' . $this->last_name; 
    }

    public function scopeFavoriteFilter($query) {
      return $query->where('favorite', 1);
    }

    public function numbers() {
      return $this->hasMany(Number::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}