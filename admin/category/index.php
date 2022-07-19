<?php

    require_once '../../global.php';
    require_once '../../dao/category.php';

    check_login();
    
    extract($_REQUEST);
    
    if (array_key_exists('btn_insert', $_REQUEST)) {
        $titlePage = 'Add Category';
        $errorMessage = [];
        $category = [];

        $category['cate_name'] = $ten_loai ?? '';
        if (!$category['cate_name']) {
            $errorMessage['cate_name'] = 'Vui lòng nhập tên loại hàng';
        } else if (category_name_exist($ten_loai)) {
            $errorMessage['cate_name'] = 'Tên loại đã tồn tại, vui lòng nhập lại';
        }

        if (empty($errorMessage)) {
            $hinh = save_file('cate_image', $IMG_PATH . '/');
            $hinh = strlen($hinh) > 0 ? $hinh : 'product.jpg';
            category_insert($ten_loai, $hinh);
            unset($category);
            $MESSAGE = 'Thêm thành công';
        }
        
        $VIEW_PAGE = 'add.php';
    } else if (array_key_exists('btn_update', $_REQUEST)) {
        $titlePage = 'Update Category';
        $categoryData = category_select_by_id($id);
        $errorMessage = [];
        $category = [];

        $category['cate_name'] = $ten_loai ?? '';

        if (!$category['cate_name']) {
            $errorMessage['cate_name'] = 'Vui lòng nhập tên loại hàng';
        }
        // nếu tên loại người dùng nhập khác tên loại trong database và đã tồn tại tên loại trong database
        else if (($ten_loai != $categoryData['cate_name']) && (category_name_exist($ten_loai))) {
            $errorMessage['cate_name'] = 'Tên loại đã tồn tại, vui lòng nhập lại';
        }

        if (empty($errorMessage)) {
            $hinh = save_file('cate_image', $IMG_PATH . '/');
            $hinh = strlen($hinh) > 0 ? $hinh : $categoryData['cate_image'];
            category_update($ten_loai, $hinh, $id);
            $MESSAGE = 'Cập nhật thành công, vui lòng đợi 3s';
            header('Refresh: 3; URL = ' . $ADMIN_URL . '/category');
        }
        $VIEW_PAGE = 'edit.php';

    } else if (array_key_exists('btn_edit', $_REQUEST)) {
        $titlePage = 'Update Category';
        $categoryData = category_select_by_id($id);
        extract($categoryData);
        $VIEW_PAGE = 'edit.php';
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        category_delete($id);
        header('Location: ' . $ADMIN_URL . '/category');
    } else if (array_key_exists('btn_add', $_REQUEST)) {
        $titlePage = 'Add Category';
        $VIEW_PAGE = 'add.php';
    } else if (array_key_exists('keyword', $_REQUEST)) {
        $titlePage = 'Search Category';
        $listCategory = loai_hang_search($keyword);
        $VIEW_PAGE = 'search.php';
    } else {
        $titlePage = 'List Category';
        $limit = 10;
        $totalUser = loai_hang_quantity();
        $totalPage = ceil($totalUser / $limit);
        $currentPage = $page ?? 1;
        
        if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        } else if ($currentPage < 0) {
            $currentPage = 1;
        }
        
        $start = ($currentPage - 1) * $limit;

        $listCategory =  category_select_all($start, $limit);
        $VIEW_PAGE = 'list.php';
    }

    require_once '../layout.php';

?>