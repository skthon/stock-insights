<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUUID
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $uuidFieldName = $model->getKeyName();
            if (empty($model->{$uuidFieldName})) {
                $model->{$uuidFieldName} = static::generateUuid();
            }
        });
    }

    public static function generateUuid(): string
    {
        return (string) Str::orderedUuid();
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
