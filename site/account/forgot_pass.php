        <!-- CONTENT -->
        <div class="content">
            
            <div class="grid">
                <div class="page-login">
                    <p>Quên mật khẩu? Vui lòng nhập tên đăng nhập hoặc địa chỉ email. Bạn sẽ nhận được một liên kết tạo mật khẩu mới qua email</p>
                    <div class="form-wrapper">
                        <form action="" method="POST">
                            <div class="control-wrapper">
                                <label for="customer_email">
                                    Tên tài khoản hoặc  email
                                    <span class="req">*</span>
                                </label>
                                <input type="text" name="user" id="email" placeholder="Nhập tên đăng nhập hoặc email" value="<?=$userInfo['user'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['user'] ?? '';?>
                                </span>
                                <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>
                            </div>
                            <div class="control-wrapper">
                                <button type="submit" name="btn_forgot">Đặt lại mật khẩu</button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->