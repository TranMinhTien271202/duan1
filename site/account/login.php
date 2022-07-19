        <!-- CONTENT -->
        <div class="content">

            <div class="grid">
                <div class="page-login">
                    <h2 class="page-login-title">Đăng nhập</h2>
                    <div class="form-wrapper">
                        <form action="" method="POST">
                            <div class="control-wrapper">
                                <label for="customer_email">
                                    Tên tài khoản hoặc địa chỉ email
                                    <span class="req">*</span>
                                </label>
                                <input type="text" name="user" id="email" value="<?=$user ?? '';?>" placeholder="Nhập tên đăng nhập hoặc email">
                                <span class="form-message">
                                    <?=$errorMessage['user'] ?? '';?>
                                </span>
                            </div>

                            <div class="control-wrapper">
                                <label for="customer_password">
                                    Mật khẩu
                                    <span class="req">*</span>
                                </label>
                                <input type="password" name="password" id="password" value="<?=$password ?? '';?>" placeholder="************">
                                <span class="form-message">
                                    <?=$errorMessage['password'] ?? '';?>
                                </span>
                            </div>

                            <div class="remember-me">
                                <input type="checkbox">
                               <span> Ghi nhớ mật khẩu</span>
                            </div>
    
                            <div class="control-wrapper">
                                <button type="submit" name = "btn_login">Đăng nhập</button>
                                <a class="forgot-pass" href="<?=$SITE_URL;?>/account/?forgot_pass">Quên mật khẩu?</a>
                            </div>
                        </form>
                    </div>
              </div>
            </div>
        </div>
        <!-- END CONTENT -->