<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';
    require_once '../../dao/category.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('btn_insert', $_REQUEST)) {
        $titlePage = 'Add Product';
        $listCategory = category_select_all();
        $errorMessage = [];
        $product = [];

        $product['product_name'] = $product_name ?? '';
        $product['cate_id'] = $cate_id ?? '';
        $product['price'] = $price ?? '';
        $product['status'] = $status ?? '';
        $product['discount'] = $discount ?? '';
        $product['description'] = $description ?? '';

        if (!$product['product_name']) {
            $errorMessage['product_name'] = 'Vui lòng nhập tên sản phẩm';
        } else if (product_name_exits($product['product_name'])) {
            $errorMessage['product_name'] = 'Tên sản phẩm đã tồn tại trong hệ thống!';
        }

        if (!$product['cate_id']) {
            $errorMessage['cate_id'] = 'Vui lòng chọn loại hàng';
        }

        if ($product['price'] == '') {
            $errorMessage['price'] = 'Vui lòng nhập giá sản phẩm';
        } else if (!is_numeric($product['price'])) {
            $errorMessage['price'] = 'Vui lòng nhập giá sản phẩm';
        } else if ($product['price'] < 0) {
            $errorMessage['price'] = 'Vui lòng nhập giá là số dương';
        }

        if ($product['status'] == '') {
            $errorMessage['status'] = 'Vui lòng chọn trạng thái sản phẩm';
        }

        if ($product['discount'] == '') {
            $errorMessage['discount'] = 'Vui lòng nhập giảm giá';
        } else if (!is_numeric($product['discount'])) {
            $errorMessage['discount'] = 'Vui lòng nhập số';
        } else if ($product['discount'] < 0) {
            $errorMessage['discount'] = 'Vui lòng nhập giảm giá là số dương';
        }

        if (!$product['description']) {
            $errorMessage['description'] = 'Vui lòng nhập mô tả sản phẩm';
        }

        if (empty($errorMessage)) {
            $date = Date('Y-m-d H:i:s');
            $product_image = save_file('product_image', $IMG_PATH . '/');
            $product_image = strlen($product_image) > 0 ? $product_image : 'image_default.png';

            product_insert($product_name, $product_image, $price, $description, $cate_id, $discount, $status, $date, $date);

            $MESSAGE = "Thêm sản phẩm thành công";
            unset($product);
        }

        $VIEW_PAGE = "add.php";
    } else if (array_key_exists('btn_add', $_REQUEST)) {
        $titlePage = 'Add Product';
        $listCategory = category_select_all();
        $VIEW_PAGE = "add.php";
    } else if (array_key_exists('btn_update', $_REQUEST)) {
        $titlePage = 'Update Product';
        $productInfo = product_select_by_id($id);
        $listCategory = category_select_all();
        $errorMessage = [];
        $product = [];

        $product['product_name'] = $product_name ?? '';
        $product['cate_id'] = $cate_id ?? '';
        $product['price'] = $price ?? '';
        $product['status'] = $status ?? '';
        $product['discount'] = $discount ?? '';
        $product['description'] = $description ?? '';

        if (!$product['product_name']) {
            $errorMessage['product_name'] = 'Vui lòng nhập tên sản phẩm';
        } else if ($product['product_name'] != $productInfo['product_name'] && product_name_exits($product['product_name'])) {
            $errorMessage['product_name'] = 'Tên sản phẩm đã tồn tại trong hệ thống!';
        }

        if (!$product['cate_id']) {
            $errorMessage['cate_id'] = 'Vui lòng chọn loại hàng';
        }

        if ($product['price'] == '') {
            $errorMessage['price'] = 'Vui lòng nhập giá sản phẩm';
        } else if (!is_numeric($product['price'])) {
            $errorMessage['price'] = 'Vui lòng nhập giá sản phẩm';
        } else if ($product['price'] < 0) {
            $errorMessage['price'] = 'Vui lòng nhập giá là số dương';
        }

        if ($product['status'] == '') {
            $errorMessage['status'] = 'Vui lòng chọn trạng thái sản phẩm';
        }

        if ($product['discount'] == '') {
            $errorMessage['discount'] = 'Vui lòng nhập giảm giá';
        } else if (!is_numeric($product['discount'])) {
            $errorMessage['discount'] = 'Vui lòng nhập số';
        } else if ($product['discount'] < 0) {
            $errorMessage['discount'] = 'Vui lòng nhập giảm giá là số dương';
        }

        if (!$product['description']) {
            $errorMessage['description'] = 'Vui lòng nhập mô tả sản phẩm';
        }

        if (empty($errorMessage)) {
            $date = Date('Y-m-d H:i:s');
            $product_image = save_file('product_image', $IMG_PATH . '/');
            $product_image = strlen($product_image) > 0 ? $product_image : $productInfo['product_image'];

            product_update($product_name, $product_image, $price, $description, $cate_id, $discount, $status, $date, $id);

            $MESSAGE = "Cập nhật sản phẩm thành công, hệ thống tự động chuyển hướng sau 3s";
            header('Refresh: 3; URL = ' . $ADMIN_URL . '/product');
        }

        $VIEW_PAGE = "edit.php";
    } else if (array_key_exists('btn_edit', $_REQUEST)) {
        $titlePage = 'Update Product';
        $listCategory = category_select_all();
        $productInfo = product_select_by_id($id);
        $VIEW_PAGE = "edit.php";
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        product_delete($id);
        header('Location: ' . $ADMIN_URL . '/product');
    } else if (array_key_exists('search', $_REQUEST)) {
        // jquery ajax
        $listProduct = product_search($keyword, $cate_id);
        function renderProduct($product_item) {
            global $IMG_URL;
            global $ADMIN_URL;
            $html = '';
            $html .= '
            <tr>
                <td>
                    <input type="checkbox" data-id="' . $product_item['id'] . '">
                </td>
                <td>' . $product_item['id'] . '</td>
                <td class="content__table-cell-flex">
                    <div class="content__table-img">
                        <img src="' . $IMG_URL . '/' . $product_item['product_image'] . '" class="content__table-avatar" alt="">
                    </div>

                    <div class="content__table-info">
                        <span class="content__table-name">' . $product_item['product_name'] . '</span>
                    </div>
                </td>
                <td>
                    ' . $product_item['view'] . '
                </td>
                <td>' . number_format($product_item['price']) . ' VNĐ</td>
                <td>
                    <span class="content__table-text-success">
                        ' . date_format(date_create($product_item['created_at']), 'd/m/Y') . '
                    </span>
                </td>
                <td>' . $product_item['cate_name'] . '</td>
                <td>' . number_format($product_item['rating'], 1) . '/5</td>
                <td>';
                
                if ($product_item['status']) {
                    $html .= '<span class="content__table-stt-active">Hiển thị</span>';
                } else {
                    $html .= '<span class="content__table-stt-locked">Ẩn</span>';
                }

                $html .= '
                </td>
                <td>
                    <div class="user_list-action">
                        <a onclick="return confirm(\'Bạn có chắc muốn xóa sản phẩm này không?\') ?
                        window.location.href = \'?btn_delete&id=' . $product_item['id'] . '\' : false;
                        " class="content__table-action danger">
                            <i class="fas fa-trash"></i>
                        </a>
                        <a href="' . $ADMIN_URL . '/product/?btn_edit&id=' . $product_item['id'] . '" class="content__table-action info">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </td>
            </tr>
            ';
            return $html;
        }
        $html = array_map('renderProduct', $listProduct);
        echo join('', $html);
        die();
    } else {
        $titlePage = 'List Product';
        // phân trang
        $totalOrder = count(product_select_all());
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit); // làm tròn số sản phẩm trong trang

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/product/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $listProduct = product_select_all($start, $limit);
        $listCategory = category_select_all();
        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>