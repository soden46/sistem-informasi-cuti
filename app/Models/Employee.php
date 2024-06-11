<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use Notifiable;

    public $table = "employee";
    protected $primaryKey = 'npp';
    protected $guarded = [];

    // Hide the password and remember_token fields
    protected $hidden = [
        'password',
    ];

    public function divisi()
    {
        return $this->hasOne(DivisiModel::class, 'id_divisi', 'id_divisi');
    }
}
