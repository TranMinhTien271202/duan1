<main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Loại hàng</h5>
                        <span class="content__header-description">Thêm mới loại hàng</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-reset">Nhập lại</button>
                        <a href="<?=$ADMIN_URL.'/category';?>" class="content__header-item-btn">DS Loại hàng</a>
                    </div>
                </div>
            </header>

            <div class="content__home">
                <div class="content__home-wrap">
                    <form action="" class="content__form" enctype="multipart/form-data" method="POST">
                        <h5 class="content__form-title">Thông tin loại hàng:</h5>
                        <div class="form__group">
                            <label for="ten_loai">Tên loại hàng</label>
                            <div class="form-control">
                                <input type="text" name="ten_loai" placeholder="Nhập tên loại hàng" value="<?=$category['cate_name'] ?? '';?>">
                                <span class="form-message">
                                    <?=isset($errorMessage['cate_name']) ? $errorMessage['cate_name'] : '';?>
                                </span>
                            </div>
                        </div>
    
                        <div class="form__group">
                            <label for="hinh_anh">Ảnh loại hàng</label>
                            <div class="form-control">
                                <input type="file" name="cate_image" accept="image/*" onchange="preImage(event);">
                                <span class="form-message"></span>
                            </div>
                        </div>

                        <div class="form__group hide">
                            <label for="hinh_anh">Xem trước ảnh loại hàng</label>
                            <div class="form-image-box">
                                <img src="./assets/images/profile.png" alt="">
                            </div>
                        </div>
    

                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>
                        
    
                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_insert">Thêm loại hàng</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>