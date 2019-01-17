<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    const PRIORITIES = ['low', 'medium', 'high', 'extreme'];

    const PRIORITIES_VALUES = ['low' => 25, 'medium' => 50, 'high' => 75, 'extreme' => 100];
}
