        <div class="content">
            <header class="my-account__header">
                <div class="grid my-account__header-inner">
                    <h1 class="my-acc__header-title">MY ACCOUNT</h1>
                    <p class="my-acc__header-desc">Chi tiết đơn hàng</p>
                </div>
            </header>

            <div class="my-acc__content grid">
                <div class="my-acc__content-inner">
                    <!-- dashboard -->
                    <?php require_once $DASHBOARD;?>
                    <!-- dashboard -->
                    
                    <div class="my-acc__content-item">
                        <div class="my-acc__content-item-inner order__detail">
                            <div class="order__detail-desc">
                                <span>
                                    Đơn hàng #<mark><?=$myCartInfo['id'];?></mark>
                                    đặt lúc <mark><?=date('d/m/Y H:i', strtotime($myCartInfo['created_at']));?></mark>
                                    
                                    hiện tại
                                    <mark>
                                    <?php
                                        switch($myCartInfo['status']) {
                                            case 0:
                                                echo 'Đang chờ xử lý';
                                                break;
                                            case 1:
                                                echo 'Đã xác nhận';
                                                break;
                                            case 2:
                                                echo 'Đang giao hàng';
                                                break;
                                            case 3:
                                                echo 'Đã giao hàng';
                                                break;
                                            case 4:
                                                echo 'Đã bị hủy';
                                        }
                                    ?>
                                    <mark>
                                </span>
                                <ul class="order__detail-action">
                                    <?php if ($myCartInfo['status'] != 3 && $myCartInfo['status'] != 4): ?>
                                    <li class="order__detail-action-item">
                                        <a onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này không?') ?
                                        window.location.href = '?cart_cancel&id=<?=$id;?>' : false;
                                        " class="order__detail-action-item-link">Hủy ĐH</a>
                                    </li>
                                    <?php endif; ?>

                                    <li class="order__detail-action-item btn-my-cart-log" data-order-id="<?=$myCartInfo['id'];?>">Lịch sử ĐH</li>
                                </ul>
                            </div>
                            <h2 class="order__detail-title">Chi tiết đơn hàng</h2>

                            <table class="my-acc__order-table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Sản phẩm</th>
                                        <th>Size</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $totalPrice = 0;
                                        foreach ($myCartDetail as $key => $item) {
                                            $totalPrice += $item['quantity'] * $item['price'];
                                    ?>
                                    <tr>
                                        <td><?=($key + 1);?></td>
                                        <td class="order__detail-product">
                                            <img src="<?=$IMG_URL . '/' . $item['product_image'];?>" alt="" class="order__detail-product-img">
                                            <a href="<?=$SITE_URL . '/product/?detail&id=' . $item['product_id'];?>" target="_blank" class="order__detail-product-name">
                                                <?=$item['product_name'];?>
                                            </a>
                                        </td>
                                        <td>
                                            <?=$item['product_size'];?>
                                        </td>
                                        <td>
                                            <?=number_format($item['price'], 0, '', ',');?> VNĐ
                                        </td>
                                        <td>
                                            <?=$item['quantity'];?>
                                        </td>
                                        <td class="order__detail-price">
                                            <?=number_format($item['price'] * $item['quantity'], 0, '', ',');?> VNĐ
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <h2 class="order__detail-title">Tổng thanh toán</h2>

                            <table class="my-acc__order-table order__detail-table-w-fixed">
                                <tbody>
                                    <tr>
                                        <td class="order__detail-text-bold">Tiền tạm tính:</td>
                                        <td class="order__detail-price"><?=number_format($totalPrice);?> VNĐ</td>
                                    </tr>

                                    <?php
                                        // tính tổng tiền được giảm khi áp vc
                                        $totalPriceVc = 0;
                                        $voucherData = '';
                                        foreach ($vouchers as $voucher) {
                                            if ($voucher) {
                                                $voucherInfo = voucher_select_by_id($voucher);
                                                $voucherData .= $voucherInfo['code'] . ' (';
                                                if ($voucherInfo['condition']) {
                                                    // nếu giảm theo tiền
                                                    $totalPriceVc += $voucherInfo['voucher_number'];
                                                    $voucherData .= 'Giảm ' . number_format($voucherInfo['voucher_number']) . ' VNĐ';
                                                } else {
                                                    $totalPriceVc += $totalPrice * $voucherInfo['voucher_number'] / 100;
                                                    $voucherData .= 'Giảm ' . $voucherInfo['voucher_number'] . '%';
                                                }
                                                $voucherData .= '), ';
                                            }
                                        }
                                    ?>

                                    <!-- nếu áp voucher -->
                                    <?php if ($voucherData): ?>
                                    <tr>
                                        <td class="order__detail-text-bold">Voucher đã sử dụng:</td>
                                        <td><?=substr($voucherData, 0, -2);?></td>
                                    </tr>

                                    <tr>
                                        <td class="order__detail-text-bold">Tổng giảm:</td>
                                        <td class="order__detail-price"><?=number_format($totalPriceVc);?> VNĐ</td>
                                    </tr>
                                    <?php endif; ?>

                                    <tr>
                                        <td class="order__detail-text-bold">Tổng tiền:</td>
                                        <td class="order__detail-price"><?=number_format($myCartInfo['total_price']);?> VNĐ</td>
                                    </tr>
                                    
                                </tbody>
                            </table>

                            <h2 class="order__detail-title">Thông tin vận chuyển</h2>

                            <table class="my-acc__order-table order__detail-table-w-fixed">
                                <tbody>
                                    <tr>
                                        <td class="order__detail-text-bold">Họ và tên:</td>
                                        <td><?=$myCartInfo['customer_name'];?></td>
                                    </tr>

                                    <tr>
                                        <td class="order__detail-text-bold">Địa chỉ:</td>
                                        <td><?=$myCartInfo['address'];?></td>
                                    </tr>

                                    <tr>
                                        <td class="order__detail-text-bold">Số điện thoại:</td>
                                        <td><?=$myCartInfo['phone'];?></td>
                                    </tr>

                                    <tr>
                                        <td class="order__detail-text-bold">Email:</td>
                                        <td><?=$myCartInfo['email'];?></td>
                                    </tr>

                                    <tr>
                                        <td class="order__detail-text-bold">Thời gian đặt:</td>
                                        <td><?=date_format(date_create($myCartInfo['created_at']), 'd/m/Y H:i')?></td>
                                    </tr>

                                    <tr>
                                        <td class="order__detail-text-bold">Ghi chú:</td>
                                        <td><?=nl2br($myCartInfo['message']);?></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- lịch sử đặt hàng -->
            <div class="logs__wrapper">
                <div class="logs__overlay"></div>

                <div class="logs__inner">
                    <div class="logs__inner-header">
                        <h2 class="logs__inner-header-title">
                            <div class="logs__inner-header-title-icon">
                                <i class="fas fa-sync"></i>
                            </div>
                            Chi tiết đơn hàng
                        </h2>

                        <div class="logs__inner-header-icon">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>

                    <div class="logs__inner-body">
                                
                    </div>

                    <div class="logs__inner-footer">
                        <button class="logs__inner-footer-close">Close</button>
                    </div>
                </div>
            </div>
        </div>