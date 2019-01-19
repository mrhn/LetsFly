<?php

namespace App;

use App\Jobs\SuggestTeamJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Team
 * @package App
 *
 * @property string $priority
 * @property float $priorityValue
 * @property Collection|Person[] $people
 */
class Team extends Model
{
    const PRIORITIES = ['low', 'medium', 'high', 'extreme'];

    const PRIORITIES_VALUES = ['low' => 0.25, 'medium' => 0.5, 'high' => 0.75, 'extreme' => 1];

    protected $fillable = [
        'name', 'priority',
    ];

    public function getPriorityValueAttribute($value)
    {
        return self::PRIORITIES_VALUES[$this->attributes['priority']];
    }

    public function getFitAttribute()
    {
        return round($this->people->sum(function (Person $person): float {
            return $person->skillLevel($person->skills->firstWhere('name', $person->skill));
        }) / $this->people->count(), 4);
    }

    public function suggestTeam(array $teamComposition): void
    {
        dispatch(new SuggestTeamJob($this, $teamComposition));
    }

    public function people()
    {
        return $this->belongsToMany(Person::class)
            ->withPivot(['skill']);
    }
}
