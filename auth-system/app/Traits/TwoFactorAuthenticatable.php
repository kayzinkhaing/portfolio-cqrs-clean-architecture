<?php

namespace App\Traits;

use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

trait TwoFactorAuthenticatable
{
    /**
     * Enable 2FA for this user and generate a secret.
     */
    public function enableTwoFactor(): void
    {
        $google2fa = new Google2FA();
        $this->two_factor_secret = $google2fa->generateSecretKey();
        $this->two_factor_enabled = true;
        $this->save();
    }

    /**
     * Disable 2FA for this user.
     */
    public function disableTwoFactor(): void
    {
        $this->two_factor_secret = null;
        $this->two_factor_enabled = false;
        $this->save();
    }

    /**
     * Generate QR code for 2FA as SVG string.
     */
    public function getQRCodeInline(): string
    {
        $google2fa = new Google2FA();

        $qrCodeData = $google2fa->getQRCodeUrl(
            config('app.name'),
            $this->email,
            $this->two_factor_secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qrSvg = $writer->writeString($qrCodeData);

        return $qrSvg;
    }

    /**
     * Verify 2FA code.
     */
    public function verifyTwoFactorCode(string $code): bool
    {
        $google2fa = new Google2FA();
        return $google2fa->verifyKey($this->two_factor_secret, $code);
    }
}
