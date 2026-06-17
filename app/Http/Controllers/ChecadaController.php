<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ChecadasImport;

class ChecadaController extends Controller
{
    public function index()
    {
        return view('checadas.index');
    }

    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xls,xlsx'
        ]);

        Excel::import(
            new ChecadasImport,
            $request->file('archivo')
        );

        return back()->with('success', 'Archivo importado correctamente.');
    }
}