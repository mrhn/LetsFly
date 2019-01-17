<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 * @package App
 *
 * @property string $name
 * @property float|null $coefficient
 * @property array $pivot
 */
class Skill extends Model
{
    public function getCoefficientAttribute(): ?float
    {
        return $this->pivot['coefficient'] ?? null;
    }
}
