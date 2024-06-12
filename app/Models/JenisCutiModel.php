<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class JenisCutiModel extends Model
{
    use HasFactory;
    public $table = "jenis_cuti";
    protected $primary = 'id_jenis_cuti';
    protected $guarded = [];

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
            $id_jenis_cuti = strtoupper(Str::random(5));
        } while (self::idExists($id_jenis_cuti));

        return $id_jenis_cuti;
    }

    private static function idExists($id_jenis_cuti)
    {
        return self::where('id_jenis_cuti', $id_jenis_cuti)->exists();
    }
}
