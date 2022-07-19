<main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Slider</h5>
                        <span class="content__header-description">Danh sách slide</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-select-all">Chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-unselect-all">Bỏ chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-del-all">Xóa các mục chọn</button>
                        <a href="<?=$ADMIN_URL.'/slide/?btn_add';?>" class="content__header-item-btn">Thêm Slide</a>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading">
                        <h3 class="content__table-title">Slide Management</h3>
                        <span class="content__table-text">Slide management made easy</span>
                    </div>

                    <?php
                    
                        if (!$slideList) {
                            echo '<div class="alert alert-success">Chưa có slide nào</div>';
                            die();
                        }
                    ?>

                    <table class="content__table-table content__table-table-slide">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="select_all" class="select_all">
                                </th>
                                <th>Mã Slide</th>
                                <th>Tên slide</th>
                                <th>Url</th>
                                <th>Ảnh slide</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="content__table-body">
                            <?php foreach ($slideList as $item): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </td>
                                <td>
                                    <?=$item['id'];?>
                                </td>
                                <td>
                                    <span class="content__table-text-black">
                                        <?=$item['title'];?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?=$item['url'];?>" target="_blank" class="content__table-stt-active">Mở Url</a>
                                </td>
                                <td>
                                    <?php $image_path = is_file($IMG_PATH . '/' . $item['slide_image']) ? $IMG_URL . '/' . $item['slide_image'] : $IMG_URL . '/' . 'product.jpg';?>
                                    <img src="<?=$image_path;?>" alt="" class="content__table-table-slide-image">
                                </td>
                                <td>
                                    <div class="user_list-action">
                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa slide này không?') ? window.location.href = '<?=$ADMIN_URL?>/slide/?btn_delete&id=<?=$item['id'];?>' : false;" class="content__table-action danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="<?=$ADMIN_URL?>/slide/?btn_edit&ma_slide=<?=$item['id'];?>" class="content__table-action info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <ul class="content__table-pagination">
                        <li class="content__table-pagination-item">
                            <a href="?page=1" class="content__table-pagination-link content__table-pagination-link-first">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                        <?php
                        
                            if ($currentPage > 1) {
                                echo
                                '
                                    <li class="content__table-pagination-item">
                                        <a href="?page='.($currentPage - 1).'" class="content__table-pagination-link content__table-pagination-link-pre">
                                            <i class="fas fa-angle-left"></i>
                                        </a>
                                    </li>
                                ';
                            }

                        ?>
                        

                        <?php
                        
                            for ($i = 1; $i <= $totalPage; $i++) {
                                if ($i == $currentPage) {
                                    echo
                                    '
                                        <li class="content__table-pagination-item">
                                            <a href="?page='.$i.'" class="content__table-pagination-link content__table-pagination-link--active">'.$i.'</a>
                                        </li>
                                    ';
                                } else {
                                    echo
                                    '
                                        <li class="content__table-pagination-item">
                                            <a href="?page='.$i.'" class="content__table-pagination-link">'.$i.'</a>
                                        </li>
                                    ';
                                }
                            }

                        ?>

                        <?php

                            if ($currentPage < $totalPage) {
                                echo
                                '
                                    <li class="content__table-pagination-item">
                                        <a href="?page='.($currentPage + 1).'" class="content__table-pagination-link content__table-pagination-link-next">
                                            <i class="fas fa-angle-right"></i>
                                        </a>
                                    </li>
                                ';
                            }

                        ?>
                        
                        <li class="content__table-pagination-item">
                            <a href="?page=<?=$totalPage;?>" class="content__table-pagination-link content__table-pagination-link-last">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </main>