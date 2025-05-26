<?php

declare(strict_types=1);

namespace AudioTagger\Models;

use PDO;

abstract class BaseModel
{
    protected PDO $db;
    protected string $table;
    protected array $fillable = [];

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    /**
     * @param array<int,mixed> $conditions
     */
    protected function findWhere(array $conditions): array
    {
        $whereClause = implode(
            " AND ",
            array_map(fn($key) => "$key = ?", array_keys($conditions))
        );
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE {$$whereClause}"
        );
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * @param array<int,mixed> $data
     */
    protected function insert(array $data): int
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));

        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} ({$columns} VALUES ({$placeholders})"
        );

        return $this->db->lastInsertId();
    }
}
