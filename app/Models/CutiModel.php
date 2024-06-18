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

    public function employee()
    {
        return $this->hasOne(Employee::class, 'npp', 'npp');
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
        // Dapatkan ID terbaru
        $latestId = self::orderBy('no_cuti', 'desc')->first();
        $latestId = $latestId ? intval($latestId->no_cuti) : 0;

        // Tambahkan 1 ke ID terbaru
        $newId = $latestId + 1;

        // Format ID baru dengan padding nol di depan
        $newId = str_pad($newId, 5, '0', STR_PAD_LEFT);

        // Pastikan tidak ada duplikat
        while (self::where('no_cuti', $newId)->exists()) {
            $newId = str_pad(intval($newId) + 1, 5, '0', STR_PAD_LEFT);
        }

        return $newId;
    }
}
