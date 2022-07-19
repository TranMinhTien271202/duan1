        <!-- CONTENT -->
        <div class="content">
            <!-- slider -->
            <section class="slider">
                <ul class="slider__list">
                    <?php foreach ($listSlide as $item): ?>
                    <li class="slider__list-item">
                        <a href="<?=$item['url'];?>" href="<?=$item['title'];?>" target="_blank" class="slider__list-item-link" style="background-image: url('<?=$IMG_URL . '/' . $item['slide_image'];?>')"></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <!-- end slider -->

            <!-- category -->
            <section class="content__cate grid">
                <h2 class="content__title">Danh mục sản phẩm</h2>

                <ul class="content__cate-list">
                <?php foreach ($categoryInfo as $cate): ?>
                    <li class="content__cate-item">
                        <a href="<?=$SITE_URL . '/product/?category&cate_id=' . $cate['id'];?>" class="content__cate-item-link">
                            <img src="<?=$IMG_URL . '/' . $cate['cate_image'];?>" alt="" class="content__cate-img">

                            <div class="content__cate-item-info">
                                <h5 class="content__cate-item-info-name"><?=$cate['cate_name'];?></h5>
                                <span class="content__cate-item-info-qnt"><?=$cate['totalProduct'];?> sản phẩm</span>
                            </div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <!-- end category -->

            <!-- about -->
            <section class="content__about-wrap">
                <div class="grid">
                    <div class="content__about">
                        <div class="content__about-item">
                            <h2 class="content__title">TẠI SAO CHỌN CHÚNG TÔI</h2>
                            <p class="content__about-item-desc">
                                Với những nghệ nhân rang tâm huyết và đội ngũ tài năng cùng những
                                câu chuyện trà đầy cảm hứng, ngôi nhà Tea House là không gian dành
                                riêng cho những ai trót yêu say đắm hương vị của những lá trà tuyệt hảo.
                            </p>

                            <ul class="content__about-item-list">
                                <li class="content__about-item-list-item">
                                    <div class="content__about-item-list-item-icon">
                                        <img src="<?=$SITE_URL;?>/assets/images/why/icon_why_1.png" alt="" class="content__about-item-list-item-img">
                                    </div>
                                    <div class="content__about-item-list-item-text">
                                        <h3 class="content__about-item-list-item-title">Giá cả phải chăng</h3>
                                        <p class="content__about-item-list-item-desc">Cam kết chỉ cung cấp trà nguồn gốc được kiểm soát chất lượng</p>
                                    </div>
                                </li>
                                <li class="content__about-item-list-item">
                                    <div class="content__about-item-list-item-icon">
                                        <img src="<?=$SITE_URL;?>/assets/images/why/icon_why_2.png" alt="" class="content__about-item-list-item-img">
                                    </div>
                                    <div class="content__about-item-list-item-text">
                                        <h3 class="content__about-item-list-item-title">Hương vị tuyệt hảo</h3>
                                        <p class="content__about-item-list-item-desc">Những đợt trà được lựa chọn cẩn thận ngay từ lúc đang ngâm mình trong sương</p>
                                    </div>
                                </li>
                                <li class="content__about-item-list-item">
                                    <div class="content__about-item-list-item-icon">
                                        <img src="<?=$SITE_URL;?>/assets/images/why/icon_why_3.png" alt="" class="content__about-item-list-item-img">
                                    </div>
                                    <div class="content__about-item-list-item-text">
                                        <h3 class="content__about-item-list-item-title">Sản phẩm tự nhiên</h3>
                                        <p class="content__about-item-list-item-desc">Cam kết chỉ cung cấp lá trà có nguồn gốc được kiểm soát chất lượng chặt</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="content__about-item"></div>
                    </div>
                </div>
            </section>
            <!-- end about -->

            <!-- menu -->
            <section class="content__menu-wrap">
                <div class="grid">
                    <h2 class="content__title">MENU HÔM NAY</h2>
                    <div class="content__menu">
                        <?php foreach ($listProduct as $item): ?>
                        <div class="content__menu-item">
                            <div class="content__menu-item-image">
                                <a href="<?=$SITE_URL . '/product/?detail&id=' . $item['id'];?>" class="content__menu-item-image-link" style="background-image: url('<?=$IMG_URL . '/' . $item['product_image'];?>')"></a>
                                <a href="<?=$SITE_URL . '/product/?detail&id=' . $item['id'];?>" class="content__menu-item-btn">Xem chi tiết</a>
                                <?php
                                    // kiểm tra sp yêu thích
                                    $isProductFavorite = false;
                                    if (isset($_SESSION['user']['id']) && favorite_exits($_SESSION['user']['id'], $item['id'])) {
                                        $isProductFavorite = true;
                                    }
                                ?>
                                <button class="content__menu-item-icon content__menu-item-icon-heart <?=$isProductFavorite ? 'heart-active' : '';?>" data-id="<?=$item['id'];?>">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <!-- <a href="<?=$SITE_URL . '/cart/?add_cart&id=' . $item['id'];?>" class="content__menu-item-icon content__menu-item-icon-cart">
                                    <i class="fas fa-shopping-basket"></i>
                                </a> -->
                            </div>
                            <div class="content__menu-item-info">
                                <p class="content__menu-item-info-name">
                                    <a href="<?=$SITE_URL . '/product/?detail&id=' . $item['id'];?>" class="content__menu-item-info-name-link"><?=$item['product_name'];?></a>
                                </p>
                                <span class="content__menu-item-info-price"><?=number_format($item['price'], 0, '', ',');?> ₫</span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <!-- end menu -->

            <!-- time open -->
            <section class="content__time-wrap">
                <div class="grid">
                    <div class="content__time">
                        <div class="content__time-text">
                            <h2 class="content__time-text-title">THỜI GIAN MỞ CỬA</h2>
                            <p class="content__time-text-desc">
                                “Trà chanh nhé” – Một lời hẹn rất riêng của người Việt.
                                Một lời ngỏ mộc mạc để mình ngồi lại bên nhau và sẻ chia câu chuyện của riêng mình.
                            </p>
                            <p class="content__time-text-desc">T2 – T6: 7h00 – 22h00</p>
                            <p class="content__time-text-desc">T7 – CN: 8h00 – 21h00</p>

                            <a href="<?=$SITE_URL;?>/home?order" class="content__time-text-btn">Đặt bàn ngay</a>
                        </div>
                        <div class="content__time-image-wrap">
                            <div class="content__time-image"></div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end time open -->

            <!-- feedback -->
            <section class="content__feedback-wrap">
                <div class="grid">
                    <div class="content__feedback">
                        <h2 class="content__title content__feedback-title">KHÁCH HÀNG NÓI GÌ</h2>
                        <span class="content__feedback-title-text">1500+ KHÁCH HÀNG HÀI LÒNG</span>
                    </div>
                </div>

                <ul class="content__feedback-list">
                    <li class="content__feedback-item">
                        <div class="grid">
                            <div class="content__feedback-item-avatar">
                                <img src="<?=$SITE_URL;?>/assets/images/feedback/Tuan_demo.jpg"  alt="" class="content__feedback-item-img">
                            </div>
    
                            <ul class="content__feedback-item-star-list">
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                            </ul>
    
                            <h3 class="content__feedback-item-name">Lê Văn Tuân</h3>
                            <p class="content__feedback-item-content">
                                Mình rất thích đưa khách hàng của mình đến đây bởi vì
                                phong cách rất chuyên nghiệp.Hơn nữa thức uống ở đây rất ngon,
                                có hương vị rất khác biệt, các vị khách của mình vô cùng thích.
                            </p>
                        </div>
                    </li>

                    <li class="content__feedback-item">
                        <div class="grid">
                            <div class="content__feedback-item-avatar">
                                <img src="<?=$SITE_URL;?>/assets/images/feedback/Corny_hung.jpg" alt="" class="content__feedback-item-img">
                            </div>
    
                            <ul class="content__feedback-item-star-list">
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                            </ul>
    
                            <h3 class="content__feedback-item-name">Ngô Sỹ Hùng</h3>
                            <p class="content__feedback-item-content">
                            Nếu như muốn được thư giãn hãy nghe một bản nhạc.
                            Nếu muốn tìm một hương vị trà chanh đúng gu nhất với mình thì hãy đến với Tea House.
                            Nơi luôn khiến mình hài lòng nhất.
                            </p>
                        </div>
                    </li>

                    <li class="content__feedback-item">
                        <div class="grid">
                            <div class="content__feedback-item-avatar">
                                <img src="<?=$SITE_URL;?>/assets/images/feedback/quyen.jpg"  alt="" class="content__feedback-item-img">
                            </div>
    
                            <ul class="content__feedback-item-star-list">
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="content__feedback-item-star">
                                    <i class="fas fa-star"></i>
                                </li>
                            </ul>
    
                            <h3 class="content__feedback-item-name">Ngô Duy Quyền</h3>
                            <p class="content__feedback-item-content">
                                Không gian được thiết kế quá tuyệt vời luôn giúp mình có nhiều idea và cảm hứng để mình sáng tạo.
                                Hơn nữa chất lượng đồ uống ở đây vô cùng vừa ý mình, Tea House là sự lựa chọn tuyệt vời.
                            </p>
                        </div>
                    </li>
                </ul>
            </section>
            <!-- end feedback -->

            <!-- news -->
            <section class="content__news-wrap">
                <div class="grid">
                    <h2 class="content__title content__news-title">TIN TỨC NỔI BẬT</h2>
                    <div class="content__news">
                        <a href="" class="content__news-item">
                            <div class="content__news-item-img" style="background-image: url(<?=$SITE_URL;?>/assets/images/news/pcoffe_1_r1_slide_best_coffee_img_1-1.jpg);"></div>
                            <div class="content__news-item-info">
                                <h5 class="content__news-item-info-name">CHẾ BIẾN CÀ PHÊ</h5>
                                <p class="content__news-item-info-desc">
                                    Cà phê sạch hiểu đơn giản là 100% cà phê,
                                    không pha trộn thêm bất cứ thứ gì khác.
                                    Vậy quy trình sản xuất chế biến cà phê sạch như...					
                                </p>
                            </div>
                        </a>
                        <a href="" class="content__news-item">
                            <div class="content__news-item-img" style="background-image: url(<?=$SITE_URL;?>/assets/images/news/blog-2_large.jpg);"></div>
                            <div class="content__news-item-info">
                                <h5 class="content__news-item-info-name">COFFEE THỔ NHĨ KỲ</h5>
                                <p class="content__news-item-info-desc">
                                    Cà phê Thổ Nhĩ Kỳ có một phong cách pha chế rất quyến rũ
                                    và nghệ thuật thưởng thức thú vị. Cà phê ở đất nước này không chỉ là...								
                                </p>
                            </div>
                        </a>
                        <a href="" class="content__news-item">
                            <div class="content__news-item-img" style="background-image: url(<?=$SITE_URL;?>/assets/images/news/blog1_large.jpg);"></div>
                            <div class="content__news-item-info">
                                <h5 class="content__news-item-info-name">ĐẲNG CẤP QUA CỐC CÀ PHÊ</h5>
                                <p class="content__news-item-info-desc">
                                    Uống cà phê thì dễ, thưởng thức cà phê mới khó.
                                    Muốn cảm nhận được toàn bộ hương vị của cà phê, không những phải chú ý đến hạt cà phê,...					
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
            <!-- end news -->

            <!-- slide bottom -->
            <section class="content__slider-bottom">
                <div class="content__slider-bottom-item">
                    <a href="" class="content__slider-bottom-item-img" style="background-image: url(<?=$SITE_URL;?>/assets/images/slider/picture_1.jpg)"></a>
                </div>
                <div class="content__slider-bottom-item">
                    <a href="" class="content__slider-bottom-item-img" style="background-image: url(<?=$SITE_URL;?>/assets/images/slider/picture_2.jpg)"></a>
                </div>
                <div class="content__slider-bottom-item">
                    <a href="" class="content__slider-bottom-item-img" style="background-image: url(<?=$SITE_URL;?>/assets/images/slider/picture_3.jpg)"></a>
                </div>
                <div class="content__slider-bottom-item">
                    <a href="" class="content__slider-bottom-item-img" style="background-image: url(<?=$SITE_URL;?>/assets/images/slider/picture_4.jpg)"></a>
                </div>
                <div class="content__slider-bottom-item">
                    <a href="" class="content__slider-bottom-item-img" style="background-image: url(<?=$SITE_URL;?>/assets/images/slider/picture_5.jpg)"></a>
                </div>
                <div class="content__slider-bottom-item">
                    <a href="" class="content__slider-bottom-item-img" style="background-image: url(<?=$SITE_URL;?>/assets/images/slider/untitled-1.jpg)"></a>
                </div>
                <div class="content__slider-bottom-item">
                    <a href="" class="content__slider-bottom-item-img" style="background-image: url(<?=$SITE_URL;?>/assets/images/slider/untitled-3.jpg)"></a>
                </div>
            </section>
            <!-- end slide bottom -->
        </div>
        <!-- END CONTENT -->