<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CutiModel extends Model
{
    use HasFactory;

    public $table = "cuti";
    protected $primary = 'no_cuti';
    protected $guarded = [];

    public function jenisCuti()
    {
        return $this->hasOne(JenisCutiModel::class, 'id_jenis_cuti', 'id_jenis_cuti');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                // Logika untuk menghasilkan nilai unik dengan panjang 5 karakter
                $model->{$model->getKeyName()} = self::generateUniqueId();
            }
        });
    }

    private static function generateUniqueId()
    {
        do {
            // Menghasilkan ID unik dari karakter acak, bisa diubah sesuai kebutuhan
            $no_cuti = strtoupper(Str::random(5));
        } while (self::idExists($no_cuti));

        return $no_cuti;
    }

    private static function idExists($no_cuti)
    {
        return self::where('no_cuti', $no_cuti)->exists();
    }
}
