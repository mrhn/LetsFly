<?php

namespace App;

use App\Jobs\SuggestTeamJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    /** @var array */
    const PRIORITIES = ['low', 'medium', 'high', 'extreme'];

    /** @var array */
    const PRIORITIES_VALUES = ['low' => 0.25, 'medium' => 0.5, 'high' => 0.75, 'extreme' => 1];

    protected $fillable = [
        'name', 'priority',
    ];

    public function getPriorityValueAttribute(): string
    {
        return self::PRIORITIES_VALUES[$this->attributes['priority']];
    }

    public function getFitAttribute(): float
    {
        $personSkillLevel = $this->people->sum(function (Person $person): float {
            return $person->skillLevel($person->getSkill($person->skill));
        }) / $this->people->count();

        return round($personSkillLevel / $this->priorityValue * 100, 4);
    }

    /**
     * @param TeamComposition[] $teamComposition
     */
    public function suggestTeam(array $teamComposition): void
    {
        dispatch(new SuggestTeamJob($this, $teamComposition));
    }

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)
            ->withPivot(['skill']);
    }
}
