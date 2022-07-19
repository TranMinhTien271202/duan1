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
                    <form action="" class="content__form" enctype="multipart/form-data" method="post">
                        <h5 class="content__form-title">Thông tin loại hàng:</h5>
    
                        <div class="form__group">
                            <label for="ten_loai">Tên loại hàng</label>
                            <div class="form-control">
                                <input type="text" name="ten_loai" placeholder="Nhập tên loại hàng" value="<?=$category['cate_name'] ?? $categoryData['cate_name'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['cate_name'] ?? '';?>
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

                        <div class="form__group">
                            <label for="hinh_anh">Xem trước ảnh loại hàng</label>
                            <div class="form-image-box">
                                <?php
                                    if (isset($hinh)) {
                                        $image_path = $IMG_URL . '/' . $hinh;
                                    } else {
                                        $image_path = is_file($IMG_PATH . '/' . $categoryData['cate_image']) && $categoryData['cate_image'] ? $IMG_URL . '/' . $categoryData['cate_image'] : $IMG_URL . '/' . 'product.jpg';
                                    }
                                ?>
                                <img src="<?=$image_path;?>" alt="">
                            </div>
                        </div>

                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>
    
                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_update">Cập nhật loại hàng</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>