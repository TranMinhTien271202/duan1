<main class="content">
    <header class="content__header-wrap">
        <div class="content__header">
            <div class="content__header-item">
                <h5 class="content__header-title content__header-title-has-separator">Bàn</h5>
                <span class="content__header-description">Cập nhật Bàn</span>
            </div>
            <div class="content__header-item">
                <button class="content__header-item-btn content__header-item-btn-reset">Nhập lại</button>
                <a href="<?= $ADMIN_URL . '/table'; ?>" class="content__header-item-btn">DS Bàn</a>
            </div>
        </div>
    </header>

    <div class="content__home">
        <div class="content__home-wrap">
            <form action="" class="content__form" method="POST">
                <h5 class="content__form-title">Thông tin bàn:</h5>
                <div class="form__group">
                    <label for="name">Tên bàn</label>
                    <div class="form-control">
                        <input type="text" name="name" placeholder="Nhập tên bàn" value="<?=$name ?? $tableInfo['name'];?>">
                        <span class="form-message">
                            <?= isset($errorMessage['name']) ? $errorMessage['name'] : ''; ?>
                        </span>
                    </div>
                </div>

                <div class="form__group">
                    <label for="guest_number">Số người / bàn</label>
                    <div class="form-control">
                        <input type="number" name="guest_number" placeholder="Số ghế" value="<?=$guest_number ?? $tableInfo['guest_number']; ?>">
                        <span class="form-message">
                            <?= isset($errorMessage['guest_number']) ? $errorMessage['guest_number'] : ''; ?>
                        </span>
                    </div>
                </div>

                <div class="form__group">
                    <label for="guest_number">Trạng thái</label>
                    <div class="form-control">
                    <select name="status" id="">
                                <option value="">-- Chọn Trạng thái bàn --</option>
                                <?php if(isset($status)): ?>
                                        <?php if($status): ?>
                                            <option value="0" selected>Còn trống</option>
                                            <option value="1">Có khach</option>
                                            <option value="2">Đã đặt trước</option>
                                        <?php elseif($status): ?>
                                            <option value="1" selected>Có khách</option>
                                            <option value="0">Còn trống</option>
                                            <option value="2">Đã đặt trước</option>
                                        <?php else:?>
                                            <option value="2" selected>Đã đặt trước</option>
                                            <option value="1">Có khách</option>
                                            <option value="0">Còn trống</option>
                                     <?php endif; ?>
                                    <?php elseif(isset($tableInfo['status'])): ?>
                                        <?php if($tableInfo['status']): ?>
                                            <option value="1" selected>Có khách</option>
                                            <option value="0">Còn trống</option>
                                            <option value="2">Đã đặt trước</option>

                                        <?php elseif($tableInfo['status']): ?>
                                            <option value="0" selected>Còn trống</option>
                                            <option value="1" >Có khách</option>
                                            <option value="2">Đã đặt trước</option>

                                        <?php else:?>
                                            <option value="2" selected>Đã đặt trước</option>
                                            <option value="1">Có khách</option>
                                            <option value="0">Còn trống</option>  
                                    <?php endif; ?>
                                    <?php else: ?>
                                        <?php if($tableInfo['status']): ?>
                                        <option value="2" selected>Đã đặt trước</option>
                                            <option value="1">Có khách</option>
                                            <option value="0">Còn trống</option>

                                        <?php elseif($tableInfo['status']): ?>
                                            <option value="1" selected>Có khách</option>
                                            <option value="0" >Còn trống</option>
                                            <option value="2">Đã đặt trước</option>

                                        <?php else:?>
                                            <option value="0" selected>Còn trống</option>
                                            <option value="1">Có khách</option>
                                            <option value="2">Đã đặt trước</option>  
                                    <?php endif; ?>
                                    <?php endif;?>
                    </select>
                    <span class="form-message">
                            <?= isset($errorMessage['status']) ? $errorMessage['status'] : ''; ?>
                        </span>
                    </div>
                </div>


                <?= isset($MESSAGE) ? '<div class="alert alert-success">' . $MESSAGE . '</div>' : ''; ?>


                <div class="form__group form__btn-submit">
                    <button type="submit" name="btn_update">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</main>