<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ChecadasImport;
use App\Exports\ChecadasExport;

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

        $import = new ChecadasImport();

        Excel::import(
            $import,
            $request->file('archivo')
        );

        return Excel::download(
            new ChecadasExport($import->resultado),
            'CHECADAS.xlsx'
        );
    }
}