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
                            <!-- nếu không có đơn hàng -->
                            <?php
                                if (empty($myCarts)) {
                                    echo '<div class="alert alert-success my-acc__order-msg">Không có đơn hàng nào</div>';
                                }
                            ?>

                            <!-- nếu có -->
                            <?php if (!empty($myCarts)): ?>
                            <form action="" class="my-acc__order-filter">
                                <input type="text" class="my-acc__order-form-control input form__control-my-order" placeholder="Nhập mã đơn hàng hoặc tên KH">
                                <select name="status" class="form__select-my-order" id="">
                                    <option value="">-- Trạng thái --</option>
                                    <option value="0">Đơn hàng mới</option>
                                    <option value="1">Đã xác nhận</option>
                                    <option value="2">Đang giao hàng</option>
                                    <option value="3">Đã giao hàng</option>
                                    <option value="4">Đã hủy</option>
                                </select>
                            </form>

                            <table class="my-acc__order-table">
                                <thead>
                                    <tr>
                                        <th>Mã ĐH</th>
                                        <th>Tên người nhận</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng giá trị</th>
                                        <th>Trạng thái</th>
                                        <th>Hành dộng</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($myCarts as $item): ?>
                                    <tr>
                                        <td>#<?=$item['id'];?></td>
                                        <td><?=$item['customer_name'];?></td>
                                        <td><?=date_format(date_create($item['created_at']), 'd/m/Y H:i');?></td>
                                        <td>
                                            <?=number_format($item['total_price'], 0, '', ',');?> VNĐ
                                        </td>
                                        <td>
                                            <?php
                                                switch($item['status']) {
                                                    case 0:
                                                        echo '<span class="my-acc__order-table--active">Đơn hàng mới</span>';
                                                        break;
                                                    case 1:
                                                        echo '<span class="my-acc__order-table--active">Đã xác nhận</span>';
                                                        break;
                                                    case 2:
                                                        echo '<span class="my-acc__order-table--active">Đang giao hàng</span>';
                                                        break;
                                                    case 3:
                                                        echo '<span class="my-acc__order-table--active">Đã giao hàng</span>';
                                                        break;
                                                    case 4:
                                                        echo '<span class="my-acc__order-table--danger">Đã hủy</span>';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <button class="my-acc__order-table-btn">
                                                <a href="<?=$SITE_URL;?>/my-account/?cart_detail&id=<?=$item['id'];?>" class="my-acc__order-table-btn-link">VIEW</a>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="alert alert-success my-acc__order-msg hidden">Không tìm thấy đơn hàng nào</div>

                            <!-- phân trang -->
                            <ul class="content__table-pagination my-acc__order-pagination">
                                <li class="content__table-pagination-item">
                                    <a href="<?=$SITE_URL;?>/my-account/?cart" class="content__table-pagination-link content__table-pagination-link-first">
                                        <i class="fas fa-angle-double-left"></i>
                                    </a>
                                </li>
                                <?php
                                    if ($currentPage > 1) {
                                        echo '
                                        <li class="content__table-pagination-item">
                                            <a href="' . $SITE_URL . '/my-account/?cart&page='. ($currentPage - 1) .'" class="content__table-pagination-link content__table-pagination-link-pre">
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
                                                <a href="'.$SITE_URL . '/my-account/?cart&page='. $i .'" class="content__table-pagination-link content__table-pagination-link--active">' . $i . '</a>
                                            </li>
                                            ';
                                        } else {
                                            echo '
                                            <li class="content__table-pagination-item">
                                                <a href="'.$SITE_URL . '/my-account/?cart&page='. $i .'" class="content__table-pagination-link">' . $i . '</a>
                                            </li>
                                            ';
                                        }
                                    }
                                ?>

                                <?php
                                    if ($currentPage < $totalPage) {
                                        echo '
                                        <li class="content__table-pagination-item">
                                            <a href="' . $SITE_URL . '/my-account/?cart&page='. ($currentPage + 1) .'" class="content__table-pagination-link content__table-pagination-link-next">
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                        </li>';
                                    }
                                ?>
                                
                                
                                <li class="content__table-pagination-item">
                                    <a href="<?=$SITE_URL;?>/my-account/?cart&page=<?=$totalPage;?>" class="content__table-pagination-link content__table-pagination-link-last">
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