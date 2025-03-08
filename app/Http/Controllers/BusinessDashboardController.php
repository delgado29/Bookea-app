<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service; // Asegúrate de importar el modelo Service

class BusinessDashboardController extends Controller
{
    public function index()
    {
        // Obtener los servicios del negocio asociado al usuario autenticado
        $services = Service::where('business_id', auth()->user()->business_id)->get(); 

        // Pasar los servicios a la vista
        return view('dashboards.business.index', compact('services'));
    }
}
