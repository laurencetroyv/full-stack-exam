<?php

require __DIR__ . '/../Database.php';

$config = require __DIR__ . '/../config.php';

$db = new Database($config['database'], 'postgres', 'secret');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') abort(405);

$productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

$branchId = filter_input(INPUT_POST, 'branch_id', FILTER_VALIDATE_INT);

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$action = $_POST['action'] ?? '';

if ($action === 'delete' && $id) {
    $db->query('DELETE FROM product_branch WHERE id=:id', ['id' => $id]);
} elseif ($productId && $branchId) {
    $params = ['product_id' => $productId, 'branch_id' => $branchId, 'stock' => max(0, (int)($_POST['stock'] ?? 0)),
        'price' => max(0, (float)($_POST['price'] ?? 0)), 'branch_status' => $_POST['branch_status'] === 'inactive' ? 'inactive' : 'active',
        'availability' => $_POST['availability'] === 'not_available' ? 'not_available' : 'available'];

    if ($action === 'update' && $id) {
        $params['id'] = $id;
        $db->query('UPDATE product_branch SET stock=:stock, price=:price, branch_status=:branch_status, availability=:availability, updated_at=now() WHERE id=:id', $params);
    } else {
        $db->query('INSERT INTO product_branch (product_id, branch_id, stock, price, branch_status, availability) VALUES (:product_id,:branch_id,:stock,:price,:branch_status,:availability) ON CONFLICT (branch_id, product_id) DO UPDATE SET stock=EXCLUDED.stock, price=EXCLUDED.price, branch_status=EXCLUDED.branch_status, availability=EXCLUDED.availability, updated_at=now()', $params);
    }
}
header('Location: /manage');
exit;
