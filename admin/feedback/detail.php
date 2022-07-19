<main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Feedback</h5>
                        <span class="content__header-description">Phản hồi khách hàng</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-reset">Nhập lại</button>
                        <a href="<?=$ADMIN_URL?>/feedback" class="content__header-item-btn">DS Feedback</a>
                    </div>
                </div>
            </header>

            <div class="content__home">
                <div class="content__home-wrap">
                    <form action="" class="content__form" method="POST">
                        <h5 class="content__form-title">Thông tin Feedback:</h5>
    
                        <div class="form__group">
                            <label for="name">Người gửi</label>
                            <div class="form-control disabled">
                                <input type="text" name="name" disabled value="<?=$feedbackInfo['name'] ?? '';?>">
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="content">Nội dung</label>
                            <div class="form-control">
                                <textarea name="content" disabled rows="3"><?=$feedbackInfo['content'] ?? '';?></textarea>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="content">Nội dung phản hồi</label>
                            <div class="form-control">
                                <textarea name="content_rep" rows="5" placeholder="Nhập nội dung phản hồi khách hàng"><?=$feedback['content_rep'] ?? '';?></textarea>
                                <span class="form-message">
                                    <?=$errorMessage['content_rep'] ?? '';?>
                                </span>
                            </div>
                        </div>
    
                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>
    
                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_rep_feedback">Gửi phản hồi</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>