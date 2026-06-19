<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $table = 'availability';

    protected $primaryKey = 'IdAvailability';

    protected $fillable = [
        'AvailableDate',
        'AvailableTime',
        'Status',
    ];

    protected $casts = [
        'AvailableDate' => 'date',
        'Status' => 'boolean',
    ];

    public function appointments()
    {
        return $this->hasMany(
            Appointment::class,
            'IdAvailability',
            'IdAvailability'
        );
    }
}