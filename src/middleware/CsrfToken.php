<?php

namespace middleware;

use Random\RandomException;


class CsrfToken
{
    protected string $tokenName = '_csrf_token';


    // Generate or get existing token
    public function generate(int $tokenExpirySeconds = 60): string
    {
        $this->ensureSession();

        if (empty($_SESSION[$this->tokenName]['value']) || $this->isExpired()) {
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
    public function validate(): void
    {
        $this->ensureSession();

        if (!is_string($_POST[$this->tokenName]) || !isset($_SESSION[$this->tokenName]['value'])) {
            $this->clear();
            http_response_code(401);
            echo "Unauthorized request";
            exit;
        }

        if ($_POST[$this->tokenName] !== $_SESSION[$this->tokenName]['value']) {
            $this->clear();
            http_response_code(401);
            echo "Unauthorized request: invalid token";
            exit;
        }

        if ($this->isExpired()) {
            $this->clear();
            http_response_code(401);
            echo "Unauthorized request: token expired, please refresh the page";
            exit;
        }

        $this->clear();
    }


    // Clear token
    public function clear(): void
    {
        $this->ensureSession();

        unset($_SESSION[$this->tokenName]);
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

    // Session start
    protected function ensureSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }


}