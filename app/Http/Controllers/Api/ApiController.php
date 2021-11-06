<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contacto;
use App\Roles;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function viewDataLead(Request $request)
    {
        //return $request;
        $contacto = Contacto::where('cedula', $request->cedula)->first();
        if (!empty($contacto)) {
            return response()->json(['msg' => 'success', 'data' => $contacto]);
        } else {
            return response()->json(['msg' => 'error', 'data' => 'No existe datos del aspirante']);
        }
    }
}
