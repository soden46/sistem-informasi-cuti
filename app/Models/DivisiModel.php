<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisiModel extends Model
{
    use HasFactory;
    public $table = "divisi";
    protected $primary = 'id_divisi';
    protected $guarded = [];
}
