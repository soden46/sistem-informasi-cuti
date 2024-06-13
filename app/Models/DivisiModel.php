<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DivisiModel extends Model
{
    use HasFactory;

    protected $table = 'divisi';
    protected $primaryKey = 'id_divisi'; // Corrected property name
    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'string'; // Use string as primary key type
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = self::generateUniqueId();
            }
        });
    }

    private static function generateUniqueId()
    {
        $latestId = self::max('id_divisi');
        $latestId = $latestId ? intval($latestId) : 0;
        $newId = $latestId + 1;

        // Format the new ID with leading zeros to make it 5 characters long
        return $newId;
    }
}
