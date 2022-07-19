        <div class="content">
            <header class="my-account__header">
                <div class="grid my-account__header-inner">
                    <h1 class="my-acc__header-title">MY ACCOUNT</h1>
                    <p class="my-acc__header-desc">Đổi mật khẩu</p>
                </div>
            </header>

            <div class="my-acc__content grid">
                <div class="my-acc__content-inner">
                    <!-- dashboard -->
                    <?php require_once $DASHBOARD;?>
                    <!-- dashboard -->

                    <div class="my-acc__content-item">
                        <div class="my-acc__content-item-inner">
                            <h2 class="my-acc__content-item-title">Đổi mật khẩu</h2>

                            <form action="" class="my-acc__content-form" method="POST">

                                <div class="my-acc__content-form-group">
                                    <label for="" class="my-acc__content-form-label">Mật khẩu hiện tại *</label>
                                    <input type="password" class="my-acc__content-form-control input" name="old_password" value="<?=$password['old_password'] ?? '';?>" placeholder="**********">
                                    <span class="form-message">
                                        <?=$errorMessage['old_password'] ?? '';?>
                                    </span>
                                </div>

                                <div class="my-acc__content-form-group">
                                    <label for="" class="my-acc__content-form-label">Mật khẩu mới *</label>
                                    <input type="password" class="my-acc__content-form-control input" name="new_password" value="<?=$password['new_password'] ?? '';?>" placeholder="**********">
                                    <span class="form-message">
                                        <?=$errorMessage['new_password'] ?? '';?>
                                    </span>
                                </div>

                                <div class="my-acc__content-form-group">
                                    <label for="" class="my-acc__content-form-label">Xác nhận mật khẩu mới *</label>
                                    <input type="password" class="my-acc__content-form-control input" name="confirm_password" value="<?=$password['confirm_password'] ?? '';?>" placeholder="**********">
                                    <span class="form-message">
                                        <?=$errorMessage['confirm_password'] ?? '';?>
                                    </span>
                                </div>

                                <?=isset($MESSAGE) ? '<div class="alert alert-success my-account">'.$MESSAGE.'</div>' : '';?>

                                <button class="my-acc__content-form-btn btn" name="btn_update_pass">Đổi mật khẩu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>