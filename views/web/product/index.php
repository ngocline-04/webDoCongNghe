<?php require_once ('views/web/layouts/index.php') ?>
<?php require_once ('core/Unit.php') ?>

<?php startblock('title') ?>
<?=$data['name']?>
<?php endblock() ?>

<?php startblock('css') ?>
<link href="<?=asset('assets/web/css/product_page.css') ?>" rel="stylesheet">
<style>
.description {
    text-align: center;
    width: 100%
}
</style>
<?php endblock() ?>


<?php startblock('content') ?>
<main>
    <?php if ( $data['amount'] > 0) :?>
    <?php if( $data['date_discount'] > date("Y-m-d h:i:s") && $data['discount'] ) : ?>
    <div class="container margin_30">
        <div class="countdown_inner">-<?=$data['discount']?>% Giảm giá còn -<div
                data-countdown="<?=$data['date_discount']?>" class="countdown">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="all">
                    <div class="slider">
                        <div class="owl-carousel owl-theme main">
                            <div style="background-image: url(<?=asset('storage/thumbnail/'.$data['thumbnail'])?>);"
                                class="item-box"></div>
                            <?php
                        preg_match_all('@src="([^"]+)"@', $data['images'] , $match_img);
                        $srcImg = array_pop($match_img);
                        // print_r($srcImg);
                        foreach($srcImg as $key => $image) : ?>
                            <div style="background-image: url(<?=$image?>);" class="item-box"></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="left nonl"><i class="ti-angle-left"></i></div>
                        <div class="right"><i class="ti-angle-right"></i></div>
                    </div>
                    <div class="slider-two">
                        <div class="owl-carousel owl-theme thumbs">
                            <?php
                        preg_match_all('@src="([^"]+)"@', $data['images'] , $match_img);
                        $srcImg = array_pop($match_img);
                        // print_r($srcImg);
                        foreach($srcImg as $key => $image) : ?>
                            <div style="background-image: url(<?=$image?>);" class="item"></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="left-t nonl-t"></div>
                        <div class="right-t"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Danh mục sản phẩm</a></li>
                        <li><?=$data['name']?></li>
                    </ul>
                </div>
                <!-- /page_header -->
                <div class="prod_info">
                    <h1><?=$data['name']?></h1>
                    <span class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i
                            class="icon-star voted"></i><i class="icon-star voted"></i><i
                            class="icon-star"></i><em></em></span>
                    <p><?=$data['name']?></p>
                    <div class="prod_options">


                        <div class="row">
                            <label class="col-xl-5 col-lg-5  col-md-6 col-6"><strong></strong></label>
                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-6">


                            <div class="price_main"><span
                                    class="new_price"><?=Unit::format_VND(Unit::total($data))?></span><span
                                    class="percentage">-<?=$data['discount']?>%</span> <span
                                    class="old_price"><?=Unit::format_VND($data['price'])?></span></div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="btn"><a href="javascript:void(0)" data-product="<?=$data['id']?>"
                                    data-user="<?=Auth::handleUser(Auth::getUser('User'))?>"
                                    class="btn_1 add_to_cart">Thêm vào giỏ</a></div>
                        </div>
                    </div>
                </div>
                <!-- /prod_info -->
                <div class="product_actions">
                    <ul>
                        <!-- <li>
                            <a href="#"><i class="ti-heart"></i><span>Yêu thích</span></a>
                        </li> -->
                        <!-- <li>
                            <a href="#"><i class="ti-control-shuffle"></i><span>So sánh</span></a>
                        </li> -->
                    </ul>
                </div>
                <!-- /product_actions -->
                <!-- <div class="table-responsive">
                    <h3>Specifications</h3>

                    <table class="table table-sm table-striped" width=40%>
                        <tbody>
                            <tr>
                                <td><strong>Color</strong></td>
                                <td>Blue, Purple</td>
                            </tr>
                            <tr>
                                <td><strong>Size</strong></td>
                                <td>150x100x100</td>
                            </tr>
                            <tr>
                                <td><strong>Weight</strong></td>
                                <td>0.6kg</td>
                            </tr>
                            <tr>
                                <td><strong>Manifacturer</strong></td>
                                <td>Manifacturer</td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
            </div>
        </div>
        <!-- /row -->
    </div>
    <?php else : ?>
    <div class="container margin_30">
        <div class="row">
            <div class="col-md-6">
                <div class="all">
                    <div class="slider">
                        <div class="owl-carousel owl-theme main">
                            <div style="background-image: url(<?=asset('storage/thumbnail/'.$data['thumbnail'])?>);"
                                class="item-box"></div>
                            <?php
                        preg_match_all('@src="([^"]+)"@', $data['images'] , $match_img);
                        $srcImg = array_pop($match_img);
                        // print_r($srcImg);
                        foreach($srcImg as $key => $image) : ?>
                            <div style="background-image: url(<?=$image?>);" class="item-box"></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="left nonl"><i class="ti-angle-left"></i></div>
                        <div class="right"><i class="ti-angle-right"></i></div>
                    </div>
                    <div class="slider-two">
                        <div class="owl-carousel owl-theme thumbs">
                            <?php
                        preg_match_all('@src="([^"]+)"@', $data['images'] , $match_img);
                        $srcImg = array_pop($match_img);
                        // print_r($srcImg);
                        foreach($srcImg as $key => $image) : ?>
                            <div style="background-image: url(<?=$image?>);" class="item"></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="left-t nonl-t"></div>
                        <div class="right-t"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Danh mục sản phẩm</a></li>
                        <li><?=$data['name']?></li>
                    </ul>
                </div>
                <!-- /page_header -->
                <div class="prod_info">
                    <h1><?=$data['name']?></h1>

                    <?php
                        $avg   = (float)($data['rating_avg'] ?? 0);
                        $count = (int)($data['rating_count'] ?? 0);
                        $stars = ceil($avg);
                        echo "<script>console.log(" . json_encode($data) . ");</script>";

                    ?>
                    <span class="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= $stars): ?>
                                <i class="icon-star voted"></i>
                            <?php else: ?>
                                <i class="icon-star"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <em>(<?=$count?> đánh giá)</em>
                    </span>
                    <p><?=$data['name']?></p>
                    <div class="prod_options">
                        <div class="row">
                            <label class="col-xl-5 col-lg-5  col-md-6 col-6"><strong></strong></label>
                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-6">


                            <div class="price_main"><span
                                    class="new_price"><?=Unit::format_VND(Unit::total($data))?></span></div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="btn"><a href="javascript:void(0)" data-product="<?=$data['pro_id']?>"
                                    data-user="<?=Auth::handleUser(Auth::getUser('User'))?>"
                                    class="btn_1 add_to_cart">Thêm vào giỏ</a></div>
                        </div>
                    </div>
                </div>
                <!-- /prod_info -->
                <div class="product_actions">
                    <ul>
                        <!-- <li>
                            <a href="#"><i class="ti-heart"></i><span>Yêu thích</span></a>
                        </li> -->
                        <!-- <li>
                            <a href="#"><i class="ti-control-shuffle"></i><span>So sánh</span></a>
                        </li> -->
                    </ul>
                </div>
                <!-- /product_actions -->
                <!-- <div class="table-responsive">
                    <h3>Specifications</h3>

                    <table class="table table-sm table-striped" width=40%>
                        <tbody>
                            <tr>
                                <td><strong>Color</strong></td>
                                <td>Blue, Purple</td>
                            </tr>
                            <tr>
                                <td><strong>Size</strong></td>
                                <td>150x100x100</td>
                            </tr>
                            <tr>
                                <td><strong>Weight</strong></td>
                                <td>0.6kg</td>
                            </tr>
                            <tr>
                                <td><strong>Manifacturer</strong></td>
                                <td>Manifacturer</td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
            </div>
        </div>
        <!-- /row -->
    </div>
    <?php endif; ?>
    <?php else : ?>
    <div class="container margin_30">
        <div class="row">
            <div class="col-md-6">
                <div class="all">
                    <div class="slider">
                        <div class="owl-carousel owl-theme main">
                            <div style="background-image: url(<?=asset('storage/thumbnail/'.$data['thumbnail'])?>);"
                                class="item-box"></div>
                            <?php
                        preg_match_all('@src="([^"]+)"@', $data['images'] , $match_img);
                        $srcImg = array_pop($match_img);
                        // print_r($srcImg);
                        foreach($srcImg as $key => $image) : ?>
                            <div style="background-image: url(<?=$image?>);" class="item-box"></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="left nonl"><i class="ti-angle-left"></i></div>
                        <div class="right"><i class="ti-angle-right"></i></div>
                    </div>
                    <div class="slider-two">
                        <div class="owl-carousel owl-theme thumbs">
                            <?php
                        preg_match_all('@src="([^"]+)"@', $data['images'] , $match_img);
                        $srcImg = array_pop($match_img);
                        // print_r($srcImg);
                        foreach($srcImg as $key => $image) : ?>
                            <div style="background-image: url(<?=$image?>);" class="item"></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="left-t nonl-t"></div>
                        <div class="right-t"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Danh mục sản phẩm</a></li>
                        <li><?=$data['name']?></li>
                    </ul>
                </div>
                <!-- /page_header -->
                <div class="prod_info">
                    <h1><?=$data['name']?></h1>
                    <div style="color : red ;font-weight: bold;">Hết hàng</div>
                    <p><?=$data['name']?></p>
                    <div class="prod_options">


                        <div class="row">
                            <label class="col-xl-5 col-lg-5  col-md-6 col-6"><strong></strong></label>
                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-6">

                            <div class="price_main"><span
                                    class="new_price"><?=Unit::format_VND(Unit::total($data))?></span></div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="btn"><a href="javascript:void(0)" class="btn_1">Đặt hàng</a></div>
                        </div>
                    </div>
                </div>
                <!-- /prod_info -->
                <div class="product_actions">
                    <ul>
                        <!-- <li>
                            <a href="#"><i class="ti-heart"></i><span>Yêu thích</span></a>
                        </li> -->
                        <!-- <li>
                            <a href="#"><i class="ti-control-shuffle"></i><span>So sánh</span></a>
                        </li> -->
                    </ul>
                </div>
                <!-- /product_actions -->
                <!-- <div class="table-responsive">
                    <h3>Specifications</h3>

                    <table class="table table-sm table-striped" width=40%>
                        <tbody>
                            <tr>
                                <td><strong>Color</strong></td>
                                <td>Blue, Purple</td>
                            </tr>
                            <tr>
                                <td><strong>Size</strong></td>
                                <td>150x100x100</td>
                            </tr>
                            <tr>
                                <td><strong>Weight</strong></td>
                                <td>0.6kg</td>
                            </tr>
                            <tr>
                                <td><strong>Manifacturer</strong></td>
                                <td>Manifacturer</td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
            </div>
        </div>
        <!-- /row -->
    </div>
    <?php endif; ?>
    <!-- /container -->

    <div class="tabs_product">
        <div class="container">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a id="tab-A" href="#pane-A" class="nav-link active" data-toggle="tab" role="tab">Giới thiệu</a>
                </li>
                <li class="nav-item">
                    <a id="tab-B" href="#pane-B" class="nav-link" data-toggle="tab" role="tab">Đánh giá</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /tabs_product -->
    <div class="tab_content_wrapper">
        <div class="container">
            <div class="tab-content" role="tablist">
                <div id="pane-A" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-A">
                    <div class="card-header" role="tab" id="heading-A">
                        <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" href="#collapse-A" aria-expanded="false"
                                aria-controls="collapse-A">
                                Giới thiệu
                            </a>
                        </h5>
                    </div>
                    <div id="collapse-A" class="collapse" role="tabpanel" aria-labelledby="heading-A">
                        <div class="description" width=100%>
                            <?=$data['description']?>
                        </div>
                    </div>
                </div>
                <!-- /TAB A -->
                <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                    <div class="card-header" role="tab" id="heading-B">
                        <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" href="#collapse-B" aria-expanded="false"
                                aria-controls="collapse-B">
                                Đánh giá
                            </a>
                        </h5>
                    </div>
                    <div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
                       <?php if(Auth::getUser('user')): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <form id="reviewForm">
                                    <style>
                                        #reviewForm .star-rating {
                                            direction: rtl;
                                            display: inline-flex;
                                            font-size: 30px;
                                        }

                                        #reviewForm .star-rating input {
                                            display: none;
                                        }

                                        #reviewForm .star-rating label {
                                            color: #ddd;
                                            cursor: pointer;
                                            padding: 0 2px;
                                        }

                                        #reviewForm .star-rating input:checked ~ label,
                                        #reviewForm .star-rating label:hover,
                                        #reviewForm .star-rating label:hover ~ label {
                                            color: #ffc107;
                                        }
                                        </style>
                                    <input type="hidden" name="product_id" value="<?=$_GET['id']?>">
                                    <div class="form-group mb-2">
                                        <h1>Đánh giá</h1>
                                        <div class="star-rating">
                                            <?php for($i=5; $i>=1; $i--): ?>
                                                <input type="radio" id="star<?=$i?>" name="rating" value="<?=$i?>">
                                                <label for="star<?=$i?>">★</label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <h1>Nội dung</h1>
                                        <textarea 
                                            name="content" 
                                            class="form-control" 
                                            rows="3" 
                                            placeholder="Nhận xét của bạn..." 
                                            required
                                        ></textarea>
                                    </div>

                                    <div class="btn">
                                        <button type="submit" class="btn_1">Đánh giá</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <?php else: ?>
                        <p class="text-danger">Vui lòng đăng nhập để đánh giá</p>
                        <?php endif; ?>

                    
                        <div id="reviewList">
                        <?php if(empty($review_list)): ?>
                                <p class="text-muted">Chưa có đánh giá nào.</p>
                            <?php endif; ?>

                            <?php foreach($review_list as $item): ?>
                            <div class="media mb-3">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">
                                        <?=$item['fullname']?>
                                        <span class="text-warning ml-2">
                                            <?=str_repeat('★', $item['rating'])?>
                                            <?=str_repeat('☆', 5 - $item['rating'])?>
                                        </span>
                                    </h6>

                                    <div><?=$item['content']?></div>

                                    <small class="text-muted">
                                        <?=date('d/m/Y H:i', strtotime($item['created_at']))?>
                                    </small>
                                </div>
                            </div>
                            <hr>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
                <!-- /tab B -->
            </div>
            <!-- /tab-content -->
        </div>
        <!-- /container -->
    </div>
    <!-- /tab_content_wrapper -->


    <!-- /container -->

    <div class="feat">
        <div class="container">
            <ul>
                <li>
                    <div class="box">
                        <i class="ti-gift"></i>
                        <div class="justify-content-center">
                            <h3>Miễn phí giao hàng</h3>
                            <p>Với mọi đơn hàng</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="box">
                        <i class="ti-wallet"></i>
                        <div class="justify-content-center">
                            <h3>Thanh toán Online</h3>
                            <p>Thanh toán an toàn 100%</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="box">
                        <i class="ti-headphone-alt"></i>
                        <div class="justify-content-center">
                            <h3>Hỗ trợ 24/7</h3>
                            <p>Hỗ trợ trực tuyến hàng đầu</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!--/feat-->

</main>
<?php endblock() ?>

<?php startblock('js') ?>
<script src="<?=asset('assets/web/js/carousel_with_thumbs.js')?>"></script>
<script>
$(document).on('submit', '#reviewForm', function (e) {
    e.preventDefault();

    const form = $(this);
    const rating = form.find('input[name="rating"]:checked').val();
    const content = form.find('textarea[name="content"]').val().trim();
    const product_id = form.find('input[name="product_id"]').val();

    if (!rating) {
        Swal.fire({
            icon: 'warning',
            title: 'Bạn chưa chọn số sao'
        });
        return;
    }

    if (!content) {
        Swal.fire({
            icon: 'warning',
            title: 'Bạn chưa nhập nội dung'
        });
        return;
    }

    $.ajax({
        url: '<?=url("review/store")?>',
        method: 'POST',
        dataType: 'json', // ⚠️ QUAN TRỌNG
        data: {
            product_id,
            rating,
            content
        },
        success: function (res) {
            if (res.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Đánh giá thành công',
                    timer: 1500,
                    showConfirmButton: false
                });

                let stars =
                '★'.repeat(res.review.rating) +
                '☆'.repeat(5 - res.review.rating);

                let html = `
                    <div class="media mb-3">
                        <div class="media-body">
                            <h6 class="mt-0 mb-1">
                                ${res.review.fullname}
                                <span class="text-warning ml-2">
                                    ${stars}
                                </span>
                            </h6>

                            <div>${res.review.content}</div>

                            <small class="text-muted">
                                ${new Date(res.review.created_at).toLocaleString('vi-VN')}
                            </small>
                        </div>
                    </div>
                    <hr>
                `;

                // xoá text "Chưa có đánh giá nào"
                $('#reviewList .text-muted').remove();

                // chèn lên đầu danh sách
                $('#reviewList').prepend(html);
                // reset form
                form[0].reset();

             

                $('#ratingBox').load(location.href + ' #ratingBox>*');

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra',
                    text: res ?? 'Không rõ lỗi'

                });
            }
        },
        error: function (xhr, status, error) {
        console.log('❌ AJAX ERROR');
        console.log('Status:', status);
        console.log('Error:', error);
        console.log('ResponseText:', xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Không thể gửi đánh giá',
        });
        }
    });
});


</script>

<?php endblock() ?>