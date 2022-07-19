        <!-- CONTENT -->
        <div class="content">
            
           <div class="grid">
                <div class="page-login">
                    <h2>Đăng ký</h2>
                    <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>
                    <div class="form-wrapper">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="control-wrapper">
                                <label for="customer_email">
                                    Tên đăng nhập
                                    <span class="req">*</span>
                                </label>
                                <input type="text" name="username" id="email" placeholder="demo" value="<?=$user_dk['username'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['username'] ?? '';?>
                                </span>
                            </div>
                            <!--  -->
                            <div class="control-wrapper">
                                <label for="customer_email">
                                    Họ và tên
                                    <span class="req">*</span>
                                </label>
                                <input type="text" name="fullName" id="email" placeholder="Ngô Văn A" value="<?=$user_dk['fullName'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['fullName'] ?? '';?>
                                </span>
                            </div>
                            <!--  -->
                            <div class="control-wrapper">
                                <label for="customer_email">
                                    Email
                                    <span class="req">*</span>
                                </label>
                                <input type="email" name="email" id="email" placeholder="demo123@gmail.com" value="<?=$user_dk['email'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['email'] ?? '';?>
                                </span>
                            </div>
                            <!--  -->
                            <div class="control-wrapper">
                                <label for="customer_email">
                                    Số điện thoại
                                    <span class="req">*</span>
                                </label>
                                <input type="number" name="phone" id="email" placeholder="Nhập số điện thoại" value="<?=$user_dk['phone'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['phone'] ?? '';?>
                                </span>
                            </div>
                            <!--  -->
                            <div class="control-wrapper">
                                <label for="customer_password">
                                    Mật khẩu
                                    <span class="req">*</span>
                                </label>
                                <input type="password" name="password" id="password" placeholder="*************" value="<?=$user_dk['password'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['password'] ?? '';?>
                                </span>
                            </div>
                            <!--  -->
                            <div class="control-wrapper">
                                <label for="customer_password">
                                    Xác nhận mật khẩu
                                    <span class="req">*</span>
                                </label>
                                <input type="password" name="confirm" id="password" placeholder="*************" value="<?=$user_dk['confirm'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['confirm'] ?? '';?>
                                </span>
                            </div>
                            <!--  -->
                        

                            <div class="control-wrapper">
                                <button type="submit" name="btn_register">Đăng ký</button>
                            
                            </div>
                        
                        </form>
                    </div>
                </div>
           </div>
        </div>
        <!-- END CONTENT -->