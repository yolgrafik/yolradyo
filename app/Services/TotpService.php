<?php

namespace App\Services;

class TotpService
{
    protected int $period = 30;
    protected int $digits = 6;

    public function generateSecret(): string
    {
        $bytes = random_bytes(20);
        return $this->base32Encode($bytes);
    }

    public function getCurrentOtp(string $secret): string
    {
        $counter = (int) floor(time() / $this->period);
        return $this->hotp($secret, $counter);
    }

    public function verify(string $secret, string $code): bool
    {
        $code = preg_replace('/\s/', '', $code);
        if (strlen($code) !== $this->digits || !ctype_digit($code)) {
            return false;
        }
        $counter = (int) floor(time() / $this->period);
        for ($i = -1; $i <= 1; $i++) {
            if ($this->hotp($secret, $counter + $i) === $code) {
                return true;
            }
        }
        return false;
    }

    public function getProvisioningUri(string $email, string $secret, string $issuer = 'RADYOYOL'): string
    {
        $params = [
            'secret' => $secret,
            'issuer' => $issuer,
            'algorithm' => 'SHA1',
            'digits' => $this->digits,
            'period' => $this->period,
        ];
        $query = http_build_query($params);
        return 'otpauth://totp/' . rawurlencode($issuer . ':' . $email) . '?' . $query;
    }

    protected function hotp(string $secret, int $counter): string
    {
        $binaryCounter = pack('N*', 0) . pack('N*', $counter);
        $hash = hash_hmac('sha1', $binaryCounter, $this->base32Decode($secret), true);
        $offset = ord($hash[strlen($hash) - 1]) & 0x0f;
        $truncated = (
            ((ord($hash[$offset]) & 0x7f) << 24) |
            ((ord($hash[$offset + 1]) & 0xff) << 16) |
            ((ord($hash[$offset + 2]) & 0xff) << 8) |
            (ord($hash[$offset + 3]) & 0xff)
        );
        return str_pad((string) ($truncated % (10 ** $this->digits)), $this->digits, '0', STR_PAD_LEFT);
    }

    protected function base32Encode(string $data): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $output = '';
        $v = 0;
        $vBits = 0;
        for ($i = 0; $i < strlen($data); $i++) {
            $v = ($v << 8) | ord($data[$i]);
            $vBits += 8;
            while ($vBits >= 5) {
                $vBits -= 5;
                $output .= $alphabet[($v >> $vBits) & 31];
            }
        }
        if ($vBits > 0) {
            $output .= $alphabet[($v << (5 - $vBits)) & 31];
        }
        return $output;
    }

    protected function base32Decode(string $data): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $data = strtoupper($data);
        $data = rtrim($data, '=');
        $v = 0;
        $vBits = 0;
        $output = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $c = $data[$i];
            $pos = strpos($alphabet, $c);
            if ($pos === false) {
                continue;
            }
            $v = ($v << 5) | $pos;
            $vBits += 5;
            if ($vBits >= 8) {
                $vBits -= 8;
                $output .= chr(($v >> $vBits) & 0xff);
            }
        }
        return $output;
    }

    public function generateRecoveryCodes(int $count = 8): array
    {
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $codes[] = strtoupper(bin2hex(random_bytes(4)));
        }
        return $codes;
    }
}
