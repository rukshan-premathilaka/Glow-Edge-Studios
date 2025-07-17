<?php

namespace csrf;

use Random\RandomException;


class CsrfToken
{
    protected string $tokenName = '_csrf_token';


    // Generate or get existing token
    public function generateCSRF(int $tokenExpirySeconds = 60 * 60): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($_SESSION[$this->tokenName]['value']) || $this->isCsrfExpired()) {
            try {
                $_SESSION[$this->tokenName] = [
                    'value' => bin2hex(random_bytes(32)),
                    'expires' => time() + $tokenExpirySeconds,
                ];
            } catch (RandomException $e) {
                error_log('CSRF token generation failed: ' . $e->getMessage());
            }
        }

        return $_SESSION[$this->tokenName]['value'];
    }


    // Validate incoming token
    public function validateCSRF(?string $token): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!is_string($token) || !isset($_SESSION[$this->tokenName]['value'])) {
            return false;
        }

        if ($this->isCsrfExpired()) {
            $this->clearCSRF();
            return false;
        }

        return hash_equals($_SESSION[$this->tokenName]['value'], $token);
    }


    // Clear token
    public function clearCSRF(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        unset($_SESSION[$this->tokenName]);
    }

    protected function isCsrfExpired(): bool
    {
        return !isset($_SESSION[$this->tokenName]['expires']) || time() > $_SESSION[$this->tokenName]['expires'];
    }


    // Get HTML input tag
    public function getCsrfInputHtml(): string
    {
        return '<input type="hidden" name="' . $this->tokenName . '" value="' . $this->generateCSRF() . '" />';
    }

    public function getCsrfToken(): string
    {
        return $this->generateCSRF();
    }

    public function getTokenScriptTag(): string
    {
        $tokenName = htmlspecialchars($this->tokenName, ENT_QUOTES, 'UTF-8');
        $tokenValue = htmlspecialchars($this->generateCSRF(), ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <script>
            const csrf = {
                name: "{$tokenName}",
                value: "{$tokenValue}"
            };
        </script>
    HTML;
    }


}