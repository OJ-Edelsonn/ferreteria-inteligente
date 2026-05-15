<?php

declare(strict_types=1);

class InteractionModel
{
    public function __construct(private readonly PDO $db)
    {
    }

    public function registerSearch(string $term, int $results, ?string $user = null): bool
    {
        $term = trim($term);

        if ($term === '') {
            return false;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO interacciones
                (tipo_interaccion, termino_busqueda, resultados, usuario, ip, user_agent)
             VALUES
                ('busqueda', :term, :results, :user, :ip, :user_agent)"
        );

        return $stmt->execute([
            'term' => substr($term, 0, 150),
            'results' => $results,
            'user' => $user,
            'ip' => $this->getIp(),
            'user_agent' => $this->getUserAgent(),
        ]);
    }

    public function registerProductView(int $productId, ?string $user = null): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO interacciones
                (tipo_interaccion, producto_id, usuario, ip, user_agent)
             VALUES
                ('producto_visto', :product_id, :user, :ip, :user_agent)"
        );

        return $stmt->execute([
            'product_id' => $productId,
            'user' => $user,
            'ip' => $this->getIp(),
            'user_agent' => $this->getUserAgent(),
        ]);
    }

    private function getIp(): ?string
    {
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }

    private function getUserAgent(): ?string
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

        return $userAgent ? substr($userAgent, 0, 255) : null;
    }
}
