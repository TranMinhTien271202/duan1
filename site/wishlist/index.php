<?php

    require_once '../../global.php';
    require_once '../../dao/favorite.php';

    extract($_REQUEST);

    if (array_key_exists('add_wishlist', $_REQUEST)) {
        // nếu chưa đăng nhập
        if (!isset($_SESSION['user']['id'])) {
            echo json_encode(array(
                'success' => false,
                'message' => 'Vui lòng đăng nhập để yêu thích sản phẩm'
            ));
        } else {
            // nếu không tồn tại
            if (!favorite_exits($_SESSION['user']['id'], $id)) {
                $created_at = date('Y-m-d H:i:s');
                favorite_insert($_SESSION['user']['id'], $id, $created_at);

                echo json_encode(array(
                    'success' => true,
                    'message' => 'Thêm sản phẩm vào danh sách yêu thích thành công'
                ));
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Sản phẩm đã tồn tại trong DS yêu thích'
                ));
            }
        }
        die();
    } else if (array_key_exists('render_wishlist', $_REQUEST)) {
        $success = true;
        if (!isset($_SESSION['user']['id'])) {
            $success = false;
            $message = 'Vui lòng đăng nhập để xem DS yêu thích';
        } else if (!favorite_select_by_uid($_SESSION['user']['id'])) {
            $success = false;
            $message = 'Không có sản phẩm yêu thích nào';
        } else {
            $favoriteProduct = favorite_select_by_uid($_SESSION['user']['id']);
            $html = array_map(function($item) {
                global $IMG_URL;
                global $SITE_URL;
                return
                '<li class="wishlist__body-list-item wishlist__body-list-item-'.$item['heart_id'].'">
                    <a href="' . $SITE_URL . '/product/?detail&id=' . $item['id'] . '" class="wishlist__body-list-item-image-link">
                        <img src="'.$IMG_URL.'/'.$item['product_image'].'" alt="" class="wishlist__body-list-item-image">
                    </a>
        
                    <div class="wishlist__body-list-item-info">
                        <a href="' . $SITE_URL . '/product/?detail&id=' . $item['id'] . '" class="wishlist__body-list-item-title">'.$item['product_name'].'</a>
                        <span class="wishlist__body-list-item-price">'.number_format($item['price'], 0, '', ',').'₫</span>
                        <span class="wishlist__body-list-item-time">'.date_format(date_create($item['time_heart']), 'd/m/Y H:i').'</span>
                    </div>
        
                    <div class="wishlist__body-icon-delete" onclick="delete_wishlist('.$item['heart_id'].');">
                        <i class="fas fa-trash"></i>
                    </div>
                </li>';
            }, $favoriteProduct);
            $message = join('', $html);
        }
        echo json_encode(array(
            'success' => $success,
            'message' => $message
        ));
    } else if (array_key_exists('delete_wishlist', $_REQUEST)) {
        favorite_delete($id);
    } else if (array_key_exists('get_quantity', $_REQUEST)) {
        if (!isset($_SESSION['user']['id'])) {
            echo 0;
        } else {
            echo count(favorite_select_by_uid($_SESSION['user']['id']));
        }
    }

?>