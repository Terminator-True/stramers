<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function index() {
        return Inertia::render('Shop/Shop');
    }
    

    /**
     * @param Request
     * @return Bool
     */
    public function addCardToUser(Request $request)
    {
        return User::AddCard($request);
    }
}
