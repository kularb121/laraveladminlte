<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status', 
        'due_date', 
        'assigned_to', 
        'created_by', 
    ];

    public function getStepsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function steps()
    {
        return $this->hasMany(WorkflowStep::class)->orderBy('order');
    }
}