        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Size</h5>
                        <span class="content__header-description">Sửa size</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-reset">Nhập lại</button>
                        <a href="<?=$ADMIN_URL;?>/size" class="content__header-item-btn">DS size</a>
                    </div>
                </div>
            </header>

            <div class="content__home">
                <div class="content__home-wrap">
                    <form action="" class="content__form" method="POST" enctype="multipart/form-data">
                        <h5 class="content__form-title">Thông tin chi tiết size:</h5>

                        <div class="form__group">
                            <label for="product_size">Tên size</label>
                            <div class="form-control">
                                <select name="product_size">
                                <?php if (isset($product_size)): ?>
                                    <?php if ($product_size == 'M'): ?>
                                    <option value="">-- Chọn size --</option>
                                    <option value="M" selected>Size M</option>
                                    <option value="L">Size L</option>
                                    <?php elseif ($product_size === 'L'): ?>
                                    <option value="">-- Chọn size --</option>
                                    <option value="M">Size M</option>
                                    <option value="L" selected>Size L</option>
                                    <?php else: ?>
                                    <option value="">-- Chọn size --</option>
                                    <option value="M">Size M</option>
                                    <option value="L">Size L</option>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($sizeInfo['product_size'] == 'M'): ?>
                                    <option value="">-- Chọn size --</option>
                                    <option value="M" selected>Size M</option>
                                    <option value="L">Size L</option>
                                    <?php elseif ($sizeInfo['product_size'] === 'L'): ?>
                                    <option value="">-- Chọn size --</option>
                                    <option value="M">Size M</option>
                                    <option value="L" selected>Size L</option>
                                    <?php else: ?>
                                    <option value="">-- Chọn size --</option>
                                    <option value="M">Size M</option>
                                    <option value="L">Size L</option>
                                    <?php endif; ?>
                                <?php endif; ?>
                                </select>
                                <span class="form-message">
                                    <?=$errorMessage['product_size'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="giam_gia">Giá thêm</label>
                            <div class="form-control">
                                <input type="number" name="price_increase" placeholder="Nhập giá thêm" value="<?=$price_increase ?? $sizeInfo['price_increase'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['price_increase'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>

                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_update">Cập nhật size</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>