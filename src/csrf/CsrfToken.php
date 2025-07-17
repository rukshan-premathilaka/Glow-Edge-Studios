<?php

namespace csrf;

use Random\RandomException;


class CsrfToken
{
    protected string $tokenName = '_csrf_token';
    protected int $tokenExpirySeconds = 60 * 60; // 1 hour


    // Generate or get existing token
    public function generateCSRF(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($_SESSION[$this->tokenName]['value']) || $this->isCsrfExpired()) {
            try {
                $_SESSION[$this->tokenName] = [
                    'value' => bin2hex(random_bytes(32)),
                    'expires' => time() + $this->tokenExpirySeconds,
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
}