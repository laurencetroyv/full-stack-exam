<?php

require __DIR__ . '/../Database.php';

$config = require __DIR__ . '/../config.php';

$db = new Database($config['database'], 'postgres', 'secret');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') abort(405);

$action = $_POST['action'] ?? '';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($action === 'delete' && $id) {
    // Supports databases created before the cascading FK was added to db.sql.
    $db->query('DELETE FROM product_branch WHERE product_id = :id', ['id' => $id]);
    $db->query('DELETE FROM products WHERE id = :id', ['id' => $id]);
} elseif (in_array($action, ['create', 'update'], true)) {
    $name = trim($_POST['name'] ?? '');
    $categoryId = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT) ?: null;
    $threshold = filter_input(INPUT_POST, 'threshold', FILTER_VALIDATE_INT);

    if ($name === '' || ($action === 'update' && !$id)) { header('Location: /manage?error=product'); exit; }

    $values = ['name' => $name, 'category_id' => $categoryId, 'threshold' => max(0, $threshold ?: 0)];

    if ($action === 'create') {
        $db->query('INSERT INTO products (name, category_id, threshold) VALUES (:name, :category_id, :threshold)', $values);
    } else {
        $values['id'] = $id;
        $values['is_active'] = isset($_POST['is_active']);
        $db->query('UPDATE products SET name=:name, category_id=:category_id, threshold=:threshold, is_active=:is_active, updated_at=now() WHERE id=:id', $values);
    }
}

header('Location: /manage');

exit;
