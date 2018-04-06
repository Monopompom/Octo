<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_octo_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getNiceName() {
        $niceName = $this->attributes['email'];

        if ($this->attributes['display_name'] && $this->attributes['display_name'] != '') {
            $niceName = $this->attributes['display_name'];

        } elseif (($this->attributes['last_name'] && $this->attributes['last_name'] != '') &&
            ($this->attributes['first_name'] && $this->attributes['first_name'] != '')) {
            $niceName = "$this->attributes['first_name'] $this->attributes['last_name']";

        } elseif ($this->attributes['first_name'] && $this->attributes['first_name'] != '') {
            $niceName = $this->attributes['first_name'];
        }

        return $niceName;
    }
}