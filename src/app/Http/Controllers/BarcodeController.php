<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class BarcodeController extends Controller
{
    public function display() : View
    {
        return view('barcode.display');
    }

    public function scanner() : View
    {
        return view('barcode.scanner');
    }
}
