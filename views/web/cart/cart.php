<?php if(count($data) > 0) :?>
    <div class="container margin_30">
        <div class="page_header">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <!-- <li><a href="#"></a></li> -->
                    <li>Giỏ hàng</li>
                </ul>
            </div>
            <h1>Giỏ Hàng</h1>
        </div>
        <!-- /page_header -->
        <table class="table table-striped cart-list">
            <thead>
        <tr>
        <th style="width:3%">
            <input type="checkbox" id="checkAll" checked>
        </th>
        <th style="width : 45%">Sản phẩm</th>

                    <th style="width : 10%">
                        Giá gốc
                    </th>
                    <th style="width : 10%">
                        Giá tiền
                    </th>
                    <th style="width : 20%">
                        Số lượng
                    </th>
                    <th style="width : 10%">
                        Tổng
                    <th style="width : 2%">

                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $key => $cart) :?>
<tr>
    <td>
       <input 
    type="checkbox"
    class="cart-check"
    data-id="<?=$cart['id']?>"
    data-price="<?=$cart['price']?>"
    data-qty="<?=$cart['quantity']?>"
    checked
>

    </td>

                    <td>
                        <div class="thumb_cart">
                            <img src="<?php echo asset('storage/thumbnail/'.$cart['thumbnail']); ?>"
                                data-src="<?php echo asset('storage/thumbnail/'.$cart['thumbnail']); ?>" class="lazy"
                                alt="Image">
                        </div>
                        <span class="item_cart"><?=$cart['name'] ?></span>
                    </td>
                    <td>
                        <span class='old_price'><?php echo Unit::format_VND($cart['price']) ?></span>
                    </td>
                    <td>
                        <span><?php echo Unit::format_VND(Unit::total_quantity($cart)) ?></span>
                    </td>

                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <input type="hidden" id="id_<?=$key?>" value="<?=$cart['id']?>" class="form-control">
                            <button type="button" data="<?=$key?>" id="discount"
                                class="btn btn-primary discount">-</button>
                            <input type="number" data="<?=$key?>" id="quantity_<?=$key?>" class="form-control change"
                                min="1" max="100" value="<?=$cart['quantity']?>">
                            <button type="button" data="<?=$key?>" id="increase"
                                class="btn btn-primary increase">+</button>
                        </div>
                    </td>
                    <td>
                        <strong><?php echo Unit::format_VND(Unit::total_quantity($cart)) ?></strong>
                    </td>
                    <td class="options">
                        <a href="javascript:void(0);" data-cart-id="<?=$cart['id']?>" class="delete_cart"><i class="ti-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="row add_top_30 flex-sm-row-reverse cart_actions">
            <div class="col-sm-4 text-right">
            </div>
            <div class="col-sm-8">
                <div class="apply-coupon">
                    <div class="form-group form-inline">
                        <input type="text" name="coupon-code" value="" placeholder="không có mã !"
                            class="form-control"><button type="button" class="btn_1 outline">Mã giảm giá</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /cart_actions -->

    </div>
    <!-- /container -->

    <div class="box_cart">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <ul>
   <li style="display:flex; justify-content:space-between;">
    <span>Tổng tiền hàng</span>
    <span id="totalPrice">0đ</span>
</li>

    <li>
        <span>Phí vận chuyển</span>0đ
    </li>
   <li style="display:flex; justify-content:space-between;">
    <span>Tổng Thanh toán</span>
    <span id="finalPrice">0đ</span>
</li>

</ul>

                    <a href="<?php if (!Auth::getUser('user')) { echo url('auth/login'); } else { echo url('order'); }?>" class="btn_1 full-width cart">Thanh toán ngay</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /box_cart -->
<?php else : ?>
	<div class="container margin_30">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<div id="confirm">
					<div class="icon icon--order-success svg add_bottom_15">
						<img src="<?=asset('assets/web/customs/shopping-cart.png')?>" width="200px" height="200px">
					</div>
				<!-- <h2>Không có sản phẩm nào trong giỏ hàng của bạn</h2> -->
				<p>Không có sản phẩm nào trong giỏ hàng của bạn</p>
				<a href="<?=url('homepage')?>" class="btn btn-warning" >Tiếp tục mua sắm</a>
				</div>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->


    <?php endif; ?>
<script>
function formatVND(number) {
    return number.toLocaleString('vi-VN') + 'đ';
}

function calcTotal() {
    let total = 0;

    document.querySelectorAll('.cart-check:checked').forEach(cb => {
        const price = Number(cb.dataset.price);
        const qty   = Number(cb.dataset.qty);
        total += price * qty;
    });

    document.getElementById('totalPrice').innerText = formatVND(total);
    document.getElementById('finalPrice').innerText = formatVND(total);
}

document.querySelectorAll('.cart-check').forEach(cb => {
    cb.addEventListener('change', calcTotal);
});

const checkAll = document.getElementById('checkAll');
if (checkAll) {
    checkAll.addEventListener('change', function () {
        document.querySelectorAll('.cart-check').forEach(cb => {
            cb.checked = this.checked;
        });
        calcTotal();
    });
}

calcTotal();
</script>

