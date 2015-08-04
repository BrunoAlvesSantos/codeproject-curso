<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectNote extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'note'
    ];

   public function project(){
        return $this->belongsTo(Project::class);
   }
}
