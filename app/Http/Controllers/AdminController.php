<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {


    }

    public function index()
    {

        //TEST
        $users_data = User::query()
        ->where('id', '>', 0)->selectRaw('COUNT(CASE WHEN status = 0 THEN 1 END) as desconectados')
        ->selectRaw('COUNT(CASE WHEN status = 1 THEN 1 END) as conectados')
        ->selectRaw('COUNT(CASE WHEN status = 2 THEN 1 END) as jugando')
        ->first();

        $user_status_count = [$users_data->desconectados, $users_data->conectados, $users_data->jugando];

        return view('admin.home',['data'=>json_encode($user_status_count)]);
    }
}
