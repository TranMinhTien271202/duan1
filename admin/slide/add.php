<main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Slider</h5>
                        <span class="content__header-description">Thêm mới slide</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-reset">Nhập lại</button>
                        <a href="<?=$ADMIN_URL?>/slide" class="content__header-item-btn">DS Slide</a>
                    </div>
                </div>
            </header>

            <div class="content__home">
                <div class="content__home-wrap">
                    <form action="" class="content__form" method="POST" enctype="multipart/form-data">
                        <h5 class="content__form-title">Thông tin slide:</h5>
    
                        <div class="form__group">
                            <label for="ten_slide">Tên slide</label>
                            <div class="form-control">
                                <input type="text" name="title" placeholder="Nhập tên slide" value="<?=$slide['title'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['title'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="url">Url slide</label>
                            <div class="form-control">
                                <input type="text" name="url" placeholder="Nhập đường dẫn slide" value="<?=$slide['url'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['url'] ?? '';?>
                                </span>
                            </div>
                        </div>
    
                        <div class="form__group">
                            <label for="hinh_anh">Ảnh slide</label>
                            <div class="form-control">
                                <input type="file" name="slide_image" accept="image/*" onchange="preImage(event);">
                            </div>
                        </div>

                        <div class="form__group hide">
                            <label for="avatar">Xem trước ảnh slide</label>
                            <div class="form-image-box">
                                <img src="./assets/images/profile.png" alt="">
                            </div>
                        </div>
    
                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>
    
                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_insert">Thêm slide</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>