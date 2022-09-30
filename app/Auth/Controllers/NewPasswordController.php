<?php

namespace App\Auth\Controllers;

use App\Controllers\Controller;
use App\Requests\PasswordResetRequest;
use Domain\Auth\Actions\ResetPasswordAction;
use Domain\Auth\Data\PasswordResetData;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(PasswordResetRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = new PasswordResetData(...$request->validated());
        $status = ResetPasswordAction::execute($data);

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }
}
