<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['log_name', 'description', 'subject_type', 'event', 'subject_id', 'causer_type', 'properties', 'batch_uuid', 'created_at', 'updated_at'];
}
