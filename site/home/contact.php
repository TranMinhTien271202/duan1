        <div class="content">
            <!-- contact -->
            <section class="content__contact-wrap">
                <div class="grid">
                    <h2 class="content__title content__contact-title">THÔNG TIN LIÊN HỆ</h2>
                    <div class="content__contact">
                        <div class="content__contact-item">
                            <div class="content__contact-item-info">
                                <section class="content__contact-heading">
                                    <h2 class="content__contact-item-title">Thông tin liên hệ</h2>
                                </section>

                                <ul class="content__contact-info-list">
                                    <li class="content__contact-info-item">
                                        <div class="content__contact-info-item-icon">
                                            <i class="fas fa-home"></i>
                                        </div>
                                        <?=$isWebsiteOpen['address'];?>
                                    </li>
                                    <li class="content__contact-info-item">
                                        <div class="content__contact-info-item-icon">
                                            <i class="fas fa-phone-alt"></i>
                                        </div>
                                        Hotline:
                                        <a href="tel:<?=$isWebsiteOpen['phone'];?>" class="content__contact-info-item-link">&nbsp;<?=$isWebsiteOpen['phone'];?></a>
                                    </li>
                                    <li class="content__contact-info-item">
                                        <div class="content__contact-info-item-icon">
                                            <i class="far fa-envelope"></i>
                                        </div>
                                        Email:
                                        <a href="mailto:<?=$isWebsiteOpen['email'];?>" class="content__contact-info-item-link">&nbsp;<?=$isWebsiteOpen['email'];?></a>
                                    </li>
                                    <li class="content__contact-info-item">
                                        <div class="content__contact-info-item-icon">
                                            <i class="fab fa-facebook-f"></i>
                                        </div>
                                        Facebook:
                                        <a href="<?=$isWebsiteOpen['facebook'];?>" class="content__contact-info-item-link">&nbsp;Tea House</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="content__contact-item-form">
                                <section class="content__contact-heading">
                                    <h2 class="content__contact-item-title">Liên hệ - Góp ý</h2>
                                </section>
                                <form action="" class="content__contact-item-form-inner" method="POST">
                                    
                                    <input type="text" class="content__contact-item-form-control" name="name" placeholder="Nhập tên của bạn" 
                                    value="<?=$contact['name'] ?? $_SESSION['user']['fullName'] ?? '';?>">
                                    <span class="content__contact-item-form-message">
                                        <?=$errorMessage['name'] ?? '';?>
                                    </span>

                                    <input type="text" class="content__contact-item-form-control" name="email" placeholder="Email của bạn"
                                    value="<?=$contact['email'] ?? $_SESSION['user']['email'] ?? '';?>">
                                    <span class="content__contact-item-form-message">
                                        <?=$errorMessage['email'] ?? '';?>
                                    </span>
                                    
                                    
                                    <input type="text" class="content__contact-item-form-control" name="phone" placeholder="Số điện thoại"
                                    value="<?=$contact['phone'] ?? $_SESSION['user']['phone'] ?? '';?>">
                                    <span class="content__contact-item-form-message">
                                        <?=$errorMessage['phone'] ?? '';?>
                                    </span>

                                    <textarea  rows="5" class="content__contact-item-form-control" name="content" placeholder="Nội dung"
                                    <?=$contact['content'] ?? '';?>
                                    ></textarea>
                                    <span class="content__contact-item-form-message">
                                        <?=$errorMessage['content'] ?? '';?>
                                    </span>
                                    
                                    <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>

                                    <button class="content__contact-item-form-btn" name="contact_insert">Gửi</button>
                                </form>
                                
                            </div>
                        </div>
                        <div class="content__contact-item">
                            <?=$isWebsiteOpen['map'];?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end contact -->
        </div>