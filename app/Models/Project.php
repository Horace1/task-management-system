<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

}
