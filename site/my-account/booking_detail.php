        <div class="content">
            <header class="my-account__header">
                <div class="grid my-account__header-inner">
                    <h1 class="my-acc__header-title">MY ACCOUNT</h1>
                    <p class="my-acc__header-desc">Lịch sử đặt bàn</p>
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
                                    Đơn đặt bàn #<mark><?=$bookingInfo['id'];?></mark>
                                    lúc <mark><?=date('d/m/Y', strtotime($bookingInfo['date_book'])) . ' ' . date('H:i', strtotime($bookingInfo['time_book']))?></mark>
                                    
                                    hiện tại
                                    <mark>
                                    <?php
                                        if ($bookingInfo['status'] == 0) {
                                            echo 'Đang chờ xử lý';
                                        } else if ($bookingInfo['status'] == 1) {
                                            echo 'Đã xác nhận';
                                        }  else if ($bookingInfo['status'] == 3) {
                                            echo 'Đã hoàn thành';
                                        } else {
                                            echo 'Đã bị hủy';
                                        }
                                    ?>
                                    <mark>
                                </span>
                                <ul class="order__detail-action">
                                    <!-- 0 - chờ xử lý, 1 - đã xác nhận, 2 - đã hủy, 3 - đã hoàn thành -->
                                    <!-- nếu đang ở trạng thái hủy thì k hiện -->
                                    <?php if($bookingInfo['status'] != 2 && $bookingInfo['status'] != 3): ?>
                                    <li class="order__detail-action-item">
                                        <a onclick="return confirm('Bạn có chắc muốn hủy đặt bàn này không?') ?
                                        window.location.href = '?booking_cancel&status=2&id=<?=$id;?>' : false;
                                        " class="order__detail-action-item-link">Hủy đặt bàn</a>
                                    </li>
                                    <?php endif; ?>

                                </ul>
                            </div>

                            <h2 class="order__detail-title">Thông tin đặt bàn</h2>

                            <table class="my-acc__order-table order__detail-table-w-fixed">
                                <tbody>
                                    <tr>
                                        <td class="order__detail-text-bold">Bàn đã đặt:</td>
                                        <td><?=$bookingInfo['table_name'];?> (<?=$bookingInfo['guest_number'];?> người)</td>
                                    </tr>

                                    <tr>
                                        <td class="order__detail-text-bold">Họ và tên:</td>
                                        <td><?=$bookingInfo['name'];?></td>
                                    </tr>

                                    <tr>
                                        <td class="order__detail-text-bold">Số điện thoại:</td>
                                        <td><?=$bookingInfo['phone'];?></td>
                                    </tr>

                                    <tr>
                                        <td class="order__detail-text-bold">Email:</td>
                                        <td><?=$bookingInfo['email'];?></td>
                                    </tr>

                                    <tr>
                                        <td class="order__detail-text-bold">Thời gian đến:</td>
                                        <td><?=date('d/m/Y', strtotime($bookingInfo['date_book'])) . ' ' . date('H:i', strtotime($bookingInfo['time_book']))?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>