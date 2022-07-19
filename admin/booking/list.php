        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Đặt bàn</h5>
                        <span class="content__header-description">Danh sách đặt bàn</span>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Booking Management</h3>
                            <span class="content__table-text">Booking management made easy</span>
                        </div>

                        <form action="" class="content__table-heading-form" method="POST">
                            <input type="text" class="content__table-heading-form-control form__control-booking" name="keyword" placeholder="Nhập tên KH hoặc mã đặt bàn">
                            <button type="button" class="content__table-heading-form-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <?php
                        if (empty($bookingList)) {
                            echo '<div class="alert alert-success">Chưa có lượt đặt bàn</div>';
                            die();
                        }
                    ?>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <!-- <th>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </th> -->
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
                                <!-- <td>
                                    <input type="checkbox" data-id="">
                                </td> -->
                                <td>
                                    #<?=$item['id'];?>
                                </td>
                                <td>
                                    <span class="content__table-text-black">
                                        <?=$item['name'];?>
                                    </span>
                                </td>
                                <td>
                                    <span class="content__table-text-success">
                                        <?=date('d/m/Y', strtotime($item['date_book'])) . ' ' . date('H:i', strtotime($item['time_book']))?>
                                    </span>
                                </td>
                                <td>
                                    <?=$item['table_name'];?>
                                </td>
                                <td>
                                    <?php
                                        switch($item['status']) {
                                            case 0:
                                                echo '<span class="content__table-stt-active">Mới đặt bàn</span>';
                                                break;
                                            case 1:
                                                echo '<span class="content__table-stt-active">Đã xác nhận</span>';
                                                break;
                                            case 2:
                                                echo '<span class="content__table-stt-locked">Đã hủy</span>';
                                                break;
                                            case 3:
                                                echo '<span class="content__table-stt-active">Hoàn thành</span>';
                                                break;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?=$ADMIN_URL;?>/booking/?detail&id=<?=$item['id'];?>" class="content__table-stt-active">Chi tiết</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <ul class="content__table-pagination">
                        <li class="content__table-pagination-item">
                            <a href="<?=$ADMIN_URL;?>/order" class="content__table-pagination-link content__table-pagination-link-first">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                        <?php
                            if ($currentPage > 1) {
                                echo '
                                <li class="content__table-pagination-item">
                                    <a href="' . $ADMIN_URL . '/order/?page='. ($currentPage - 1) .'" class="content__table-pagination-link content__table-pagination-link-pre">
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
                                        <a href="'.$ADMIN_URL . '/order/?page='. $i .'" class="content__table-pagination-link content__table-pagination-link--active">' . $i . '</a>
                                    </li>
                                    ';
                                } else {
                                    echo '
                                    <li class="content__table-pagination-item">
                                        <a href="'.$ADMIN_URL . '/order/?page='. $i .'" class="content__table-pagination-link">' . $i . '</a>
                                    </li>
                                    ';
                                }
                            }
                        ?>

                        <?php
                            if ($currentPage < $totalPage) {
                                echo '
                                <li class="content__table-pagination-item">
                                    <a href="' . $ADMIN_URL . '/order/?page='. ($currentPage + 1) .'" class="content__table-pagination-link content__table-pagination-link-next">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>';
                            }
                        ?>
                        
                        
                        <li class="content__table-pagination-item">
                            <a href="<?=$ADMIN_URL;?>/order/?page=<?=$totalPage;?>" class="content__table-pagination-link content__table-pagination-link-last">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </main>