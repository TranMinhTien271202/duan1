        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Size</h5>
                        <span class="content__header-description">Thêm size</span>
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
                            <label for="ten_hh">Tên size</label>
                            <div class="form-control">
                                <select name="product_size">
                                    <option value="">Chọn Size</option>
                                    <option value="M" <?=isset($size['product_size']) && $size['product_size'] == 'M' ? 'selected' : '';?> >Size M</option>
                                    <option value="L" <?=isset($size['product_size']) && $size['product_size'] == 'L' ? 'selected' : '';?> >Size L</option>
                                </select>
                                <span class="form-message">
                                    <?=$errorMessage['product_size'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="giam_gia">Giá thêm</label>
                            <div class="form-control">
                                <input type="number" name="price_increase" placeholder="Nhập giá thêm" value="<?=$size['price_increase'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['price_increase'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>

                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_insert">Thêm size</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>