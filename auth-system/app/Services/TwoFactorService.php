<?php

namespace App\Services;

use App\Contracts\TwoFactorRepositoryInterface;
use App\Models\User;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorService
{
    protected Google2FA $google2fa;
    protected TwoFactorRepositoryInterface $repository;

    public function __construct(Google2FA $google2fa, TwoFactorRepositoryInterface $repository)
    {
        $this->google2fa = $google2fa;
        $this->repository = $repository;
    }

    public function enable(User $user): array
    {
        $secret = $this->google2fa->generateSecretKey();
        $user = $this->repository->enable($user, $secret);

        // generate QR code
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(config('app.name'), $user->email, $secret);

        return [
            'user' => $user,
            'qr_code' => $qrCodeUrl,
            'secret' => $secret,
        ];
    }

    public function disable(User $user): User
    {
        return $this->repository->disable($user);
    }

    public function verify(User $user, string $code): bool
    {
        return $this->google2fa->verifyKey($user->two_factor_secret, $code);
    }
}
