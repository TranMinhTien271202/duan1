        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Voucher</h5>
                        <span class="content__header-description">Thêm mới Voucher</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-reset">Nhập lại</button>
                        <a href="<?=$ADMIN_URL;?>/voucher" class="content__header-item-btn">DS Voucher</a>
                    </div>
                </div>
            </header>

            <div class="content__home">
                <div class="content__home-wrap">
                    <form action="" class="content__form" method="POST">
                        <h5 class="content__form-title">Thông tin chi tiết voucher:</h5>
    
                        <div class="form__group">
                            <label for="code">Mã Voucher</label>
                            <div class="form-control">
                                <input type="text" name="code" placeholder="Nhập mã Voucher" value="<?=$voucher['code'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['code'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="quantity">Số lượng sử dụng Voucher</label>
                            <div class="form-control">
                                <input type="number" name="quantity" placeholder="Nhập số lượng" value="<?=$voucher['quantity'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['quantity'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="condition">Giảm theo</label>
                            <div class="form-control">
                                <select name="condition" id="">
                                    <option value="">-- Chọn loại giảm --</option>
                                    <option value="0" <?=isset($voucher['condition']) && $voucher['condition'] === '0' ? 'selected' : '';?> >Phần trăm</option>
                                    <option value="1" <?=isset($voucher['condition']) && $voucher['condition'] ? 'selected' : '';?> >Tiền</option>
                                </select>
                                <span class="form-message">
                                    <?=$errorMessage['condition'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="voucher_number">Nhập số % hoặc tiền giảm</label>
                            <div class="form-control">
                                <input type="number" name="voucher_number" placeholder="Nhập mức giảm" value="<?=$voucher['voucher_number'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['voucher_number'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="time_start">Thời gian có hiệu lực</label>
                            <div class="form-control">
                                <input type="datetime-local" name="time_start" value="<?=$voucher['time_start'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['time_start'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="time_end">Thời gian hết hiệu lực</label>
                            <div class="form-control">
                                <input type="datetime-local" name="time_end" value="<?=$voucher['time_end'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['time_end'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="status">Trạng thái</label>
                            <div class="form-control">
                                <select name="status" id="">
                                    <option value="">-- Vui lòng chọn trạng thái VC --</option>
                                    <option value="1" <?=isset($voucher['status']) && $voucher['status'] ? 'selected' : '';?> >Kích hoạt</option>
                                    <option value="0" <?=isset($voucher['status']) && $voucher['status'] === '0' ? 'selected' : '';?> >Khóa</option>
                                </select>
                                <span class="form-message">
                                    <?=$errorMessage['status'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>

                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_insert">Thêm Voucher</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>