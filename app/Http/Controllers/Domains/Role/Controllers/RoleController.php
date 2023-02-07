<?php

namespace App\Http\Controllers\Domains\Role\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('backend.role.index');
    }
}
