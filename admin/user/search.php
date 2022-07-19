<main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Khách hàng</h5>
                        <span class="content__header-description">Danh sách khách hàng</span>
                    </div>

                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-select-all">Chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-unselect-all">Bỏ chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-del-all">Xóa các mục chọn</button>
                        <a href="<?=$ADMIN_URL?>/khach-hang/?btn_add" class="content__header-item-btn">Thêm KH</a>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">User Management</h3>
                            <span class="content__table-text">User management made easy</span>
                        </div>

                        <form action="" class="content__table-heading-form" method="POST">
                            <input type="text" class="content__table-heading-form-control" name="keyword" placeholder="Nhập tên khách hàng">
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
                                <th>Mã KH</th>
                                <th>Thông tin</th>
                                <th>Tên đăng nhập</th>
                                <th class="hide-on-mobile">Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>Vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="content__table-body">
                            <?php foreach ($userList as $item): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </td>
                                <td><?=$item['id'];?></td>
                                <td class="content__table-cell-flex">
                                    <div class="content__table-img">
                                    <?php $image_path = is_file($IMG_PATH . '/' . $item['avatar']) ? $IMG_URL . '/' . $item['avatar'] : $IMG_URL . '/' . 'image_default.png';?>
                                        <img src="<?=$image_path;?>" alt="" class="content__table-avatar">
                                    </div>

                                    <div class="content__table-info">
                                        <span class="content__table-name">
                                            <?=$item['fullName'];?>
                                        </span>
                                        <span class="content__table-email hide-on-mobile">
                                            <?=$item['email'];?>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <?=$item['username'];?>
                                </td>
                                <td class="hide-on-mobile">
                                    <span class="content__table-text-success">
                                        <?=$item['created_at'] ? date_format(date_create($item['created_at']), "d/m/Y") : '00/00/0000';?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($item['active'] == 1): ?>
                                        <span class="content__table-stt-active">Active</span>
                                    <?php else :?>
                                        <span class="content__table-stt-locked">Locked</span>
                                    <?php endif; ?>
                                        
                                </td>
                                <td><?=$item['role'] == 1 ? 'Quản trị viên' : 'Khách hàng';?></td>
                                <td>
                                    <div class="user_list-action">
                                        <a onclick="return confirm('Bạn có chắc muốn khóa tài khoản khách hàng này không?') ? window.location.href = '<?=$ADMIN_URL;?>/user/?btn_lock&ma_kh=<?=$item['id'];?>' : false;" class="content__table-action warning hide-on-mobile">
                                            <i class="fas fa-user-lock"></i>
                                        </a>
                                        <a onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản khách hàng này không?') ? window.location.href = '<?=$ADMIN_URL;?>/user/?btn_unlock&ma_kh=<?=$item['id'];?>' : false;" class="content__table-action success hide-on-mobile">
                                            <i class="fas fa-unlock"></i>
                                        </a>
                                        <a onclick="return confirm('Bạn có chắc muốn xóa khách hàng này không?') ? window.location.href = '<?=$ADMIN_URL;?>/user/?btn_delete&id=<?=$item['id'];?>' : false;" class="content__table-action danger">
                                            <i class="fas fa-user-times"></i>
                                        </a>
                                        <a href="<?=$ADMIN_URL?>/user/?btn_edit&ma_kh=<?=$item['id'];?>" class="content__table-action info">
                                            <i class="fas fa-user-edit"></i>
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