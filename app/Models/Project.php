<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'start_date',
        'end_date',
        'description',
        'progress',
        'project_status_id'
    ];

    public function getFormattedStartDateAttribute()
    {
        $startDate = Carbon::parse($this->attributes['start_date']);

        return $startDate->format('d/m/Y');
    }

    public function getFormattedEndDateAttribute()
    {
        $endDate = Carbon::parse($this->attributes['end_date']);

        return $endDate->format('d/m/Y');
    }

    public function getTaskCountAttribute()
    {
        return $this->tasks->count();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    public function refreshProgressAndStatus(): void
    {
        $taskStatusNames = $this->tasks()
            ->with('taskStatus:id,name')
            ->get()
            ->pluck('taskStatus.name')
            ->filter()
            ->values();

        $progress = static::calculateProgress($taskStatusNames);
        $projectStatusId = static::resolveProjectStatusId($taskStatusNames);

        if (
            (int) $this->progress === $progress
            && (int) $this->project_status_id === $projectStatusId
        ) {
            return;
        }

        $this->forceFill([
            'progress' => $progress,
            'project_status_id' => $projectStatusId,
        ])->saveQuietly();

        $this->unsetRelation('status');
    }

    public static function calculateProgress(Collection $taskStatusNames): int
    {
        $totalTasks = $taskStatusNames->count();

        if ($totalTasks === 0) {
            return 0;
        }

        $completedTasks = $taskStatusNames
            ->filter(fn (string $statusName) => strcasecmp($statusName, 'Done') === 0)
            ->count();

        return (int) round(($completedTasks / $totalTasks) * 100);
    }

    public static function resolveProjectStatusId(Collection $taskStatusNames): int
    {
        $normalizedStatuses = $taskStatusNames
            ->map(fn (string $statusName) => strtolower(trim($statusName)))
            ->values();

        $projectStatusName = match (true) {
            $normalizedStatuses->isEmpty() => 'Not Started',
            $normalizedStatuses->every(fn (string $statusName) => $statusName === 'done') => 'Completed',
            $normalizedStatuses->contains('in progress')
                || $normalizedStatuses->contains('done') => 'In Progress',
            $normalizedStatuses->contains('pending') => 'Pending',
            default => 'Not Started',
        };

        return static::projectStatusIdByName($projectStatusName);
    }

    protected static function projectStatusIdByName(string $statusName): int
    {
        $statusId = ProjectStatus::query()
            ->where('name', $statusName)
            ->value('id');

        if ($statusId === null) {
            throw new \RuntimeException("Project status [{$statusName}] could not be resolved.");
        }

        return (int) $statusId;
    }
}
