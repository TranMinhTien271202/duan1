        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Size</h5>
                        <span class="content__header-description">Danh sách size</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-select-all">Chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-unselect-all">Bỏ chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-del-all">Xóa các mục chọn</button>
                        <a href="<?=$ADMIN_URL;?>/size/?btn_add" class="content__header-item-btn">Thêm size</a>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Size Management</h3>
                            <span class="content__table-text">Size management made easy</span>
                        </div>
                    </div>

                    <?php
                        if (empty($listSize)) {
                            echo '<div class="alert alert-success">Chưa có size nào</div>';
                            die();
                        }
                    ?>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="select_all" class="select_all">
                                </th>
                                <th>Mã Size</th>
                                <th>Tên Size</th>
                                <th>Giá thêm</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="content__table-body">
                            <?php foreach ($listSize as $item): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </td>
                                <td><?=$item['id'];?></td>
                                <td>
                                    <span class="content__table-text-black"><?=$item['product_size'];?></span>
                                </td>
                                <td>
                                    <?=number_format($item['price_increase'], 0, '', ',');?> VNĐ
                                </td>
                                <td>
                                    <span class="content__table-text-success">
                                        <?=date_format(date_create($item['created_at']), 'd/m/Y');?>
                                    </span>
                                </td>
                                <td>
                                    <div class="user_list-action">
                                        <a onclick="return confirm('Bạn có chắc muốn xóa size?') ?
                                        window.location.href = '?btn_delete&id=<?=$item['id'];?>' : false;
                                        " class="content__table-action danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="<?=$ADMIN_URL;?>/size/?btn_edit&id=<?=$item['id'];?>" class="content__table-action info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>