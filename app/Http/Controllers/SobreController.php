<?php

namespace App\Http\Controllers;

use App\Models\Sobre;
use Illuminate\Http\Request;

class SobreController extends Controller
{
    public function get_cost()
    {
        $sobre = new Sobre();
        return response()->json($sobre->get_cost());
    }

    public function openPack(Request $request)
    {
        $sobre = new Sobre();
        return response()->json($sobre->genera_sobre($request));
    }
}
