<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'start_date',
        'due_date',
        'status'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}