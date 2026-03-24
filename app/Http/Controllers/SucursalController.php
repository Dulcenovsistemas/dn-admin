<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return view('modules.sucursales.index', compact('branches'));
    }
}