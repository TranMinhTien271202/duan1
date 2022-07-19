<main class="content">
    <header class="content__header-wrap">
        <div class="content__header">
            <div class="content__header-item">
                <h5 class="content__header-title content__header-title-has-separator">Bàn</h5>
                <span class="content__header-description">Thêm mới Bàn</span>
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
                        <input type="text" name="name" placeholder="Nhập tên bàn" value="<?=$table['name'] ?? ''; ?>">
                        <span class="form-message">
                            <?= isset($errorMessage['name']) ? $errorMessage['name'] : ''; ?>
                        </span>
                    </div>
                </div>

                <div class="form__group">
                    <label for="guest_number">Số người / bàn</label>
                    <div class="form-control">
                        <input type="number" name="guest_number" placeholder="Số ghế" value="<?=$table['guest_number'] ?? ''; ?>">
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
                                    <option value="0" <?=isset($table['status']) === '0' ? : '';?> >Còn trống</option>
                                    <option value="1" <?=isset($table['status']) === '1' ? : '';?> >Đã có khách</option>
                                    <option value="2" <?=isset($table['status']) === '2' ?  : '';?> >Đã đặt trước</option>
                    </select>
                    <span class="form-message">
                            <?= isset($errorMessage['status']) ? $errorMessage['status'] : ''; ?>
                        </span>
                    </div>
                </div>


                <?= isset($MESSAGE) ? '<div class="alert alert-success">' . $MESSAGE . '</div>' : ''; ?>


                <div class="form__group form__btn-submit">
                    <button type="submit" name="btn_insert">Thêm Bàn</button>
                </div>
            </form>
        </div>
    </div>
</main>