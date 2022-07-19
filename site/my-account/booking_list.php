        <div class="content">
            <header class="my-account__header">
                <div class="grid my-account__header-inner">
                    <h1 class="my-acc__header-title">MY ACCOUNT</h1>
                    <p class="my-acc__header-desc">Lịch sử đặt hàng</p>
                </div>
            </header>

            <div class="my-acc__content grid">
                <div class="my-acc__content-inner">
                    <!-- dashboard -->
                    <?php require_once $DASHBOARD;?>
                    <!-- dashboard -->

                    <div class="my-acc__content-item">
                        <div class="my-acc__content-item-inner my-acc__order">
                            <!-- nếu không có đơn đặt bàn nào -->
                            <?php
                                if (empty($bookingList)) {
                                    echo '<div class="alert alert-success my-acc__order-msg">Chưa có lượt đặt bàn</div>';
                                }
                            ?>

                            <!-- nếu có -->
                            <?php if (!empty($bookingList)): ?>

                            <form action="" class="my-acc__order-filter">
                                <input type="text" class="my-acc__order-form-control input form__control-my-booking" name="keyword" placeholder="Nhập tên KH hoặc mã đặt hàng">
                            </form>

                            <table class="my-acc__order-table">
                                <thead>
                                    <tr>
                                        <th>Mã đặt bàn</th>
                                        <th>Tên khách hàng</th>
                                        <th>Thời gian đặt</th>
                                        <th>Bàn đã đặt</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($bookingList as $item): ?>
                                    <tr>
                                        <td>#<?=$item['id'];?></td>
                                        <td><?=$item['name'];?></td>
                                        <td><?=date_format(date_create($item['date_book']), 'd/m/Y H:i');?></td>
                                        <td>
                                            <?=$item['table_name'];?>
                                        </td>
                                        <td>
                                            <?php
                                                switch($item['status']) {
                                                    case 0:
                                                        echo '<span class="my-acc__order-table--active">Chờ xử lý</span>';
                                                        break;
                                                    case 1:
                                                        echo '<span class="my-acc__order-table--active">Đã xác nhận</span>';
                                                        break;
                                                    case 2:
                                                        echo '<span class="my-acc__order-table--danger">Đã hủy</span>';
                                                        break;
                                                    case 3:
                                                        echo '<span class="my-acc__order-table--active">Hoàn thành</span>';
                                                        break;
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <button class="my-acc__order-table-btn">
                                                <a href="<?=$SITE_URL;?>/my-account/?booking_detail&id=<?=$item['id'];?>" class="my-acc__order-table-btn-link">VIEW</a>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="alert alert-success my-acc__order-msg hidden">Không tìm thấy đơn đặt bàn nào</div>

                            <!-- phân trang -->
                            <ul class="content__table-pagination my-acc__order-pagination">
                                <li class="content__table-pagination-item">
                                    <a href="<?=$SITE_URL;?>/my-account/?booking" class="content__table-pagination-link content__table-pagination-link-first">
                                        <i class="fas fa-angle-double-left"></i>
                                    </a>
                                </li>
                                <?php
                                    if ($currentPage > 1) {
                                        echo '
                                        <li class="content__table-pagination-item">
                                            <a href="' . $SITE_URL . '/my-account/?booking&page='. ($currentPage - 1) .'" class="content__table-pagination-link content__table-pagination-link-pre">
                                                <i class="fas fa-angle-left"></i>
                                            </a>
                                        </li>';
                                    }
                                ?>
                                <?php
                                    for ($i = 1; $i <= $totalPage; $i++) {
                                        if ($currentPage == $i) {
                                            echo '
                                            <li class="content__table-pagination-item">
                                                <a href="'.$SITE_URL . '/my-account/?booking&page='. $i .'" class="content__table-pagination-link content__table-pagination-link--active">' . $i . '</a>
                                            </li>
                                            ';
                                        } else {
                                            echo '
                                            <li class="content__table-pagination-item">
                                                <a href="'.$SITE_URL . '/my-account/?booking&page='. $i .'" class="content__table-pagination-link">' . $i . '</a>
                                            </li>
                                            ';
                                        }
                                    }
                                ?>

                                <?php
                                    if ($currentPage < $totalPage) {
                                        echo '
                                        <li class="content__table-pagination-item">
                                            <a href="' . $SITE_URL . '/my-account/?booking&page='. ($currentPage + 1) .'" class="content__table-pagination-link content__table-pagination-link-next">
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                        </li>';
                                    }
                                ?>
                                
                                
                                <li class="content__table-pagination-item">
                                    <a href="<?=$SITE_URL;?>/my-account/?booking&page=<?=$totalPage;?>" class="content__table-pagination-link content__table-pagination-link-last">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                            </ul>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>