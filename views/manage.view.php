<?php $page = "manage"; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/manage.css">

    <title>Manage</title>
</head>
<body>
<?php require __DIR__ . '/partials/header.php' ?>

<main class="container">
    <section class="manage-top">
        <p>Material Registry</p>
        <button class="btn btn-primary" popovertarget="product-dialog">Add Product</button>
    </section>

    <section class="table-card">
        <div class="table-scroll">
            <table>
                <thead>
                <tr>
                    <th>Material</th>
                    <th>Category</th>
                    <th>Reorder at</th>
                    <th>Assigned locations</th>
                    <th>Registry status</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['category_name'] ?? 'Not Categorized'; ?></td>
                        <td><?= (int)$product['threshold'] ?></td>
                        <td><?= (int)$product['branch_count'] ?></td>
                        <td>
                                <span class="pill <?= $product['is_active'] ? 'active' : 'inactive' ?>">
                                    <?= $product['is_active'] ? 'Active' : 'Inactive' ?>
                                </span>
                        </td>
                        <td class="actions">
                            <button data-edit-product='<?= htmlspecialchars(json_encode($product), ENT_QUOTES) ?>' popovertarget="product-dialog">Edit</button>
                            <button data-product-id="<?= $product['id'] ?>" data-product-name="<?= htmlspecialchars($product['name']) ?>" popovertarget="assignment-dialog">Branches</button>
                            <form method="post" action="/actions/product" onsubmit="return confirm('Delete this material and its branch assignments?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                <button class="icon-button danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<div id="product-dialog" class="native-dialog" popover="manual">
    <form method="post" action="/actions/product">
        <div class="dialog-head">
            <div><p class="eyebrow">Material details</p>
                <h2 data-dialog-title>Add material</h2></div>
            <button type="button" class="close" popovertarget="product-dialog" popovertargetaction="hide">×</button>
        </div>
        <input type="hidden" name="action" value="create"><input type="hidden" name="id"><label>Material name<input
                    required name="name" placeholder="e.g. 12 AWG Copper Wire"></label><label>Category<select
                    name="category_id">
                <option value="">Uncategorized</option><?php foreach ($categories as $category): ?>
                    <option
                    value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option><?php endforeach ?>
            </select></label><label>Reorder threshold<input name="threshold" type="number" min="0"
                                                            value="0"></label><label class="check-row edit-only" hidden><input
                    name="is_active" type="checkbox" checked> Registry active</label>
        <div class="dialog-actions">
            <button type="button" class="button button-quiet" popovertarget="product-dialog" popovertargetaction="hide">
                Cancel
            </button>
            <button class="button button-dark">Save material</button>
        </div>
    </form>
</div>


<div id="assignment-dialog" class="native-dialog" popover="manual">
    <form method="post" action="/actions/assignment">
        <div class="dialog-head">
            <div><p class="eyebrow">Location settings</p>
                <h2>Assign a branch</h2></div>
            <button type="button" class="close" popovertarget="assignment-dialog" popovertargetaction="hide">×</button>
        </div>
        <input type="hidden" name="action" value="create"><input type="hidden" name="product_id">
        <p class="assignment-product"></p><label>Location<select name="branch_id" required>
                <option value="">Choose location</option><?php foreach ($branches as $branch): ?>
                    <option
                    value="<?= $branch['id'] ?>"><?= htmlspecialchars($branch['name']) ?></option><?php endforeach ?>
            </select></label>
        <div class="two-col"><label>Stock<input name="stock" type="number" min="0" value="0" required></label><label>Price
                (₱)<input name="price" type="number" min="0" step=".01" value="0" required></label></div>
        <div class="two-col"><label>Branch status<select name="branch_status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select></label><label>Availability<select name="availability">
                    <option value="available">Available</option>
                    <option value="not_available">Not available</option>
                </select></label></div>
        <div class="dialog-actions">
            <button type="button" class="button button-quiet" popovertarget="assignment-dialog"
                    popovertargetaction="hide">Cancel
            </button>
            <button class="button button-dark">Save location</button>
        </div>
    </form>
</div>

<script>
    const productDialog = document.querySelector('#product-dialog');

    function onUpdate()  {
        const p = JSON.parse(button.dataset.editProduct), form = productDialog.querySelector('form');
        form.action.value = 'update';
        form.id.value = p.id;
        form.name.value = p.name;
        form.category_id.value = p.category_id || '';
        form.threshold.value = p.threshold;
        form.is_active.checked = p.is_active === true || p.is_active === 't' || p.is_active === 1;
        productDialog.querySelector('[data-dialog-title]').textContent = 'Edit material';
        productDialog.querySelector('.edit-only').hidden = false;
    }

    document.querySelectorAll('[data-edit-product]')
        .forEach(button => button.addEventListener('click', onUpdate));

    function onSubmit(event) {
        if (!event.target.dataset.editProduct) {
            const form = productDialog.querySelector('form');
            form.reset();
            form.action.value = 'create';
            form.id.value = '';
            productDialog.querySelector('[data-dialog-title]').textContent = 'Add material';
            productDialog.querySelector('.edit-only').hidden = true;
        }
    }

    document.querySelector('[popovertarget="product-dialog"]')
        .addEventListener('click', onSubmit);

    function assignProduct() {
        const form = document.querySelector('#assignment-dialog form');
        form.reset();
        form.product_id.value = button.dataset.productId;
        document.querySelector('.assignment-product').textContent = button.dataset.productName;
    }

    document.querySelectorAll('[data-product-id]')
        .forEach(button => button.addEventListener('click', assignProduct));
</script>
</body>
</html>
