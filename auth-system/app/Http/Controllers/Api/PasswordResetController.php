<?php

namespace App\Http\Controllers\Api;

use App\Application\Buses\QueryBus;
use App\Http\Controllers\Controller;
use App\Application\Buses\CommandBus;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Application\Commands\ResetPasswordCommand;
use App\Application\Commands\SendPasswordResetLinkCommand;
use App\Http\Resources\PasswordResetMessageResource;

class PasswordResetController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $success = $this->commandBus->dispatch(
            new SendPasswordResetLinkCommand($request->email)
        );

        return new PasswordResetMessageResource((object) [
            'success' => $success,
            'message' => $success ? 'Reset link sent! Please check your mail.' : 'Failed to send reset link',
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $success = $this->commandBus->dispatch(
            new ResetPasswordCommand($request->email, $request->token, $request->password)
        );

        return (new PasswordResetMessageResource((object) [
            'success' => $success,
            'message' => $success ? 'Password reset successfully!' : 'Failed to reset password',
        ]))->response()->setStatusCode($success ? 200 : 400);
    }
}
