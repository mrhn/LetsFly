<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Class Person
 * @package App
 *
 * @property float $experience
 * @property float $educationLevel
 * @property float $experienceLevel
 * @property array $skillLevels
 *
 * @property Collection|Education[] $education
 * @property Collection|Skill[] $skills
 */
class Person extends Model
{
    const EXPERIENCE_MARK = 3.0;

    public function getSkillLevelsAttribute($value): array
    {
        return $this->skills->reduce(function (array $carry, Skill $skill) {
            $carry[$skill->name] = $this->skillLevel($skill);

            return $carry;
        }, []);
    }

    public function skillLevel(Skill $skill): float
    {
        $skillLevel = $skill->coefficient * $this->educationLevel * $this->experienceLevel;

        return round($skillLevel, 2);
    }

    public function getEducationLevelAttribute($value): float
    {
        return $this->education->max('coefficient');
    }

    public function getExperienceLevelAttribute($value): float
    {
        if ($this->experience >= self::EXPERIENCE_MARK) {
            return 1.0;
        }

        return 1 - (self::EXPERIENCE_MARK - $this->experience) / 10;
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class)
            ->withPivot(['coefficient']);
    }

    public function education(): BelongsToMany
    {
        return $this->belongsToMany(Education::class);
    }
}
