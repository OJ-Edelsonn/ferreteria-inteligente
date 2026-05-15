<?php

declare(strict_types=1);

class ProductModel
{
    public function __construct(private readonly PDO $db)
    {
    }

    public function getFeatured(int $limit = 6): array
    {
        $stmt = $this->db->prepare(
            "SELECT p.id, p.categoria_id, p.nombre, p.descripcion, p.precio, p.stock, p.imagen, c.nombre AS categoria
             FROM productos p
             INNER JOIN categorias c ON c.id = p.categoria_id
             WHERE p.activo = 1
             ORDER BY p.nombre ASC
             LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function search(?int $categoryId = null, string $term = ''): array
    {
        $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.stock, p.imagen, c.nombre AS categoria
                FROM productos p
                INNER JOIN categorias c ON c.id = p.categoria_id
                WHERE p.activo = 1";
        $params = [];

        if ($categoryId !== null) {
            $sql .= " AND p.categoria_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        if ($term !== '') {
            $sql .= " AND (
                p.nombre LIKE :term_name
                OR p.descripcion LIKE :term_description
                OR c.nombre LIKE :term_category
            )";
            $params['term_name'] = '%' . $term . '%';
            $params['term_description'] = '%' . $term . '%';
            $params['term_category'] = '%' . $term . '%';
        }

        $sql .= " ORDER BY p.nombre ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT p.id, p.categoria_id, p.nombre, p.descripcion, p.precio, p.stock, p.imagen, c.nombre AS categoria
             FROM productos p
             INNER JOIN categorias c ON c.id = p.categoria_id
             WHERE p.id = :id AND p.activo = 1
             LIMIT 1"
        );
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();

        return $product ?: null;
    }

    public function getCategories(): array
    {
        $stmt = $this->db->query(
            "SELECT id, nombre, descripcion
             FROM categorias
             WHERE activo = 1
             ORDER BY nombre ASC"
        );

        return $stmt->fetchAll();
    }

    public function countActive(): int
    {
        return (int) $this->db
            ->query("SELECT COUNT(*) FROM productos WHERE activo = 1")
            ->fetchColumn();
    }

    public function countLowStock(int $threshold = 10): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*)
             FROM productos
             WHERE activo = 1 AND stock <= :threshold"
        );
        $stmt->execute(['threshold' => $threshold]);

        return (int) $stmt->fetchColumn();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO productos
                (categoria_id, nombre, descripcion, precio, stock, imagen)
             VALUES
                (:categoria_id, :nombre, :descripcion, :precio, :stock, :imagen)"
        );
        $stmt->execute($this->productParams($data));

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $params = $this->productParams($data);
        $params['id'] = $id;

        $stmt = $this->db->prepare(
            "UPDATE productos SET
                categoria_id = :categoria_id,
                nombre = :nombre,
                descripcion = :descripcion,
                precio = :precio,
                stock = :stock,
                imagen = :imagen
             WHERE id = :id AND activo = 1"
        );

        return $stmt->execute($params);
    }

    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE productos SET activo = 0 WHERE id = :id");

        return $stmt->execute(['id' => $id]);
    }

    private function productParams(array $data): array
    {
        return [
            'categoria_id' => (int) $data['categoria_id'],
            'nombre' => trim((string) $data['nombre']),
            'descripcion' => trim((string) ($data['descripcion'] ?? '')),
            'precio' => (float) $data['precio'],
            'stock' => (int) $data['stock'],
            'imagen' => trim((string) ($data['imagen'] ?? '')) ?: null,
        ];
    }
}
