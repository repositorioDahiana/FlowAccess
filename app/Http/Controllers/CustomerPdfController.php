<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerPdfController
{
    public function generate(Customer $customer)
    {
        $pdf = Pdf::loadView('pdf.customer-ticket', [
            'customer' => $customer,
        ]);

        return $pdf->download(
            'Registro-'.$customer->CodigoCustomer.'.pdf'
        );
    }
}