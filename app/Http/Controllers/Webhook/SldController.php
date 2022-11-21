<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SldController extends Controller
{
    public function call(Request $request)
    {
        Log::info("Information SLD:", $request->all());
        return ($request->all());
    }
}
