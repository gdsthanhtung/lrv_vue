<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enumeration extends Model
{
    use HasFactory;

    /* RELATIONSHIP */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function status()
    {
        return $this->belongsTo(Enumeration::class, 'status_id');
    }
}
