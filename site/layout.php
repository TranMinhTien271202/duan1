<?php

    require_once '../../dao/settings.php';
    $infoWeb = settings_select_all();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $mainTitle = !empty($infoWeb) ? $infoWeb['title'] : '';?>
    <title><?=(isset($titlePage) ? $titlePage . ' - ' : '') . $mainTitle;?></title>
    <link rel="shortcut icon" href="<?=$IMG_URL;?>/favicon.png" type="image/x-icon">
    <!-- SLICK SLIDER -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?=$SITE_URL;?>/assets/css/main.css">
    <link rel="stylesheet" href="<?=$SITE_URL;?>/assets/css/responsive.css">
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FACEBOOK PLUGIN -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0&appId=604378676721357&autoLogAppEvents=1" nonce="DlEKS6YV"></script>
    <!-- JQUERY AJAX -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- TOASTR -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <header class="header">
            <div class="header__top-wrap hide-on-mobile-tablet">
                <div class="header__top grid">
                    <ul class="header__top-list">
                        <li class="header__top-list-item header__top-list-item--separator">
                            <a href="mailto:<?=!empty($infoWeb) ? $infoWeb['email'] : '';?>" class="header__top-list-item-link">
                                <div class="header__top-list-item-icon">
                                    <i class="far fa-envelope"></i>
                                </div>
                                CONTACT
                            </a>
                        </li>
                        <li class="header__top-list-item header__top-list-item--separator">
                            <div class="header__top-list-item-link">
                                <div class="header__top-list-item-icon">
                                    <i class="far fa-clock"></i>
                                </div>
                                08:00 - 17:00
                            </d>
                        </li>
                        <li class="header__top-list-item">
                            <a href="tel:<?=!empty($infoWeb) ? $infoWeb['phone'] : '';?>" class="header__top-list-item-link">
                                <div class="header__top-list-item-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <?=!empty($infoWeb) ? $infoWeb['phone'] : '';?>
                            </a>
                        </li>
                    </ul>

                    <ul class="header__top-list">
                        <li class="header__top-list-item header__top-list-item--separator">
                            <div class="header__top-list-item-search">
                                <div class="header__top-list-item-icon header__top-list-item-icon-size-M">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>

                            <form class="header__top-list-item-form" method="GET" action="<?=$SITE_URL . '/product/?search';?>">
                                <input type="text" name="keyword" class="header__top-list-item-form-control input" placeholder="Tìm kiếm...">
                                <button class="header__top-list-item-form-btn btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </li>

                        <?php if (isset($_SESSION['user'])): ?>
                            <?php if ($_SESSION['user']['role']): ?>
                            <li class="header__top-list-item header__top-list-item--separator">
                                Xin chào,
                                <a href="<?=$ADMIN_URL;?>" class="header__top-list-item-link"><?=$_SESSION['user']['fullName'];?></a>
                            </li>
                            <?php else: ?>
                            <li class="header__top-list-item header__top-list-item--separator">
                                Xin chào,
                                <a href="<?=$SITE_URL;?>/my-account" class="header__top-list-item-link"><?=$_SESSION['user']['fullName'];?></a>
                            </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="header__top-list-item header__top-list-item--separator">
                                <a href="<?=$SITE_URL;?>/account" class="header__top-list-item-link">Đăng nhập</a>
                            </li>
                            <li class="header__top-list-item header__top-list-item--separator">
                                <a href="<?=$SITE_URL;?>/account/?register" class="header__top-list-item-link">Đăng ký</a>
                            </li>
                        <?php endif; ?>

                        <li class="header__top-list-item header__top-list-item-heart">
                            <label for="" class="header__top-list-item-heart-label">0</label>
                            <div class="header__top-list-item-icon header__top-list-item-icon-size-M header__top-list-item-icon-heart">
                                <i class="fas fa-heart"></i>
                            </div>
                        </li>
                        <li class="header__top-list-item">
                            <label for="" class="header__top-list-item-cart-label">0</label>
                            <a href="<?=$SITE_URL;?>/cart" class="header__top-list-item-icon header__top-list-item-icon-size-M">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="header__menu-wrap">
                <div class="grid">
                    <div class="header__menu">
                        <!-- icon bar -->
                        <div class="header__menu-mobile-icon-bar">
                            <div class="header__menu-mobile-icon">
                                <i class="fas fa-bars"></i>
                            </div>
                        </div>

                        <ul class="header__menu-list hide-on-mobile-tablet">
                            <li class="header__menu-list-item <?=isset($active) && $active == 'index' ? 'header__menu-list-item--active' : '';?>">
                                <a href="<?=$SITE_URL;?>" class="header__menu-list-item-link">Trang chủ</a>
                            </li>
                            <li class="header__menu-list-item <?=isset($active) && $active == 'intro' ? 'header__menu-list-item--active' : '';?>">
                                <a href="<?=$SITE_URL;?>/home/?intro" class="header__menu-list-item-link">Giới thiệu</a>
                            </li>
                            <li class="header__menu-list-item <?=isset($active) && $active == 'product' ? 'header__menu-list-item--active' : '';?>">
                                <a href="<?=$SITE_URL;?>/product" class="header__menu-list-item-link">Thực đơn</a>
                            </li>
                        </ul>
        
                        <a href="<?=$SITE_URL;?>" class="header__menu-logo-link">
                            <img src="<?=!empty($infoWeb) ? $IMG_URL . '/' . $infoWeb['logo'] : '';?>" alt="Logo" class="header__menu-logo">
                        </a>
        
                        <ul class="header__menu-list hide-on-mobile-tablet">
                            <li class="header__menu-list-item <?=isset($active) && $active == 'news' ? 'header__menu-list-item--active' : '';?>">
                                <a href="#" class="header__menu-list-item-link">Tin tức</a>
                            </li>
                            <li class="header__menu-list-item <?=isset($active) && $active == 'contact' ? 'header__menu-list-item--active' : '';?>">
                                <a href="<?=$SITE_URL;?>/home/?contact" class="header__menu-list-item-link">Liên hệ</a>
                            </li>
                            <li class="header__menu-list-item <?=isset($active) && $active == 'order' ? 'header__menu-list-item--active' : '';?>">
                                <a href="<?=$SITE_URL;?>/home/?order" class="header__menu-list-item-link">Đặt bàn</a>
                            </li>
                        </ul>
    
                        <!-- icon wishlist + cart -->
                        <ul class="header__menu-mobile-icon-list">
                            <li class="header__menu-mobile-icon header__top-list-item-heart">
                                <label for="" class="header__menu-mobile-icon-label header__menu-mobile-icon-heart">0</label>
                                <i class="fas fa-heart"></i>
                            </li>
                            <li class="header__menu-mobile-icon">
                                <label for="" class="header__menu-mobile-icon-label header__menu-mobile-icon-cart">0</label>
                                <a href="<?=$SITE_URL;?>/cart" class="header__menu-mobile-icon-link">
                                    <i class="fas fa-shopping-basket"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- menu mobile -->
            <section class="menu__mobile">
                <div class="menu__mobile-overlay"></div>

                <div class="menu__mobile-inner">
                    <ul class="menu__mobile-list">
                        <li class="menu__mobile-item menu__mobile-item-search">
                            <form action="<?=$SITE_URL . '/product/?keyword';?>" class="menu__mobile-item-form">
                                <input type="text" name="keyword" class="menu__mobile-item-form-control input" placeholder="Tìm kiếm...">
                                <button class="menu__mobile-item-form-btn btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </li>

                        <li class="menu__mobile-item">
                            <a href="<?=$SITE_URL;?>" class="menu__mobile-item-link">Trang chủ</a>
                        </li>
                        <li class="menu__mobile-item">
                            <a href="<?=$SITE_URL;?>/home?intro" class="menu__mobile-item-link">Giới thiệu</a>
                        </li>
                        <li class="menu__mobile-item">
                            <a href="<?=$SITE_URL;?>/product" class="menu__mobile-item-link">Thực đơn</a>
                        </li>
                        <!-- <li class="menu__mobile-item">
                            <a href="#" class="menu__mobile-item-link">Tin tức</a>
                        </li> -->
                        <li class="menu__mobile-item">
                            <a href="<?=$SITE_URL;?>/home?contact" class="menu__mobile-item-link">Liên hệ</a>
                        </li>
                        <li class="menu__mobile-item">
                            <a href="<?=$SITE_URL;?>/home?order" class="menu__mobile-item-link">Đặt bàn</a>
                        </li>

                        <?php if (isset($_SESSION['user'])): ?>
                            <?php if ($_SESSION['user']['role']): ?>
                            <li class="menu__mobile-item">
                                <a href="<?=$ADMIN_URL;?>" class="menu__mobile-item-link">
                                    Xin chào, <?=$_SESSION['user']['fullName'];?>
                                </a>
                            </li>
                            <?php else: ?>
                            <li class="menu__mobile-item">
                                <a href="<?=$SITE_URL;?>/my-account" class="menu__mobile-item-link">
                                    Xin chào, <?=$_SESSION['user']['fullName'];?>
                                </a>
                            </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="menu__mobile-item">
                                <a href="<?=$SITE_URL;?>/account" class="menu__mobile-item-link">Đăng nhập</a>
                            </li>
                            <li class="menu__mobile-item">
                                <a href="<?=$SITE_URL;?>/account/?register" class="menu__mobile-item-link">Đăng ký</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="menu__mobile-btn-close">
                    <i class="fas fa-times"></i>
                </div>
            </section>
            <!-- end menu mobile -->

            <!-- danh sách yêu thích -->
            <section class="wishlist">
                <div class="wishlist__overlay"></div>
    
                <div class="wishlist__content">
                    <header class="wishlist__header">
                        <h2 class="wishlist__header-title">Danh sách yêu thích</h2>
                        <button class="wishlist__header-icon">
                            <i class="fas fa-times"></i>
                        </button>
                    </header>
    
                    <div class="wishlist__body">
                        <ul class="wishlist__body-list">
                            
                        </ul>
                    </div>
                </div>
            </section>
            <!-- danh sách yêu thích -->
        </header>
        <!-- END HEADER -->

        <?php include_once $VIEW_PAGE;?>

        <!-- FOOTER -->
        <footer class="footer__wrap">
            <div class="grid">
                <div class="footer">
                    <div class="footer__item">
                        <h3 class="footer__item-title">KẾT NỐI VỚI CHÚNG TÔI</h3>
                        <p class="footer__item-desc">
                            Chúng tôi mong muốn tạo nên hương vị thức uống tuyệt vời nhất.
                            Là điểm đến đầu tiên dành cho bạn khi muốn thưởng thức trọn vẹn của tách Coffee
                        </p>

                        <ul class="footer__item-icon-list">
                            <li class="footer__item-icon-item">
                                <a href="<?=!empty($infoWeb) ? $infoWeb['facebook'] : '';?>" target="_blank" class="footer__item-icon-item-link">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li class="footer__item-icon-item">
                                <a href="<?=!empty($infoWeb) ? $infoWeb['instagram'] : '';?>" target="_blank" class="footer__item-icon-item-link">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li class="footer__item-icon-item">
                                <a href="<?=!empty($infoWeb) ? $infoWeb['tiktok'] : '';?>" target="_blank" class="footer__item-icon-item-link">
                                    <i class="fab fa-tiktok"></i>
                                </a>
                            </li>
                            <li class="footer__item-icon-item">
                                <a href="<?=!empty($infoWeb) ? $infoWeb['youtube'] : '';?>" target="_blank" class="footer__item-icon-item-link">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="footer__item">
                        <h3 class="footer__item-title">LIÊN HỆ</h3>

                        <ul class="footer__item-list">
                            <li class="footer__item-list-item">
                                <div class="footer__item-list-item-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <?=!empty($infoWeb) ? $infoWeb['address'] : '';?>
                            </li>
                            <li class="footer__item-list-item">
                                <div class="footer__item-list-item-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                Hotline: <a href="tel:<?=!empty($infoWeb) ? $infoWeb['phone'] : '';?>" class="footer__item-list-item-link" target="_blank">&nbsp;<?=!empty($infoWeb) ? $infoWeb['phone'] : '';?></a>
                            </li>
                            <li class="footer__item-list-item">
                                <div class="footer__item-list-item-icon">
                                    <i class="far fa-envelope"></i>
                                </div>
                                Email: <a href="mailto:<?=!empty($infoWeb) ? $infoWeb['email'] : '';?>" class="footer__item-list-item-link" target="_blank">&nbsp;<?=!empty($infoWeb) ? $infoWeb['email'] : '';?></a>
                            </li>
                            <li class="footer__item-list-item">
                                <div class="footer__item-list-item-icon">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                                Facebook: <a href="" class="footer__item-list-item-link" target="_blank">&nbsp;Tea House</a>
                            </li>
                        </ul>
                    </div>

                    <div class="footer__item">
                        <h3 class="footer__item-title">FANPAGE</h3>
                        <div class="fb-page" data-href="https://www.facebook.com/fpt.poly" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                            <blockquote cite="https://www.facebook.com/fpt.poly" class="fb-xfbml-parse-ignore">
                                <a href="https://www.facebook.com/fpt.poly">Cao đẳng FPT Polytechnic</a>
                            </blockquote>
                        </div>
                    </div>
                </div>

                <span class="footer__copyright">Copyright 2021 © <strong>Bản quyền thuộc về Fpoly</strong></span>
            </div>

            <!-- btn scrolltop -->
            <div class="btn-scrollTop">
                <i class="fas fa-chevron-up"></i>
            </div>
        </footer>
        <!-- END FOOTER -->

        <!-- JS -->
        <!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script> -->
        <!-- <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script> -->
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <!-- TOASTR -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="<?=$SITE_URL;?>/assets/js/loadingOverlay.js"></script>
        <!-- <script src="<?=$ROOT_URL;?>/vendor/realtime/realtime.js"></script> -->
        <script src="<?=$ADMIN_URL;?>/assets/js/script.js"></script>
        <script src="<?=$SITE_URL;?>/assets/js/main.js"></script>
    </div>
</body>
</html>