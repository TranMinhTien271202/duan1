        <!-- CONTENT -->
        <div class="content">

            <div class="grid">
                <div class="page-login">
                    <h2 class="page-login-title">Đổi mật khẩu</h2>
                    <div class="form-wrapper">
                        <form action="" method="POST">
                            <div class="control-wrapper">
                                <label for="customer_email">
                                    Mật khẩu mới
                                    <span class="req">*</span>
                                </label>
                                <input type="password" name="new_password" id="email" value="<?=$passInfo['new_password'] ?? '';?>" placeholder="************">
                                <span class="form-message">
                                    <?=$errorMessage['new_password'] ?? '';?>
                                </span>
                            </div>

                            <div class="control-wrapper">
                                <label for="customer_password">
                                    Xác nhận mật khẩu mới
                                    <span class="req">*</span>
                                </label>
                                <input type="password" name="confirm_password" id="password" value="<?=$passInfo['confirm_password'] ?? '';?>" placeholder="************">
                                <span class="form-message">
                                    <?=$errorMessage['confirm_password'] ?? '';?>
                                </span>
                            </div>

                            <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>
    
                            <div class="control-wrapper">
                                <button type="submit" name = "btn_update_pass">Đổi mật khẩu</button>
                                <a class="forgot-pass" href="<?=$SITE_URL;?>/account">Đăng nhập?</a>
                            </div>
                        </form>
                    </div>
              </div>
            </div>
        </div>
        <!-- END CONTENT -->