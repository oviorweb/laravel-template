<?php

namespace App\Auth\Controllers;

use App\Auth\Requests\RegisterRequest;
use App\Controllers\Controller;
use Domain\Auth\Actions\CreateUserAction;
use Domain\Auth\Data\UserData;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function store(RegisterRequest $request): Response
    {
        $data = new UserData(...$request->validated());
        $user = CreateUserAction::execute($data);

        Auth::login($user);

        return response()->noContent();
    }
}
