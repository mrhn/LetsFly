<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 * @package App
 */
class Person extends Model
{
    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }
}
