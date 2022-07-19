<main class="content__user">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Loại hàng</h5>
                        <span class="content__header-description">Danh sách loại hàng</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-select-all">Chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-unselect-all">Bỏ chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-del-all">Xóa các mục chọn</button>
                        <a href="<?=$ADMIN_URL.'/category/?btn_add';?>" class="content__header-item-btn">Thêm LH</a>
                    </div>
                </div>
            </header>

            
            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Category Management</h3>
                            <span class="content__table-text">Category management made easy</span>
                        </div>

                        <form action="" class="content__table-heading-form" method="POST">
                            <input type="text" class="content__table-heading-form-control" name="keyword" placeholder="Nhập tên loại hàng">
                            <button class="content__table-heading-form-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <?php
                    
                        if (!$listCategory) {
                            echo '<div class="alert alert-success">Chưa có loại hàng nào</div>';
                            die();
                        }
                    ?>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="select_all" class="select_all">
                                </th>
                                <th>Mã loại</th>
                                <th>Ảnh loại hàng</th>
                                <th>Tên loại hàng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="content__table-body">
                            <?php foreach ($listCategory as $item): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </td>
                                <td><?=$item['id'];?></td>
                                <td class="content__table-cell-flex">
                                    <?php $image_path = is_file($IMG_PATH . '/' . $item['cate_image']) ? $IMG_URL . '/' . $item['cate_image'] : $IMG_URL . '/' . 'product.jpg';?>
                                    <img src="<?=$image_path;?>" alt="" class="content__table-table-product-img">
                                </td>
                                <td>
                                    <span class="content__table-text-black"><?=$item['cate_name'];?></span>
                                </td>
                                <td>
                                    <div class="user_list-action">
                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa loại hàng này không?') ? window.location.href = '<?=$ADMIN_URL?>/category/?btn_delete&id=<?=$item['id'];?>' : false;" class="content__table-action danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="<?=$ADMIN_URL?>/category/?btn_edit&id=<?=$item['id'];?>" class="content__table-action info">
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