<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CutiModel extends Model
{
    use HasFactory;

    public $table = 'cuti';
    protected $primaryKey = 'no_cuti';
    protected $guarded = [];
    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'string'; // Use string as primary key type

    public function jenisCuti()
    {
        return $this->hasOne(JenisCutiModel::class, 'id_jenis_cuti', 'id_jenis_cuti');
    }

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
        $latestId = self::max('no_cuti');
        $latestId = $latestId ? intval($latestId) : 0;
        $newId = $latestId + 1;

        // Format the new ID with leading zeros to make it 5 characters long
        return $newId;
    }
}
