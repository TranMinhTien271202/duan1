<main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Khách hàng</h5>
                        <span class="content__header-description">Cập nhật thông tin khách hàng</span>
                    </div>

                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-reset">Nhập lại</button>
                        <a href="<?=$ADMIN_URL?>/user" class="content__header-item-btn">DS Khách Hàng</a>
                    </div>
                </div>
            </header>

            <div class="content__home">
                <div class="content__home-wrap">
                    <form action="" class="content__form" method="POST" enctype="multipart/form-data">
                        <h5 class="content__form-title">Thông tin chi tiết khách hàng:</h5>

                        <div class="form__group">
                            <label for="ma_kh">Mã khách hàng</label>
                            <div class="form-control disabled">
                                <input type="text" name="ma_kh" readonly value="<?=$ma_kh ?? '';?>">
                            </div>
                        </div>
    
                        <div class="form__group">
                            <label for="ten_dn">Tên đăng nhập</label>
                            <div class="form-control disabled">
                                <input type="text" name="username" readonly placeholder="Nhập tên đăng nhập" value="<?=$userData['username'] ?? '';?>">
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="mat_khau">Mật khẩu</label>
                            <div class="form-control">
                                <input type="password" name="password" placeholder="**********" value="<?=$password ?? $userData['password'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['password'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="xac_nhan">Xác nhận mật khẩu</label>
                            <div class="form-control">
                                <input type="password" name="confirm" placeholder="**********" value="<?=$confirm ?? $userData['password'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['confirm'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="ho_ten">Họ tên khách hàng</label>
                            <div class="form-control">
                                <input type="text" name="fullName" placeholder="Nhập họ tên khách hàng" value="<?=$fullName ?? $userData['fullName'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['fullName'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="dia_chi">Địa chỉ</label>
                            <div class="form-control">
                                <input type="text" name="address" placeholder="Nhập địa chỉ khách hàng" value="<?=$address ?? $userData['address'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['address'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="sdt">Số điện thoại</label>
                            <div class="form-control">
                                <input type="text" name="phone" placeholder="Nhập số điện thoại khách hàng" value="<?=$sdt ?? $userData['phone'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['phone'] ?? '';?>
                                </span>
                            </div>
                        </div>

                       

                        <div class="form__group">
                            <label for="email">Email</label>
                            <div class="form-control">
                                <input type="text" name="email" placeholder="Nhập địa chỉ email" value="<?=$email ?? $userData['email'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['email'] ?? '';?>
                                </span>
                            </div>
                        </div>
    
                        <div class="form__group">
                            <label for="hinh_anh">Hình ảnh</label>
                            <div class="form-control">
                                <input type="file" name="avatar" class="form__group-image" multiple onchange="preImage(event);">
                                <span class="form-message"></span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="hinh_anh">Xem trước ảnh</label>
                            <div class="form-image-box">
                                <?php
                                    if (isset($anh)) {
                                        $image_path = $IMG_URL . '/' . $anh;
                                    } else {
                                        // $image_path = is_file($IMG_PATH . '/' . $userData['avatar']) ? $IMG_URL . '/' . $userData['avatar'] : $IMG_URL . '/image_default.jpg';
                                        $image_path = $IMG_URL . '/' . $userData['avatar'];
                                    }
                                ?>
                                <img src="<?=$image_path;?>" alt="">
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="kich_hoat">Kích hoạt</label>
                            <div class="form__group-item-flex">
                                <div class="form__group-item-flex-item">
                                    <input type="radio" name="active" <?=!$userData['active'] ? 'checked' : '';?> value="0">
                                    <span class="form__group-item-flex-text">Chưa kích hoạt</span>
                                </div>

                                <div class="form__group-item-flex-item">
                                    <input type="radio" name="active" <?=$userData['active'] ? 'checked' : '';?> value="1">
                                    <span class="form__group-item-flex-text">Kích hoạt</span>
                                </div>

                                <span class="form-message"></span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="vai_tro">Vai trò</label>
                            <div class="form__group-item-flex">
                                <div class="form__group-item-flex-item">
                                    <input type="radio" name="role" <?=!$userData['role'] ? 'checked' : '';?> value="0">
                                    <span class="form__group-item-flex-text">Khách hàng</span>
                                </div>

                                <div class="form__group-item-flex-item">
                                    <input type="radio" name="role" <?=$userData['role'] ? 'checked' : '';?> value="1">
                                    <span class="form__group-item-flex-text">Quản trị viên</span>
                                </div>
                                

                                <span class="form-message"></span>
                            </div>
                        </div>

                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>
    
                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_update">Cập nhật thông tin</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>