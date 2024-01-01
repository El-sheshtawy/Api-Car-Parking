<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     *  Get User
     *
     *  get a user
     */
    public function __invoke(Request $request)
    {
        return $request->user();
    }
}
