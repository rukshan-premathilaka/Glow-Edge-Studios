<?php

namespace middleware;

use controller\Helper;
use Exception;


class CsrfToken extends Helper
{

    private bool $tokenCheck = false;
    protected string $tokenName = '_csrf_token';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Generate or get existing token
    public function generate(int $tokenExpirySeconds = 60 * 60): string
    {
        if (empty($_SESSION[$this->tokenName]['value']) || $this->isExpired()) {
            try {
                $_SESSION[$this->tokenName] = [
                    'value' => bin2hex(random_bytes(32)),
                    'expires' => time() + $tokenExpirySeconds,
                ];
            } catch (Exception $e) {
                die('CSRF token generation failed: ' . $e->getMessage());
            }
        }

        return $_SESSION[$this->tokenName]['value'];
    }


    // Validate incoming token
    public function validate(?string $token): void
    {
        if (!$this->tokenCheck) {
            return;
        }

        $sessionToken = $_SESSION[$this->tokenName]['value'] ?? null;

        // Use token from $_POST if $token is null
        if (is_null($token)) {
            $token = isset($_POST[$this->tokenName]) ? (string)$_POST[$this->tokenName] : null;
        }

        // Check if token and session token are valid strings
        if (!is_string($token) || !is_string($sessionToken)) {
            $this->clear();
            echo $this->jsonResponse("error", "Unauthorized request", 401);
            exit;
        }

        // Compare tokens
        if ($token !== $sessionToken) {
            $this->clear();
            echo $this->jsonResponse("error", "Unauthorized request - invalid token", 401);
            exit;
        }

        // Check expiration
        if ($this->isExpired()) {
            $this->clear();
            echo $this->jsonResponse("error", "Unauthorized request - token expired", 401);
            exit;
        }

        // $this->clear(); // clear after use
    }




    // Clear token
    public function clear(): void
    {
        unset($_SESSION[$this->tokenName]);
    }

    public static function clearCSRFToken(): void
    {
        $token = new self();
        $token->clear();
    }

    protected function isExpired(): bool
    {
        return !isset($_SESSION[$this->tokenName]['expires']) || time() > $_SESSION[$this->tokenName]['expires'];
    }


    // Get HTML input tag
    public function getInputHtml(): string
    {
        return '<input type="hidden" name="' . $this->tokenName . '" value="' . $this->generate() . '" />';
    }

    public function getToken(): string
    {
        return $this->generate();
    }

    public function getScriptTag(): string
    {
        $tokenName = htmlspecialchars($this->tokenName, ENT_QUOTES, 'UTF-8');
        $tokenValue = htmlspecialchars($this->generate(), ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <script>
            const csrf = {
                name: "{$tokenName}",
                value: "{$tokenValue}"
            };
        </script>
    HTML;
    }

    public function getTokenName(): string
    {
        return $this->tokenName;
    }

}