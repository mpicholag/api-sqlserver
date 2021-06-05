<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\Roles;

class Test extends Controller
{
    public function index() {
        $admin = Roles::getDescription(Roles::ADMIN);
        return response($admin);
    }
}
