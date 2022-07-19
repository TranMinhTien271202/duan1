        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Sản phẩm</h5>
                        <span class="content__header-description">Thêm mới sản phẩm</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-reset">Nhập lại</button>
                        <a href="<?=$ADMIN_URL;?>/product" class="content__header-item-btn">DS sản phẩm</a>
                    </div>
                </div>
            </header>

            <div class="content__home">
                <div class="content__home-wrap">
                    <form action="" class="content__form" method="POST" enctype="multipart/form-data">
                        <h5 class="content__form-title">Thông tin chi tiết sản phẩm:</h5>
    
                        <div class="form__group">
                            <label for="ten_hh">Tên sản phẩm</label>
                            <div class="form-control">
                                <input type="text" name="product_name" placeholder="Nhập tên sản phẩm" value="<?=$product['product_name'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['product_name'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="password">Loại hàng</label>
                            <div class="form-control">
                                <select name="cate_id" id="">
                                    <option value="">-- Vui lòng chọn loại hàng --</option>
                                    <?php foreach ($listCategory as $cate): ?>
                                        <?php if (isset($product['cate_id']) && $cate_id == $cate['id']): ?>
                                        <option value="<?=$cate['id'];?>" selected><?=$cate['cate_name'];?></option>
                                        <?php else: ?>
                                        <option value="<?=$cate['id'];?>"><?=$cate['cate_name'];?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <span class="form-message">
                                    <?=$errorMessage['cate_id'] ?? '';?>
                                </span>
                            </div>
                        </div>
    
                        <div class="form__group">
                            <label for="hinh_anh">Ảnh sản phẩm</label>
                            <div class="form-control">
                                <input type="file" name="product_image" accept="image/*" onchange="preImage(event);">
                                <span class="form-message"></span>
                            </div>
                        </div>

                        <div class="form__group hide">
                            <label for="avatar">Xem trước ảnh sản phẩm</label>
                            <div class="form-image-box">
                                <img src="./assets/images/profile.png" alt="">
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="giam_gia">Giá</label>
                            <div class="form-control">
                                <input type="number" name="price" placeholder="Nhập giá sản phẩm" value="<?=$product['price'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['price'] ?? '';?>
                                </span>
                            </div>
                        </div>
    
                        <div class="form__group">
                            <label for="giam_gia">Giảm giá</label>
                            <div class="form-control">
                                <input type="number" name="discount" placeholder="Nhập phần trăm giảm giá" value="<?=$product['discount'] ?? 0;?>">
                                <span class="form-message">
                                    <?=$errorMessage['discount'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="condition">Trạng thái</label>
                            <div class="form-control">
                                <select name="status" id="">
                                    <?php if (isset($product['status'])): ?>
                                        <?php if ($product['status']): ?>
                                        <option value="">-- Chọn trạng thái SP --</option>
                                        <option value="0">Ẩn</option>
                                        <option value="1" selected>Hiển thị</option>
                                        <?php elseif ($product['status'] === '0'): ?>
                                        <option value="">-- Chọn trạng thái SP --</option>
                                        <option value="0" selected>Ẩn</option>
                                        <option value="1">Hiển thị</option>
                                        <?php else: ?>
                                        <option value="" selected>-- Chọn trạng thái SP --</option>
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiển thị</option>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <option value="">-- Chọn trạng thái SP --</option>
                                        <option value="0">Ẩn</option>
                                        <option value="1" selected>Hiển thị</option>
                                    <?php endif; ?>
                                </select>
                                <span class="form-message">
                                    <?=$errorMessage['status'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="mo_ta">Mô tả</label>
                            <div class="form-control">
                                <textarea name="description" id="description" rows="5" placeholder="Nhập mô tả sản phẩm"><?=$product['description'] ?? '';?></textarea>
                                <span class="form-message">
                                    <?=$errorMessage['description'] ?? '';?>
                                </span>
                            </div>
                        </div>


                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>

                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_insert">Thêm sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>