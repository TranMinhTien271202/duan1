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
                            <li class="content__profile-info-item">
                                <div class="content__profile-info-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <a href="<?=$ADMIN_URL;?>/account" class="content__profile-info-link">Cập nhật thông tin</a>
                            </li>
                            <li class="content__profile-info-item content__profile-info-item--active">
                                <div class="content__profile-info-icon">
                                    <i class="fas fa-key"></i>
                                </div>
                                <a href="<?=$ADMIN_URL;?>/account/?update_pass" class="content__profile-info-link">Đổi mật khẩu</a>
                            </li>
                        </ul>
                    </section>

                    <section class="content__profile-form-edit-wrap">
                        <form action="" class="content__profile-form" method="POST">
                            <div class="content__profile-form-heading">
                                <div class="content__profile-form-heading-text">
                                    <span class="content__profile-form-heading-title">Đổi mật khẩu</span>
                                    <span class="content__profile-form-heading-desc">Cập nhật mật khẩu</span>
                                </div>
                                <div class="content__profile-form-heading-act">
                                    <button class="content__profile-form-btn" name="btn_update_pass">Lưu thay đổi</button>
                                    <a href="" class="content__profile-form-btn">Quay lại</a>
                                </div>
                            </div>

                            <div class="content__profile-form-body">
                                <div class="form__group">
                                    <label for="old_password">Mật khẩu hiện tại</label>
                                    <div class="form-control">
                                        <input type="password" name="old_password" placeholder="**********" value="<?=$password['old_password'] ?? '';?>">
                                        <span class="form-message">
                                            <?=$errorMessage['old_password'] ?? '';?>
                                        </span>
                                    </div>
                                </div>
            
                                <div class="form__group">
                                    <label for="new_password">Mật khẩu mới</label>
                                    <div class="form-control">
                                        <input type="password" name="new_password" placeholder="**********" value="<?=$password['new_password'] ?? '';?>">
                                        <span class="form-message">
                                            <?=$errorMessage['new_password'] ?? '';?>
                                        </span>
                                    </div>
                                </div>
            
                                <div class="form__group">
                                    <label for="confirm_password">Xác nhận mật khẩu</label>
                                    <div class="form-control">
                                        <input type="password" name="confirm_password" placeholder="**********" value="<?=$password['confirm_password'] ?? '';?>">
                                        <span class="form-message">
                                            <?=$errorMessage['confirm_password'] ?? '';?>
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