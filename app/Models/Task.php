<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;

    protected ?int $previousProjectId = null;

    protected $fillable = [
        'name',
        'project_id',
        'start_date',
        'end_date',
        'description',
        'task_status_id'
    ];

    protected static function booted(): void
    {
        static::updating(function (Task $task) {
            $task->previousProjectId = $task->getOriginal('project_id');
        });

        static::saved(function (Task $task) {
            $task->syncRelatedProjects();
        });

        static::deleted(function (Task $task) {
            $task->syncRelatedProjects();
        });
    }

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

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function taskStatus(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

    protected function syncRelatedProjects(): void
    {
        $projectIds = collect([
            $this->project_id,
            $this->previousProjectId,
        ])
            ->filter()
            ->unique()
            ->values();

        if ($projectIds->isEmpty()) {
            return;
        }

        Project::query()
            ->whereIn('id', $projectIds)
            ->get()
            ->each
            ->refreshProgressAndStatus();
    }
}
