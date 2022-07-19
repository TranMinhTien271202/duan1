<main class="content__user">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Bàn</h5>
                        <span class="content__header-description">Danh sách bàn</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-select-all">Chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-unselect-all">Bỏ chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-del-all">Xóa các mục chọn</button>
                        <a href="<?=$ADMIN_URL.'/loai-hang/?btn_add';?>" class="content__header-item-btn">Thêm bàn</a>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Quản lý bàn</h3>
                            <span class="content__table-text">Quản lý bàn dễ dàng </span>
                        </div>

                        <form action="" class="content__table-heading-form" method="POST">
                            <input type="text" class="content__table-heading-form-control" name="keywords" placeholder="Nhập tên bàn cần tìm">
                            <button class="content__table-heading-form-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="select_all" class="select_all">
                                </th>
                                <th>Tên bàn</th>
                                <th>Số ghế</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="content__table-body">
                            <?php foreach($listTable as $table): ?>
                                <tr>
                                <td>
                                    <input type="checkbox" data-id="<?=$table['id'];?>">
                                </td>
                                <td class="content__table-text-black"><?=$table['name'];?></td>
                                <td class="content__table-text-black"><?=$table['guest_number'];?></td>
                                <td class="content__table-text-black"><?php if($table['status']==0){
                                    echo "Còn trống";
                                }else if($table['status']==1){
                                    echo 'Có khách';
                                }else{
                                    echo 'Đã đặt trước';
                                }?></td>
                                
                                <td>
                                    <div class="user_list-action">
                                        <a onclick="return confirm('Bạn có chắc muốn xóa bàn này không?') ?
                                        window.location.href = '?btn_delete&id=<?=$table['id'];?>' : false;
                                        " class="content__table-action danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="<?=$ADMIN_URL;?>/table/?btn_edit&id=<?=$table['id'];?>" class="content__table-action info">
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