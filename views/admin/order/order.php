<?php if (!empty($data['orders'])) : ?>
    <?php foreach ($data['orders'] as $order) : ?>
        <tr>
            <td>#<?= $order['orders_id'] ?></td>
            <td><?= $order['name_order'] ?></td>
            <td><?= Unit::format_VND($order['price_order']) ?></td>
            <td><?= $order['phone_order'] ?></td>
            <td><?= CheckOrder::statusOrder($order['status_order']) ?></td>
            <td>
                <?php
                if ($order['payment_order'] == '2') {
                    echo CheckOrder::payment($order['payment_order']);
                } else {
                    echo CheckOrder::statusPayment($order['status_payment']);
                }
                ?>
            </td>
            <td><?= $order['date_order'] ?></td>
        </tr>
    <?php endforeach; ?>
<?php else : ?>
    <tr>
        <td colspan="7" class="text-center text-muted">
            Không tìm thấy đơn hàng
        </td>
    </tr>
<?php endif; ?>
