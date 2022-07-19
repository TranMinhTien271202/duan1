<main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Góp ý</h5>
                        <span class="content__header-description">Tổng hợp ý kiến người dùng</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-select-all">Chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-unselect-all">Bỏ chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-del-all">Xóa các mục chọn</button>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Comment Management</h3>
                            <span class="content__table-text">Comment management made easy</span>
                        </div>

                        <form action="" class="content__table-heading-form" method="POST">
                            <input type="text" class="content__table-heading-form-control" name="keyword" placeholder="Nhập nội dung góp ý...">
                            <button class="content__table-heading-form-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <?php
                    
                        if (!$items) {
                            echo '<div class="alert alert-success">Chưa có góp ý nào</div>';
                            die();
                        }
                    ?>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="select_all" class="select_all">
                                </th>
                                <th>Nội dung</th>
                                <th>Ngày gửi</th>
                                <th>Người gửi</th>
                                <th>Email</th>
                                <th>Sđt</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="content__table-body">
                            <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </td>
                                <td>
                                    <textarea cols="30" readonly rows="4" class="content__table-comment"><?=$item['content'];?></textarea>
                                </td>
                                <td>
                                    <span class="content__table-text-success">
                                        <?=date_format(date_create($item['created_at']), 'd/m/Y');?>
                                    </span>
                                </td>
                                <td>
                                    <span class="content__table-text-black"><?=$item['name'];?></span>
                                </td>
                                <td><?=$item['email'];?></td>
                                <td><?=$item['phone'];?></td>
                                <td>
                                    <div class="user_list-action">
                                        <a onclick="return confirm('Bạn có chắc muốn xóa góp ý này không?')
                                        ? window.location.href = '<?=$ADMIN_URL;?>/analytics?btn_delete&id=<?=$item['id'];?>'
                                        : false;" class="content__table-action danger">
                                            <i class="fas fa-trash"></i>
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