        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Thống kê</h5>
                        <span class="content__header-description">Thống kê sản phẩm theo danh mục</span>
                    </div>
                    <div class="content__header-item">
                        <a href="<?=$ADMIN_URL.'/analytics/?chart';?>" class="content__header-item-btn">Xem biểu đồ</a>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Analytics Management</h3>
                            <span class="content__table-text">Analytics management made easy</span>
                        </div>
                    </div>

                    <?php
                        if (empty($categoryAnalytics)) {
                            echo '<div class="alert alert-success">Chưa có danh mục nào</div>';
                            die();
                        }
                    ?>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <th>Loại hàng</th>
                                <th>Số lượng</th>
                                <th>Giá cao nhất</th>
                                <th>Giá thấp nhất</th>
                                <th>Giá trung bình</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($categoryAnalytics as $item): ?>
                            <tr>
                                <td>
                                    <?=$item['cate_name'];?>
                                </td>
                                <td>
                                    <?=$item['totalProduct'];?>
                                </td>
                                <td>
                                    <?=number_format($item['maxPrice'], 0, '', ',');?> VNĐ
                                </td>
                                <td>
                                    <?=number_format($item['minPrice'], 0, '', ',');?> VNĐ
                                </td>
                                <td>
                                    <span class="content__table-text-black">
                                        <?=number_format($item['avgPrice'], 0, '', ',');?> VNĐ
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </main>