<?php

namespace csrf;

use Random\RandomException;


class CsrfToken
{
    protected string $tokenName = '_csrf_token';

    // Generate or get existing token
    public function generateCSRF(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($_SESSION[$this->tokenName])) {
            try {
                $_SESSION[$this->tokenName] = bin2hex(random_bytes(32));
            } catch (RandomException $e) {
                error_log('CSRF token generation failed: ' .$e->getMessage());
            }
        }

        return $_SESSION[$this->tokenName];
    }

    // Validate incoming token
    public function validateCSRF(?string $token): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!$token || !isset($_SESSION[$this->tokenName])) {
            return false;
        }

        return hash_equals($_SESSION[$this->tokenName], $token);
    }

    // Clear token
    public function clearCSRF(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        unset($_SESSION[$this->tokenName]);
    }

    // Get HTML input tag
    public function getInputHtml(): string
    {
        return '<input type="hidden" name="' . $this->tokenName . '" value="' . $this->generateCSRF() . '" />';
    }
}