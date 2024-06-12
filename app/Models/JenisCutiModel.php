<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class JenisCutiModel extends Model
{
    use HasFactory;
    protected $table = "jenis_cuti";
    protected $primaryKey = 'id_jenis_cuti';
    protected $guarded = [];
    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'string'; // Use string as primary key type

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
        $latestId = self::max('id_jenis_cuti');
        $latestId = $latestId ? intval($latestId) : 0;
        $newId = $latestId + 1;

        // Format the new ID with leading zeros to make it 5 characters long
        return str_pad($newId, 5, '0', STR_PAD_LEFT);
    }
}
