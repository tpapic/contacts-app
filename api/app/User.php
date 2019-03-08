<?php

namespace App;

use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    private $expirationDate = 15;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 
        'is_active', 'verified' , 'verified_token', 'role_id', 
        'social_provider_id', 'gender_id', 'date_of_birth'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attribute that will be added to model.
     *
     * @var array
     */
    protected $appends = [
        'full_name'
    ];

    /**
     * Automatically creates hash for the user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    public function getFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function socialProvider()
    {
        return $this->belongsTo(SocialProvider::class, 'social_provider_id');
    }

    public function contacts() {
      return $this->hasMany(Contact::class);
    }
}
