<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Class Person
 * @package App
 *
 * @property integer $id
 * @property float $experience
 * @property float $educationLevel
 * @property float $experienceLevel
 * @property array $skillLevels
 * @property string $skill pivot value
 * @property string|null $forSkill tmp value for suggestion
 *
 * @property Collection|Education[] $education
 * @property Collection|Skill[] $skills
 */
class Person extends Model
{
    const EXPERIENCE_MARK = 3.0;

    protected $casts = [
        'experience' => 'float',
    ];

    public function getSkillLevelsAttribute(): array
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

    public function getSkill(string $skill): Skill
    {
        return $this->skills->firstWhere('name', $skill);
    }

    public function getSkillAttribute(): ?string
    {
        return $this->pivot->skill ?? null;
    }

    public function getEducationLevelAttribute(): float
    {
        return $this->education->max('coefficient');
    }

    public function getExperienceLevelAttribute(): float
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
