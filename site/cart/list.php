        <!-- CONTENT -->
        <div class="content">
            <div class="grid">
                <?php
                    if (!$_SESSION['cart']) {
                        echo '<div class="alert alert-success">Chưa có sản phẩm nào trong giỏ hàng</div>';
                    }
                ?>

                
                <section class="content__cart">
                    <?php if($_SESSION['cart']): ?>
                    <div class="content__cart-item content__cart-detail">
                        <table class="content__cart-detail-table">
                            <thead>
                                <tr>
                                    <th colspan="3">Sản phẩm</th>
                                    <th>Size</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tạm tính</th>
                                </tr>
                            </thead>
    
                            <tbody>
                            <?php
                                $totalPrice = 0;
                                foreach ($_SESSION['cart'] as $key => $item):
                                    $totalPrice += $item['price'] * $item['quantity'];
                            ?>
                                <tr data-id="<?=$item['id'];?>">
                                    <td>
                                        <a onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?') ?
                                        window.location.href = '?btn_delete&id_cart=<?=$item['id_cart'];?>' : false;
                                        " class="content__cart-detail-table-btn">
                                            <i class="far fa-times-circle"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?=$SITE_URL . '/product/?detail&id=' . $item['id'];?>" class="content__cart-detail-table-link">
                                            <img src="<?=$IMG_URL . '/' . $item['product_image'];?>" alt="" class="content__cart-detail-table-img">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?=$SITE_URL . '/product/?detail&id=' . $item['id'];?>" class="content__cart-detail-table-link">
                                            <?=$item['product_name'];?>
                                        </a>
                                    </td>
                                    <td class="content__cart-detail-size">
                                        <?=$item['size'];?>
                                    </td>
                                    <td class="content__cart-detail-price">
                                        <span class="">
                                            <?=number_format($item['price'], 0, '', ',');?>đ
                                        </span>
                                    </td>
                                    <td>
                                        <form action="" class="content__cart-detail-table-qnt">
                                            <!-- <button type="button" onclick="quantity.value = Number(quantity.value) - 1" class="content__cart-detail-table-qnt-btn content__cart-detail-table-qnt-btn--minus">-</button>
                                            <input type="number" min="0" name="quantity" class="content__cart-detail-table-qnt-control" value="<?=$item['quantity'];?>">
                                            <button type="button" onclick="quantity.value = Number(quantity.value) + 1" class="content__cart-detail-table-qnt-btn content__cart-detail-table-qnt-btn--plus">+</button> -->

                                            <button type="button" onclick="updateQuantity(event, 'minus')" class="content__cart-detail-table-qnt-btn content__cart-detail-table-qnt-btn--minus">-</button>
                                            <input type="number" min="0" name="quantity" class="content__cart-detail-table-qnt-control" value="<?=$item['quantity'];?>">
                                            <button type="button" onclick="updateQuantity(event, 'plus')" class="content__cart-detail-table-qnt-btn content__cart-detail-table-qnt-btn--plus">+</button>
                                        </form>
                                    </td>
                                    <td>
                                        <span class="content__cart-detail-price-total">
                                            <?=number_format(($item['price'] * $item['quantity']), 0, '', ',')?>đ
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
    
                        <ul class="content__cart-detail-action-list">
                            <li class="content__cart-detail-action">
                                <a href="<?=$SITE_URL;?>/product" class="content__cart-detail-action-link">
                                    <div class="content__cart-detail-action-link-icon">
                                        <i class="fas fa-long-arrow-alt-left"></i>
                                    </div>
                                    Tiếp tục xem sản phẩm
                                </a>
                            </li>
                            <li class="content__cart-detail-action">
                                <a href="" class="content__cart-detail-action-link content__cart-detail-action-link-update">
                                    Cập nhật giỏ hàng
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="content__cart-item content__cart-checkout">
                        <table class="content__cart-checkout-table">
                            <thead>
                                <tr>
                                    <th colspan="2">Cộng giỏ hàng</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                <tr>
                                    <td>Tạm tính</td>
                                    <td class="content__cart-checkout-table-price"><?=number_format($totalPrice);?>đ</td>
                                </tr>
                            <?php $totalPriceVoucher = 0; ?>
                            <?php foreach($_SESSION['voucher'] as $voucher): ?>
                                <?php
                                    // nếu giảm theo tiền
                                    if($voucher['condition']) {
                                        $totalPriceVoucher += $voucher['voucher_number'];
                                    } else {
                                        // giảm theo % tổng đơn
                                        $totalPriceVoucher += ($totalPrice * $voucher['voucher_number'])/100;
                                    }
                                ?>

                                <tr>
                                    <td>
                                        Voucher <strong><?=$voucher['code'];?></strong>
                                        <a class="content__cart-checkout-table-delete" onclick="return confirm('Bạn có chắc muốn xóa Voucher này không?') ?
                                        window.location.href = '?delete_voucher&id=<?=$voucher['id'];?>' : false;
                                        ">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                    <?php if($voucher['condition']): ?>
                                        <td class="content__cart-checkout-table-price">- <?=number_format($voucher['voucher_number']);?> VNĐ</td>
                                    <?php else: ?>
                                        <td class="content__cart-checkout-table-price">- <?=$voucher['voucher_number'];?>%</td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td>Tổng</td>
                                    <td>
                                        <?php 
                                            $newPrice = $totalPrice - $totalPriceVoucher;
                                            $newPrice = $newPrice > 0 ? $newPrice : 0;
                                        ?>
                                        <span class="content__cart-checkout-total-price"><?=number_format($newPrice, 0, '', ',');?>đ</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
    
                        <a href="<?=$SITE_URL;?>/cart/?checkout" class="content__cart-checkout-btn">Tiến hành thanh toán</a>

                        <form action="" class="content__cart-checkout-voucher" onsubmit="return false;">
                            <div class="content__cart-checkout-voucher-title">
                                <div class="content__cart-checkout-voucher-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                                Mã giảm giá
                            </div>
                            <input type="text" class="content__cart-checkout-voucher-fom-control input" placeholder="Mã giảm giá">
                            <button class="content__cart-checkout-voucher-btn">Áp dụng</button>
                        </form>
                    </div>
                    <?php endif; ?>
                </section>
            </div>
        </div>
        <!-- END CONTENT -->