<?php

declare(strict_types=1);

class AdminUserModel
{
    public function __construct(private readonly PDO $db)
    {
    }

    public function findActiveByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT id, nombre, email, password
             FROM usuarios
             WHERE email = :email AND rol = 'administrador' AND activo = 1
             LIMIT 1"
        );
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch();

        return $admin ?: null;
    }

    public function authenticate(string $email, string $password): ?array
    {
        $admin = $this->findActiveByEmail($email);

        if ($admin === null || !password_verify($password, $admin['password'])) {
            return null;
        }

        unset($admin['password']);

        return $admin;
    }
}

