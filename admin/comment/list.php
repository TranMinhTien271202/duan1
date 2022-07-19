        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Bình luận</h5>
                        <span class="content__header-description">Danh sách bình luận theo sản phẩm</span>
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
                            <input type="text" class="content__table-heading-form-control form__control-cmt" name="keyword" placeholder="Nhập tên sản phẩm">
                            <button type="button" class="content__table-heading-form-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <?php
                        if (empty($listComment)) {
                            echo '<div class="alert alert-success">Chưa có bình luận nào</div>';
                            die();
                        }
                    ?>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số bình luận</th>
                                <th>Mới nhất</th>
                                <th>Cũ nhất</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($listComment as $item): ?>
                            <tr>
                                <td>
                                    <?=$item['product_name'];?>
                                </td>
                                <td>
                                    <?=$item['totalComment'];?>
                                </td>
                                <td>
                                    <?=date_format(date_create($item['latest']), 'd/m/Y');?> <?=date_format(date_create($item['latest']), 'H:i');?>
                                </td>
                                <td>
                                    <?=date_format(date_create($item['oldest']), 'd/m/Y');?> <?=date_format(date_create($item['oldest']), 'H:i');?>
                                </td>
                                <td>
                                    <a href="<?=$ADMIN_URL;?>/comment/?detail&p_id=<?=$item['id'];?>" class="content__table-stt-active">Chi tiết</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <ul class="content__table-pagination">
                        <li class="content__table-pagination-item">
                            <a href="<?=$ADMIN_URL;?>/comment" class="content__table-pagination-link content__table-pagination-link-first">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                        <?php
                            if ($currentPage > 1) {
                                echo '
                                <li class="content__table-pagination-item">
                                    <a href="' . $ADMIN_URL . '/comment/?page='. ($currentPage - 1) .'" class="content__table-pagination-link content__table-pagination-link-pre">
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
                                        <a href="'.$ADMIN_URL . '/comment/?page='. $i .'" class="content__table-pagination-link content__table-pagination-link--active">' . $i . '</a>
                                    </li>
                                    ';
                                } else {
                                    echo '
                                    <li class="content__table-pagination-item">
                                        <a href="'.$ADMIN_URL . '/comment/?page='. $i .'" class="content__table-pagination-link">' . $i . '</a>
                                    </li>
                                    ';
                                }
                            }
                        ?>

                        <?php
                            if ($currentPage < $totalPage) {
                                echo '
                                <li class="content__table-pagination-item">
                                    <a href="' . $ADMIN_URL . '/comment/?page='. ($currentPage + 1) .'" class="content__table-pagination-link content__table-pagination-link-next">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>';
                            }
                        ?>
                        
                        
                        <li class="content__table-pagination-item">
                            <a href="<?=$ADMIN_URL;?>/comment/?page=<?=$totalPage;?>" class="content__table-pagination-link content__table-pagination-link-last">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </main>