        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Voucher</h5>
                        <span class="content__header-description">Cập nhật Voucher</span>
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
                                <input type="text" name="code" placeholder="Nhập mã Voucher" value="<?=$voucher['code'] ?? $voucherInfo['code'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['code'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="quantity">Số lượng sử dụng Voucher</label>
                            <div class="form-control">
                                <input type="number" name="quantity" placeholder="Nhập số lượng" value="<?=$voucher['quantity'] ?? $voucherInfo['quantity'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['quantity'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="condition">Loại hàng</label>
                            <div class="form-control">
                                <select name="condition" id="">
                                    <option value="">-- Vui lòng chọn loại giảm --</option>
                                    <?php if(isset($condition)): ?>
                                        <?php if($condition): ?>
                                            <option value="0">Giảm theo %</option>
                                            <option value="1" selected>Giảm theo tiền</option>
                                        <?php else: ?>
                                            <option value="0" selected>Giảm theo %</option>
                                            <option value="1">Giảm theo tiền</option>
                                        <?php endif; ?>
                                    <?php elseif(isset($voucherInfo['condition'])): ?>
                                        <?php if($voucherInfo['condition']): ?>
                                            <option value="0">Giảm theo %</option>
                                            <option value="1" selected>Giảm theo tiền</option>
                                        <?php else: ?>
                                            <option value="0" selected>Giảm theo %</option>
                                            <option value="1">Giảm theo tiền</option>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </select>
                                <span class="form-message">
                                    <?=$errorMessage['condition'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="voucher_number">Nhập số % hoặc tiền giảm</label>
                            <div class="form-control">
                                <input type="number" name="voucher_number" placeholder="Nhập mức giảm" value="<?=$voucher['voucher_number'] ?? $voucherInfo['voucher_number'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['voucher_number'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="time_start">Thời gian có hiệu lực</label>
                            <div class="form-control">
                                <input type="datetime-local" name="time_start" value="<?=$voucher['time_start'] ?? date('Y-m-d\TH:i', strtotime($voucherInfo['time_start']));?>">
                                <span class="form-message">
                                    <?=$errorMessage['time_start'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="time_end">Thời gian hết hiệu lực</label>
                            <div class="form-control">
                                <input type="datetime-local" name="time_end" value="<?=$voucher['time_end'] ?? date('Y-m-d\TH:i', strtotime($voucherInfo['time_end']));?>">
                                <span class="form-message">
                                    <?=$errorMessage['time_end'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="status">Loại hàng</label>
                            <div class="form-control">
                                <select name="status" id="">
                                    <option value="">-- Vui lòng chọn trạng thái VC --</option>
                                    <?php if(isset($status)): ?>
                                        <?php if($status): ?>
                                            <option value="1" selected>Kích hoạt</option>
                                            <option value="0">Khóa</option>
                                        <?php else: ?>
                                            <option value="0" selected>Khóa</option>
                                            <option value="1">Kích hoạt</option>
                                        <?php endif; ?>
                                    <?php elseif(isset($voucherInfo['status'])): ?>
                                        <?php if($voucherInfo['status']): ?>
                                            <option value="1" selected>Kích hoạt</option>
                                            <option value="0">Khóa</option>
                                        <?php else: ?>
                                            <option value="1">Kích hoạt</option>
                                            <option value="0" selected>Khóa</option>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </select>
                                <span class="form-message">
                                    <?=$errorMessage['status'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>

                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_update">Update Voucher</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>