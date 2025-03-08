<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        // You can pass data to the view, e.g. appointments for this customer.
        return view('dashboards.customer.index'); 
    }
}