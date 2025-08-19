<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TwoFactorVerifyRequest;
use App\Application\Commands\EnableTwoFactorCommand;
use App\Application\Commands\VerifyTwoFactorCommand;
use App\Application\Commands\DisableTwoFactorCommand;
use App\Application\Buses\CommandBus;
use App\Http\Resources\TwoFactorResource;
use App\Http\Resources\TwoFactorMessageResource;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus
    ) {}

    public function enable()
    {
        $user = Auth::user();

        $result = $this->commandBus->dispatch(
            new EnableTwoFactorCommand($user)
        );

        return new TwoFactorResource((object) $result);
    }

    public function verify(TwoFactorVerifyRequest $request)
    {
        $user = Auth::user();

        $isValid = $this->commandBus->dispatch(
            new VerifyTwoFactorCommand($user, $request->code)
        );

        return (new TwoFactorMessageResource((object) [
            'success' => $isValid,
            'message' => $isValid ? '2FA verified successfully' : 'Invalid 2FA code',
        ]))->response()->setStatusCode($isValid ? 200 : 401);
    }

    public function disable()
    {
        $user = Auth::user();

        $this->commandBus->dispatch(
            new DisableTwoFactorCommand($user)
        );

        return new TwoFactorMessageResource((object) [
            'success' => true,
            'message' => '2FA disabled successfully',
        ]);
    }
}
