<?php

namespace App\Http\Controllers\ClientView;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientViewController extends Controller
{
    //

    public function index() {
        return view('client.appointment-request');
    }
}
