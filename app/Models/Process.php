<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table = 'process';

    protected $primaryKey = 'IdProcess';

    public $timestamps = false;

    protected $fillable = [
        'IdCustomer',
        'Estado',
        'Fecha',
        'Observacion',
        'Historial',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'IdCustomer', 'IdCustomer');
    }
}
