<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointment';

    protected $primaryKey = 'IdAppointment';

    protected $fillable = [
        'IdCustomer',
        'IdAvailability',
        'Status',
        'Notes',
    ];

    public function customer()
    {
        return $this->belongsTo(
            Customer::class,
            'IdCustomer',
            'IdCustomer'
        );
    }

    public function availability()
    {
        return $this->belongsTo(
            Availability::class,
            'IdAvailability',
            'IdAvailability'
        );
    }
}