<?php

    require_once '../../global.php';
    require_once '../../dao/size.php';

    extract($_REQUEST);

    if (array_key_exists('btn_update', $_REQUEST)) {
        $titlePage = 'Edit Size';

        $sizeInfo = size_select_by_id($id);
        $errorMessage = [];
        $size = [];

        $size['product_size'] = $product_size ?? '';
        $size['price_increase'] = $price_increase ?? '';

        if (!$size['product_size']) {
            $errorMessage['product_size'] = 'Vui lòng chọn Size';
        } else if ($product_size != $sizeInfo['product_size'] && size_exits($product_size)) {
            $errorMessage['product_size'] = 'Size ' . $size['product_size'] . ' đã tồn tại trong hệ thống!';
        }

        if (!$size['price_increase']) {
            $errorMessage['price_increase'] = 'Vui lòng nhập giá thêm';
        } else if (!is_numeric($size['price_increase'])) {
            $errorMessage['price_increase'] = 'Vui lòng nhập số';
        } else if ($size['price_increase'] < 0) {
            $errorMessage['price_increase'] = 'Vui lòng nhập số dương';
        }

        if (empty($errorMessage)) {
            $updated_at = date('Y-m-d H:i:s');
            size_update($product_size, $price_increase, $updated_at, $id);

            $MESSAGE = 'Cập nhật thành công, hệ thống tự động chuyển hướng sau 3s';
            header('Refresh: 3; URL = ' . $ADMIN_URL . '/size');
        }

        $VIEW_PAGE = "edit.php";
    } else if (array_key_exists('btn_edit', $_REQUEST)) {
        $titlePage = 'Edit Size';

        $sizeInfo = size_select_by_id($id);
        $VIEW_PAGE = 'edit.php';
    } else if (array_key_exists('btn_insert', $_REQUEST)) {
        $titlePage = 'Add Size';

        $errorMessage = [];
        $size = [];

        $size['product_size'] = $product_size ?? '';
        $size['price_increase'] = $price_increase ?? '';

        if (!$size['product_size']) {
            $errorMessage['product_size'] = 'Vui lòng chọn Size';
        } else if (size_exits($size['product_size'])) {
            $errorMessage['product_size'] = 'Size ' . $size['product_size'] . ' đã tồn tại trong hệ thống!';
        }

        if (!$size['price_increase']) {
            $errorMessage['price_increase'] = 'Vui lòng nhập giá thêm';
        } else if (!is_numeric($size['price_increase'])) {
            $errorMessage['price_increase'] = 'Vui lòng nhập số';
        } else if ($size['price_increase'] < 0) {
            $errorMessage['price_increase'] = 'Vui lòng nhập số dương';
        }

        if (empty($errorMessage)) {
            $date = date('Y-m-d H:i:s');
            size_insert($product_size, $price_increase, $date, $date);

            $MESSAGE = 'Thêm size thành công';
            unset($size);
        }

        $VIEW_PAGE = "add.php";
    } else if (array_key_exists('btn_add', $_REQUEST)) {
        $titlePage = 'Add Size';
        $VIEW_PAGE = 'add.php';
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        size_delete($id);
        header('Location: ' . $ADMIN_URL . '/size');
    } else {
        $titlePage = 'List Size';
        $listSize = size_select_all();
        $VIEW_PAGE = 'list.php';
    }

    require_once '../layout.php';

?>