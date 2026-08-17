<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Unit extends Model
{
    protected $fillable = ['name', 'code', 'is_base', 'status'];

    public static function makeCode(string $name, ?string $code = null): string
    {
        $code = Str::slug($code ?: $name, '_');
        $code = strtolower(str_replace('-', '_', $code));

        return $code !== '' ? $code : 'unit';
    }

    public static function base(): self
    {
        return static::where('is_base', 1)->first()
            ?: static::firstOrCreate(
                ['code' => 'pc'],
                ['name' => 'Pc', 'is_base' => 1, 'status' => 1]
            );
    }

    public static function label(?string $code): string
    {
        $code = strtolower((string) $code);
        if ($code === '' || $code === 'pc' || $code === 'pcs') {
            return 'Pc';
        }

        $unit = static::where('code', $code)->first();

        return $unit?->name ?: ucfirst($code);
    }

    public static function activePackUnits()
    {
        return static::where('status', 1)->where('is_base', 0)->orderBy('name')->get();
    }

    public static function activeUnits()
    {
        return static::where('status', 1)->orderByDesc('is_base')->orderBy('name')->get();
    }
}
