<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    /*
     * Set the relationship to Job
     */
    public function job()
    {
        return $this->belongsTo('App\Models\Job', 'job_id');
    }
}
