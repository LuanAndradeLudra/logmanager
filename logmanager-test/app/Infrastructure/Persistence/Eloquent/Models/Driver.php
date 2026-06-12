<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Database\Factories\Infrastructure\Persistence\Eloquent\Models\DriverFactory;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The factory for the model.
     *
     * @return \Database\Factories\Infrastructure\Persistence\Eloquent\Models\DriverFactory
     */
    protected static function newFactory()
    {
        return DriverFactory::new();
    }

    /**
     * The orders for the driver.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
