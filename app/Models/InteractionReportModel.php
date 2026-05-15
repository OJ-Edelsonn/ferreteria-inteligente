<?php

declare(strict_types=1);

class InteractionReportModel
{
    public function __construct(private readonly PDO $db)
    {
    }

    public function totalInteractions(): int
    {
        return (int) $this->db
            ->query('SELECT COUNT(*) FROM interacciones')
            ->fetchColumn();
    }

    public function totalSearches(): int
    {
        return $this->countByType('busqueda');
    }

    public function totalProductViews(): int
    {
        return $this->countByType('producto_visto');
    }

    public function searchesWithoutResults(): int
    {
        return (int) $this->db
            ->query("SELECT COUNT(*) FROM interacciones WHERE tipo_interaccion = 'busqueda' AND resultados = 0")
            ->fetchColumn();
    }

    public function topSearches(int $limit = 8): array
    {
        $stmt = $this->db->prepare(
            "SELECT termino_busqueda, COUNT(*) AS total, MAX(fecha) AS ultima_fecha
             FROM interacciones
             WHERE tipo_interaccion = 'busqueda' AND termino_busqueda IS NOT NULL
             GROUP BY termino_busqueda
             ORDER BY total DESC, ultima_fecha DESC
             LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function topViewedProducts(int $limit = 8): array
    {
        $stmt = $this->db->prepare(
            "SELECT p.nombre, COUNT(i.id) AS total, MAX(i.fecha) AS ultima_fecha
             FROM interacciones i
             INNER JOIN productos p ON p.id = i.producto_id
             WHERE i.tipo_interaccion = 'producto_visto'
             GROUP BY p.id, p.nombre
             ORDER BY total DESC, ultima_fecha DESC
             LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function recent(int $limit = 20): array
    {
        $stmt = $this->db->prepare(
            "SELECT i.tipo_interaccion, i.termino_busqueda, i.resultados, i.ip, i.fecha, p.nombre AS producto
             FROM interacciones i
             LEFT JOIN productos p ON p.id = i.producto_id
             ORDER BY i.fecha DESC, i.id DESC
             LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    private function countByType(string $type): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM interacciones WHERE tipo_interaccion = :type');
        $stmt->execute(['type' => $type]);

        return (int) $stmt->fetchColumn();
    }
}

