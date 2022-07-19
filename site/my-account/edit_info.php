        <div class="content">
            <header class="my-account__header">
                <div class="grid my-account__header-inner">
                    <h1 class="my-acc__header-title">MY ACCOUNT</h1>
                    <p class="my-acc__header-desc">Thông tin tài khoản</p>
                </div>
            </header>

            <div class="my-acc__content grid">
                <div class="my-acc__content-inner">
                    <!-- dashboard -->
                    <?php require_once $DASHBOARD;?>
                    <!-- dashboard -->
                    
                    <div class="my-acc__content-item">
                        <div class="my-acc__content-item-inner">
                            <h2 class="my-acc__content-item-title">Cập nhật thông tin tài khoản</h2>

                            <form action="" class="my-acc__content-form" enctype="multipart/form-data" method="POST">
                                <div class="my-acc__content-form-group my-acc__content-form-groups">
                                    <div class="my-acc__content-form-group-item">
                                        <label for="" class="my-acc__content-form-label">Họ tên *</label>
                                        <input type="text" class="my-acc__content-form-control input" name="fullName" value="<?=$fullName ?? $userInfo['fullName'];?>" placeholder="Nhập họ tên của bạn">
                                        <span class="form-message">
                                            <?=$errorMessage['fullName'] ?? '';?>
                                        </span>
                                    </div>
                                    <div class="my-acc__content-form-group-item">
                                        <label for="" class="my-acc__content-form-label">Số điện thoại *</label>
                                        <input type="text" class="my-acc__content-form-control input" name="phone" value="<?=$phone ?? $userInfo['phone'];?>" placeholder="Nhập số điện thoại của bạn">
                                        <span class="form-message">
                                            <?=$errorMessage['phone'] ?? '';?>
                                        </span>
                                    </div>
                                </div>

                                <div class="my-acc__content-form-group">
                                    <label for="" class="my-acc__content-form-label">Ảnh đại diện *</label>
                                    <input type="file" class="my-acc__content-form-control input" name="avatar" accept="image/*" onchange="preImage(event)">
                                </div>

                                <div class="my-acc__content-form-group">
                                    <label for="" class="my-acc__content-form-label">Xem trước ảnh đại diện</label>
                                    <div class="form-image-box">
                                        <?php $img_path = $IMG_URL . '/' . ($avatar ?? $userInfo['avatar']);?>
                                        <img src="<?=$img_path;?>" alt="">
                                    </div>
                                </div>

                                <div class="my-acc__content-form-group">
                                    <label for="" class="my-acc__content-form-label">Email *</label>
                                    <input type="text" class="my-acc__content-form-control input" name="email" value="<?=$email ?? $userInfo['email'];?>" placeholder="Nhập địa chỉ email">
                                    <span class="form-message">
                                        <?=$errorMessage['email'] ?? '';?>
                                    </span>
                                </div>

                                <div class="my-acc__content-form-group">
                                    <label for="" class="my-acc__content-form-label">Địa chỉ *</label>
                                    <input type="text" class="my-acc__content-form-control input" name="address" value="<?=$address ?? $userInfo['address'];?>" placeholder="Nhập địa chỉ">
                                    <span class="form-message">
                                        <?=$errorMessage['address'] ?? '';?>
                                    </span>
                                </div>

                                <?=isset($MESSAGE) ? '<div class="alert alert-success my-account">'.$MESSAGE.'</div>' : '';?>

                                <button class="my-acc__content-form-btn btn" name="btn_update_info">Cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>