<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image'];

    /**
     * القيم الافتراضية للنموذج.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'description' => '',
        'image' => null,
    ];

    /**
     * تشغيل تلقائي للتواريخ عند الإنشاء.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->created_at)) {
                $model->created_at = now();
            }
            if (empty($model->updated_at)) {
                $model->updated_at = now();
            }
        });

        static::updating(function ($model) {
            $model->updated_at = now();
        });
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ]);
    }
}
