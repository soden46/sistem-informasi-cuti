<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DivisiModel extends Model
{
    use HasFactory;
    public $table = "divisi";
    protected $primary = 'id_divisi';
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
            $id_divisi = strtoupper(Str::random(5));
        } while (self::idExists($id_divisi));

        return $id_divisi;
    }

    private static function idExists($id_divisi)
    {
        return self::where('id_divisi', $id_divisi)->exists();
    }
}
