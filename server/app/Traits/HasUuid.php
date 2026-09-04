<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Boot the trait: automatically assign a UUID when a model is created.
     * The auto-increment `id` column remains the primary key used for
     * foreign keys and joins; `uuid` is exposed publicly (routes, APIs)
     * so internal IDs are never leaked.
     */
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Resolve route bindings using the uuid column instead of the
     * incrementing id, so routes like /books/{book} use the UUID.
     * Optional — remove this method if you prefer route binding by id.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
