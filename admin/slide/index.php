<?php

    require_once '../../global.php';
    require_once '../../dao/slide.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('btn_insert', $_REQUEST)) {
        $titlePage = 'Add Slide';
        $errorMessage = [];
        $slide = [];

        $slide['title'] = $title ?? '';
        $slide['url'] = $url ?? '';

        if (!$slide['title']) {
            $errorMessage['title'] = 'Vui lòng nhập tên slide';
        }

        if (!$slide['url']) {
            $errorMessage['url'] = 'Vui lòng nhập Url';
        } else if (!filter_var($slide['url'], FILTER_VALIDATE_URL)) {
            $errorMessage['url'] = 'Vui lòng nhập lại, Url đã nhập không hợp lệ';
        }

        if (empty($errorMessage)) {
            $slide_image = save_file('slide_image', $IMG_PATH . '/');
            $slide_image = strlen($slide_image) > 0 ? $slide_image : 'product.jpg';

            slide_insert($title, $slide_image, $url);
            unset($slide);
            $MESSAGE = 'Thêm thành công';
        }
        $VIEW_PAGE = 'add.php';
    } else if (array_key_exists('btn_add', $_REQUEST)) {
        $titlePage = 'Add Slide';
        $VIEW_PAGE = 'add.php';
    } else if (array_key_exists('btn_update', $_REQUEST)) {
        $titlePage = 'Add Slide';
        $slideData = slide_select_by_id($ma_slide);
        $errorMessage = [];
        $slide = [];
        $slide['title'] = $title ?? '';
        // var_dump($slide['title']);
        $slide['url'] = $url ?? '';

        if (!$slide['title']) {
            $errorMessage['title'] = 'Vui lòng nhập tên slide';
        }

        if (!$slide['url']) {
            $errorMessage['url'] = 'Vui lòng nhập Url';
        } else if (!filter_var($slide['url'], FILTER_VALIDATE_URL)) {
            $errorMessage['url'] = 'Vui lòng nhập lại, Url đã nhập không hợp lệ';
        }

        if (empty($errorMessage)) {
            $hinh = save_file('slide_image', $IMG_PATH . '/');
            $hinh = strlen($hinh) > 0 ? $hinh : $slideData['slide_image'];

            slide_update( $title, $hinh, $url, $ma_slide);
            $MESSAGE = 'Cập nhật thành công, hệ thống tự động chuyển hướng sau 3s';
            header('Refresh: 3; URL = ' . $ADMIN_URL . '/slide');
        }
        $VIEW_PAGE = 'edit.php';
    } else if (array_key_exists('btn_edit', $_REQUEST)) {
        $titlePage = 'Add Slide';
        $slideData = slide_select_by_id($ma_slide);
        $VIEW_PAGE = 'edit.php';
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        slide_delete($id);
        header('Location: ' . $ADMIN_URL . '/slide');
    } else {
        $titlePage = 'Add Slide';
        $limit = 10;
        $totalUser = slide_quantity();
        $totalPage = ceil($totalUser / $limit);
        $currentPage = $page ?? 1;
        
        if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        } else if ($currentPage < 0) {
            $currentPage = 1;
        }
        
        $start = ($currentPage - 1) * $limit;
        $slideList = slide_select_all($start, $limit);
        $VIEW_PAGE = 'list.php';
    }

    require_once '../layout.php';

?>