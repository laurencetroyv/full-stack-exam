<?php

require __DIR__ . '/../Database.php';

$config = require __DIR__ . '/../config.php';

$db = new Database($config['database'], 'postgres', 'secret');

$query = "SELECT p.id, p.name, p.is_active, p.category_id, p.threshold, c.name AS category_name,
          COUNT(pb.id) AS branch_count
          FROM products p LEFT JOIN categories c ON c.id = p.category_id
          LEFT JOIN product_branch pb ON pb.product_id = p.id
          GROUP BY p.id, c.name ORDER BY p.name";

$products = $db->fetchAll($query);
$categories = $db->fetchAll("SELECT id, name FROM categories ORDER BY name");
$branches = $db->fetchAll("SELECT id, name FROM branches ORDER BY name");
$assignments = $db->fetchAll(
    'SELECT id, product_id, branch_id, stock, price, branch_status, availability
     FROM product_branch ORDER BY product_id, branch_id'
);

require __DIR__ . '/../views/manage.view.php';
