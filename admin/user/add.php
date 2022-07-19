<main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Khách hàng</h5>
                        <span class="content__header-description">Thêm mới khách hàng</span>
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
                            <label for="ho_ten">Họ tên khách hàng</label>
                            <div class="form-control">
                                <input type="text" name="fullName" placeholder="Nhập họ tên khách hàng" value="<?=$fullName ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['fullName'] ?? '';?>
                                </span>
                            </div>
                        </div>
    
                        <div class="form__group">
                            <label for="ten_dn">Tên đăng nhập</label>
                            <div class="form-control">
                                <input type="text" name="username" placeholder="Nhập tên đăng nhập" value="<?=$username ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['username'] ?? '';?>
                                </span>
                            </div>
                        </div>
    
                        <div class="form__group">
                            <label for="mat_khau">Mật khẩu</label>
                            <div class="form-control">
                                <input type="password" name="password" placeholder="**********" value="<?=$user['password'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['password'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="xac_nhan">Xác nhận mật khẩu</label>
                            <div class="form-control">
                                <input type="password" name="confirm" placeholder="**********" value="<?=$user['confirm'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['xac_nhan'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="dia_chi">Địa chỉ</label>
                            <div class="form-control">
                                <input type="text" name="address" placeholder="Nhập địa chỉ khách hàng" value="<?=$user['address'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['address'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="sdt">Số điện thoại</label>
                            <div class="form-control">
                                <input type="text" name="phone" placeholder="Nhập số điện thoại khách hàng" value="<?=$user['phone'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['phone'] ?? '';?>
                                </span>
                            </div>
                        </div>

                       

                        <div class="form__group">
                            <label for="email">Email</label>
                            <div class="form-control">
                                <input type="text" name="email" placeholder="Nhập địa chỉ email" value="<?=$user['email'] ?? '';?>">
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

                        <div class="form__group hide">
                            <label for="hinh_anh">Xem trước ảnh</label>
                            <div class="form-image-box">
                                <img src="./assets/images/profile.png" alt="">
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="kich_hoat">Kích hoạt</label>
                            <div class="form__group-item-flex">
                                <div class="form__group-item-flex-item">
                                    <input type="radio" name="active" <?=isset($user['active']) && !$user['active'] ? 'checked' : 'checked';?> value="0">
                                    <span class="form__group-item-flex-text">Chưa kích hoạt</span>
                                </div>

                                <div class="form__group-item-flex-item">
                                    <input type="radio" name="active" <?=isset($user['active']) && $user['active'] ? 'checked' : '';?> value="1">
                                    <span class="form__group-item-flex-text">Kích hoạt</span>
                                </div>

                                <span class="form-message"></span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="vai_tro">Vai trò</label>
                            <div class="form__group-item-flex">
                                <div class="form__group-item-flex-item">
                                    <input type="radio" name="role" <?php
                                        if (isset($user['role'])) {
                                            if (!$user['role']) {
                                                echo 'checked';
                                            }
                                        } else {
                                            echo 'checked';
                                        }
                                    ?> value="0">
                                    <span class="form__group-item-flex-text">Khách hàng</span>
                                </div>

                                <div class="form__group-item-flex-item">
                                    <input type="radio" name="role" <?=isset($user['role']) && $user['role'] ? 'checked' : '';?> value="1">
                                    <span class="form__group-item-flex-text">Quản trị viên</span>
                                </div>

                                <span class="form-message"></span>
                            </div>
                        </div>

                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>
    
                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_insert">Thêm khách hàng</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>