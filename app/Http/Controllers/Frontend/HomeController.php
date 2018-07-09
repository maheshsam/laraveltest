<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\JsonResponse;
use Validator;
use Config;

class HomeController extends Controller
{
    /**
     * Responds to requests to GET /admin
     */
    public function __construct() 
    {
    } 

    public function index()
    {
        return redirect(url('/films'));
    }

    public function pagenotfound()
    {
        echo "Error 404 Page";
    }

    public function films(){
        $data["title"] = "Error 404 Page";
        return view('home', $data);   
    }
    
}
