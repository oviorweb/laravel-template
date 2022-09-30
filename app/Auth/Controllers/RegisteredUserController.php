<?php

namespace App\Auth\Controllers;

use App\Controllers\Controller;
use Domain\Auth\Actions\CreateUserAction;
use Domain\Auth\Data\UserData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  UserData  $data
     * @return Response
     */
    public function store(UserData $data): Response
    {
        $user = CreateUserAction::execute($data);

        Auth::login($user);

        return response()->noContent();
    }
}
