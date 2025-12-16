<?php if (!empty($products)) : ?>
    <?php foreach ($products as $product) : ?>
        <tr>
            <td><?= $product['product_name'] ?></td>
            <td><?= Unit::format_VND($product['price']) ?></td>
            <td>
                <img src="<?= asset('storage/thumbnail/' . $product['thumbnail']) ?>" width="80">
            </td>
            <td><?= $product['amount'] ?></td>
            <td></td>
        </tr>
    <?php endforeach; ?>
<?php else : ?>
    <tr>
        <td colspan="5" class="text-center text-muted">
            Không tìm thấy sản phẩm
        </td>
    </tr>
<?php endif; ?>
