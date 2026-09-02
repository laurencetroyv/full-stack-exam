<?php

require __DIR__ . '/../Database.php';

$config = require __DIR__ . '/../config.php';

$db = new Database($config['database'], 'postgres', 'secret');

$filters = [
    'branch'    =>  $_GET['branch'] ?? '',
    'status'    =>  $_GET['status'] ?? '',
    'availability'    =>  $_GET['availability'] ?? '',
];

$where = [];
$params = [];

foreach ($filters as $field => $value) {
    if ($value !== '') {
        $column = match($field) {
            'branch'    => 'b.id',
            'status'    => 'pb.branch_status',
            'availability'    => 'pb.availability',
        };

        $where[] = "$column = :$field";
        $params[$field] = $value;
    }
}

$sql = "SELECT pb.id, p.name AS product_name, c.name AS category_name, b.name AS branch_name,
               pb.stock, pb.price, pb.branch_status, pb.availability
        FROM product_branch pb
        JOIN products p ON p.id = pb.product_id
        LEFT JOIN categories c ON c.id = p.category_id
        JOIN branches b ON b.id = pb.branch_id";

if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);

$sql .= ' ORDER BY b.name, p.name';

$assignments = $db->fetchAll($sql, $params);
$branches = $db->fetchAll('SELECT id, name FROM branches ORDER BY name');

require __DIR__ . '/../views/index.view.php';