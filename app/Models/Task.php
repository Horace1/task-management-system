<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'project_id',
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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
