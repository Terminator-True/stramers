<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function show($id = null)
    {
        $user = $id ? User::findOrFail($id) : Auth::user();
        return Inertia::render('User/Profile', [
            'user' => $user,
            'decks' => $user->decks,
            'cards' => $user->cards,
            'achievements' => $user->achievements
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        return $user->updateUser($request);
    }

    public function addFriend($id)
    {
        return User::AddFriend($id);
    }

    public function getFriends()
    {
        $user = Auth::user();
        return $user->friends;
    }

    public function selectDeck(Request $request)
    {
        $user = Auth::user();
        return $user->select_mazo($request);
    }
}
