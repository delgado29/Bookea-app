<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        // For a business employee
        return view('dashboards.employee.index');
    }
}