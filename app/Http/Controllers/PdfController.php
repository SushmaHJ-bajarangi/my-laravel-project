<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;
use App\Models\Crm;

class PdfController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');

    }

    public function generatevantagepdf()
    {
        // Load the Blade view
        $pdf = Pdf::loadView('customer_products.vantageadvertising');

        // Stream the PDF to the browser
        return $pdf->stream('vantage_offer.pdf');  // This will download the PDF in the browser

        // Or you can force the download instead of streaming:
        // return $pdf->download('vantage_offer.pdf');
    }
}