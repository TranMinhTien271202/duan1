<?php

    require_once '../../global.php';
    require_once '../../dao/settings.php';

    $isWebsiteOpen = settings_select_all();
    if ($isWebsiteOpen && $isWebsiteOpen['status']) header('Location: ' . $SITE_URL . '/home');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chúng tôi sẽ trở lại!</title>
    <link rel="icon" href="<?=$SITE_URL;?>/assets/img/favicon.ico" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=$SITE_URL;?>/assets/css/base.css">
    <link rel="stylesheet" href="<?=$SITE_URL;?>/assets/css/main.css">
</head>
<body>
    <div class="container__close">
        <img src="<?=$SITE_URL;?>/assets/images/bao-tri-website.png" alt="" class="container__close-img">
        <h1 class="container__close-title">Hệ thống Website đang nâng cấp!</h1>
        <span class="container__close-description">Website của chúng tôi tạm thời bảo trì trong vài giờ. Quý khách vui lòng quay lại sau hoặc liên hệ bộ phận tư vấn bán hàng trực tuyến:</span>
        
        <div class="form__action">
            <div class="form__item">
                <a href="tel:0347888888" class="form__item-link-wrap form__action-call">
                    <div class="form__item-link-content">
                        <div class="form__item-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        0347 888 888
                    </div>

                    <div class="form__item-link-content-hide">Gọi ngay</div>
                </a>
            </div>

            <div class="form__item">
                <a href="https://www.facebook.com/" class="form__item-link-wrap form__action-fb">
                    <div class="form__item-link-content">
                        <div class="form__item-icon">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        Facebook
                    </div>
                    <div class="form__item-link-content-hide">Tea House</div>
                </a>

            </div>
        </div>
    </div>
</body>
</html>