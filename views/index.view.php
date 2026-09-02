<?php $page = "home"; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="text-scale" content="scale">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/homepage.css">

    <title>Reports</title>
</head>
<body style="min-height: 100vh">
<?php require __DIR__ . '/partials/header.php' ?>

<main class="container">
    <form class="filter-bar" method="get">
        <label for="branch">Location</label>
        <select name="branch" id="branch">
            <option value="">All Branches</option>
            <?php foreach ($branches as $branch): ?>
                <option value="<?= $branch['id'] ?>" <?= $filters['branch'] === $branch['id'] ? 'selected' : '' ?>>
                    <?= $branch['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="product_status">Registry status</label>
        <select name="product_status" id="product_status">
            <option value="">Any registry status</option>
            <option value="active" <?= $filters['product_status'] === 'active' ? 'selected' : '' ?>>
                Active
            </option>
            <option value="inactive" <?= $filters['product_status'] === 'inactive' ? 'selected' : '' ?>>
                Inactive
            </option>
        </select>

        <label for="status">Branch status</label>
        <select name="status" id="status">
            <option value="">Any Status</option>
            <option value="active" <?= $filters['status'] === 'active' ? 'selected' : '' ?>>
                Active
            </option>
            <option value="inactive" <?= $filters['status'] === 'inactive' ? 'selected' : '' ?>>
                Inactive
            </option>
        </select>

        <label for="availability">Availability</label>
        <select name="availability" id="availability">
            <option value="">Any availability</option>
            <option value="available" <?= $filters['availability'] === 'available' ? 'selected' : '' ?>>
                Available
            </option>
            <option value="not_available" <?= $filters['availability'] === 'not_available' ? 'selected' : '' ?>>
                Not Available
            </option>
        </select>

        <button class="btn btn-primary" type="submit">Generate Report</button>
        <a class="text-link" href="/">Clear</a>
    </form>

    <section class="table-card">
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Registry</th>
                        <th>Status</th>
                        <th>Availability</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!$assignments): ?>
                <tr>
                    <td colspan="8" class="empty">No data found</td>
                </tr>
                <?php endif; foreach ($assignments as $item): ?>
                    <?php $productIsActive = $item['product_is_active'] === true || $item['product_is_active'] === 't' || $item['product_is_active'] === 1 || $item['product_is_active'] === '1'; ?>
                    <tr class="<?= $productIsActive ? '' : 'product-inactive' ?>">
                        <td class="material-name"><?= $item['product_name'] ?></td>
                        <td><?= $item['category_name'] ?? 'Not Categorized' ?></td>
                        <td><?= $item['branch_name'] ?></td>
                        <td><?= $item['stock'] ?></td>
                        <td><?= number_format($item['price'], 2) ?></td>
                        <td>
                            <span class="pill <?= $productIsActive ? 'active' : 'inactive' ?>">
                                <?= $productIsActive ? 'Active' : 'Inactive globally' ?>
                            </span>
                        </td>
                        <td>
                            <span class="pill <?= $item['branch_status'] ?>">
                                <?= ucfirst($item['branch_status']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="availability <?= $item['availability'] ?>">
                                <?= $item['availability'] === 'available' ? 'Available' : 'Not Available' ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
</body>
</html>
