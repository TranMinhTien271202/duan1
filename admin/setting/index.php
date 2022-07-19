<?php

    require_once '../../global.php';
    require_once '../../dao/settings.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('btn_update', $_REQUEST)) {
        $titlePage = 'Update Settings';
        $settingInfo = settings_select_all();

        $setting = [];
        $errorMessage = [];

        $setting['title'] = $title ?? '';
        $setting['phone'] = $phone ?? '';
        $setting['email'] = $email ?? '';
        $setting['address'] = $address ?? '';
        $setting['map'] = $map ?? '';
        $setting['facebook'] = $facebook ?? '';
        $setting['youtube'] = $youtube ?? '';
        $setting['instagram'] = $instagram ?? '';
        $setting['tiktok'] = $tiktok ?? '';
        $setting['status'] = $status ?? '';

        if (!$setting['title']) {
            $errorMessage['title'] = 'Vui lòng nhập tiêu đề website';
        }

        if (!$setting['phone']) {
            $errorMessage['phone'] = 'Vui lòng nhập số điện thoại';
        }

        if (!$setting['email']) {
            $errorMessage['email'] = 'Vui lòng nhập địa chỉ email';
        }

        if (!$setting['address']) {
            $errorMessage['address'] = 'Vui lòng nhập địa chỉ website';
        }

        if (!$setting['map']) {
            $errorMessage['map'] = 'Vui lòng nhập Iframe Google map';
        }

        if ($setting['status'] == '') {
            $errorMessage['status'] = 'Vui lòng chọn trạng thái website';
        }

        if (empty($errorMessage)) {
            $current_logo = save_file('logo', $IMG_PATH . '/');
            if (empty($settingInfo)) {
                $current_logo = strlen($current_logo) > 0 ? $current_logo : 'image_default.png';
                settings_insert($title, $current_logo, $phone, $email, $address, $map, $facebook, $youtube, $instagram, $tiktok, $status);
            } else {
                $current_logo = strlen($current_logo) > 0 ? $current_logo : $settingInfo['logo'];
                settings_update($title, $current_logo, $phone, $email, $address, $map, $facebook, $youtube, $instagram, $tiktok, $status);
            }
            
            $MESSAGE = 'Cập nhật cấu hình thành công';
        }

        $VIEW_PAGE = "edit.php";
    } else {
        $titlePage = 'Update Settings';
        $settingInfo = settings_select_all();

        $VIEW_PAGE = "edit.php";
    }

    require_once '../layout.php';

?>