<?php

namespace App\Support;

/**
 * Mock authentication (mirrors hotel/react stores/auth.ts).
 *
 * Any non-empty email/password logs in. A suggested demo account
 * (recepcao@hotel.com / demo123) is shown on the login screen.
 */
class MockUsers
{
    public const DEMO_EMAIL = 'recepcao@hotel.com';
    public const DEMO_PASSWORD = 'demo123';

    /**
     * @return array{id:int,name:string,email:string,role:string,phone:string}|null
     */
    public function authenticate(string $email, string $password): ?array
    {
        if ($email === '' || $password === '') {
            return null;
        }

        $isDemo = $email === self::DEMO_EMAIL;
        $handle = explode('@', $email)[0] ?: 'Recepção';
        $raw = trim(preg_replace('/[._-]/', ' ', $handle)) ?: 'Recepção';
        $name = $isDemo ? 'Helena Castro' : ucfirst($raw);

        return [
            'id' => 1,
            'name' => $name,
            'email' => $email,
            'role' => 'Recepção',
            'phone' => '+55 11 4000-2000',
        ];
    }

    /** @return array<string,mixed> */
    public function register(string $name, string $email): array
    {
        return [
            'id' => 1,
            'name' => $name,
            'email' => $email,
            'role' => 'Recepção',
            'phone' => '',
        ];
    }
}
