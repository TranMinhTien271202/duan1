        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Tài khoản</h5>
                        <span class="content__header-description">Cập nhật thông tin tài khoản</span>
                    </div>
                </div>
            </header>

            <div class="content__home">
                <div class="content__profile-wrap">
                    <section class="content__profile-info">
                        <div class="content__profile-info-heading">
                            <div class="content__profile-info-img">
                                <img src="<?=$IMG_URL . '/' . $_SESSION['user']['avatar'];?>" alt="">
                            </div>
                            <div class="content__profile-info-overview">
                                <div class="content__profile-info-name"><?=$_SESSION['user']['fullName'];?></div>
                                <div class="content__profile-info-rule"><?=$_SESSION['user']['username'];?></div>
                            </div>
                        </div>
                        <div class="content__profile-info-details">
                            <div class="content__profile-info-group">
                                <label for="email">Email:</label>
                                <span class="content__profile-info-email">
                                    <?=$_SESSION['user']['email'];?>
                                </span>
                            </div>

                            <div class="content__profile-info-group">
                                <label for="date">Ngày tạo:</label>
                                <span class="content__profile-info-date-created">
                                    <?=date_format(date_create($_SESSION['user']['created_at']), 'd/m/Y')?>
                                </span>
                            </div>
                        </div>

                        <ul class="content__profile-info-list">
                            <li class="content__profile-info-item content__profile-info-item--active">
                                <div class="content__profile-info-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <a href="<?=$ADMIN_URL;?>/account" class="content__profile-info-link">Cập nhật thông tin</a>
                            </li>
                            <li class="content__profile-info-item">
                                <div class="content__profile-info-icon">
                                    <i class="fas fa-key"></i>
                                </div>
                                <a href="<?=$ADMIN_URL;?>/account/?update_pass" class="content__profile-info-link">Đổi mật khẩu</a>
                            </li>
                        </ul>
                    </section>

                    <section class="content__profile-form-edit-wrap">
                        <form action="" class="content__profile-form" method="post" enctype="multipart/form-data">
                            <div class="content__profile-form-heading">
                                <div class="content__profile-form-heading-text">
                                    <span class="content__profile-form-heading-title">Thông tin tài khoản</span>
                                    <span class="content__profile-form-heading-desc">Cập nhật thông tin cá nhân của bạn</span>
                                </div>
                                <div class="content__profile-form-heading-act">
                                    <button class="content__profile-form-btn" name="btn_update_info">Lưu thay đổi</button>
                                    <a href="" class="content__profile-form-btn">Quay lại</a>
                                </div>
                            </div>

                            <div class="content__profile-form-body">
                                <div class="form__group">
                                    <label for="username">Tên đăng nhập</label>
                                    <div class="form-control disabled">
                                        <input type="text" disabled name="username" placeholder="Nhập tên đăng nhập" value="<?=$_SESSION['user']['username']?>">
                                    </div>
                                </div>
            
                                <div class="form__group">
                                    <label for="avatar">Ảnh đại diện</label>
                                    <div class="form-control">
                                        <input type="file" name="avatar" onchange="preImage(event);">
                                    </div>
                                </div>
            
                                <div class="form__group">
                                    <label for="avatar">Xem trước ảnh đại diện</label>
                                    <div class="form-image-box">
                                        <?php $img_path = $IMG_URL . '/' . ($avatar ?? $_SESSION['user']['avatar']);?>
                                        <img src="<?=$img_path;?>" alt="">
                                    </div>
                                </div>
            
                                <div class="form__group">
                                    <label for="fullName">Tên hiển thị</label>
                                    <div class="form-control">
                                        <input type="text" name="fullName" placeholder="Nhập họ tên của bạn" value="<?=$fullName ?? $_SESSION['user']['fullName'];?>">
                                        <span class="form-message">
                                            <?=$errorMessage['fullName'] ?? '';?>
                                        </span>
                                    </div>
                                </div>
            
                                <div class="form__group">
                                    <label for="email">Email</label>
                                    <div class="form-control">
                                        <input type="text" name="email" placeholder="Nhập địa chỉ email" value="<?=$email ?? $_SESSION['user']['email'];?>">
                                        <span class="form-message">
                                            <?=$errorMessage['email'] ?? '';?>
                                        </span>
                                    </div>
                                </div>

                                <div class="form__group">
                                    <label for="phone">Sđt</label>
                                    <div class="form-control">
                                        <input type="text" name="phone" placeholder="Nhập số điện thoại" value="<?=$phone ?? $_SESSION['user']['phone'];?>">
                                        <span class="form-message">
                                            <?=$errorMessage['phone'] ?? '';?>
                                        </span>
                                    </div>
                                </div>

                                <div class="form__group">
                                    <label for="address">Địa chỉ</label>
                                    <div class="form-control">
                                        <input type="text" name="address" placeholder="Nhập địa chỉ" value="<?=$address ?? $_SESSION['user']['address'];?>">
                                        <span class="form-message">
                                            <?=$errorMessage['address'] ?? '';?>
                                        </span>
                                    </div>
                                </div>

                                <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </main>