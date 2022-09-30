<?php

namespace App\Auth\Controllers;

use App\Controllers\Controller;
use Domain\Auth\Actions\ResetPasswordAction;
use Domain\Auth\Data\PasswordResetData;
use Illuminate\Http\Request;
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
    public function store(PasswordResetData $data): \Illuminate\Http\JsonResponse
    {
        $status = ResetPasswordAction::execute($data);

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }
}
