<?php

    require_once '../../global.php';
    require_once '../../dao/settings.php';
    require_once '../../dao/product.php';
    require_once '../../dao/favorite.php';
    require_once '../../dao/size.php';
    require_once '../../dao/category.php';
    require_once '../../dao/comment.php';
    require_once '../../dao/rating.php';

    $isWebsiteOpen = settings_select_all();
    if (!$isWebsiteOpen || !$isWebsiteOpen['status']) header('Location: ' . $SITE_URL . '/home/close.php');

    extract($_REQUEST);

    if (array_key_exists('keyword', $_REQUEST)) {
        $itemData = product_home_search($keyword);
        $VIEW_PAGE = "search.php";
    } else if (array_key_exists('category', $_REQUEST)) {
        // phân trang
        $totalProduct = count(product_home_select_by_cate($cate_id));
        $limit = 12;
        $totalPage = ceil($totalProduct / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $SITE_URL . '/product/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $itemData = product_home_select_by_cate($cate_id, $start, $limit);
        $VIEW_PAGE = "category.php";
    } else if (array_key_exists('detail', $_REQUEST)) {
        // kiểm tra sp yêu thích
        $isProductFavorite = false;
        if (isset($_SESSION['user']['id']) && favorite_exits($_SESSION['user']['id'], $id)) {
            $isProductFavorite = true;
        }
        // update view
        product_update_view($id);

        // số đánh giá
        $productRating = rating_select_by_p_id($id);
        // số sp đã bán
        $productSold = product_select_sold($id);
        
        // danh sách bình luận
        $listDataComment = comment_home_select_all_by_pid($id);

        // danh sách cmt chính
        $listComment = array_filter($listDataComment, function ($comment) {
            return !$comment['comment_parent_id'];
        });

        // danh sách comment trả lời
        $listCommentRep = array_filter($listDataComment, function ($comment) {
            return $comment['comment_parent_id'];
        });
        $listCommentRep = array_reverse($listCommentRep);

        // danh sách size
        $listSize = size_select_all('size');

        // chi tiết sản phẩm
        $itemData = product_select_by_id($id);
        $titlePage = $itemData['product_name'];

        // sp cùng loại
        $item_tt = product_relation($id, $itemData['cate_id']);

        $VIEW_PAGE = "detail.php";
    } else if (array_key_exists('get_price', $_REQUEST)) {
        // lấy giá thêm
        $sizeInfo = size_select_by_size($size);

        // lấy giá của sp
        $productInfo = product_select_by_id($id);

        if ($sizeInfo) {
            // giá sp + giá thêm size
            $totalPrice = number_format($productInfo['price'] + $sizeInfo['price_increase']);
            echo json_encode(array(
                'success' => true,
                'totalPrice' => $totalPrice
            ));
        } else if ($size == 'S') {
            echo json_encode(array(
                'success' => true,
                'totalPrice' => number_format($productInfo['price']) //trả về giá sp
            ));
        } else {
            echo json_encode(array(
                'success' => false,
            ));
        }
        die();
    } else if (array_key_exists('comment', $_REQUEST)) {
        // submit form bình luận chính
        $user_id = $_SESSION['user']['id'];
        $ratingExits = rating_exits($product_id, $user_id);
        if ($ratingExits) {
            rating_update($product_id, $user_id, $rating_number, $ratingExits['id']);
        } else {
            rating_insert($product_id, $user_id, $rating_number);
        }

        $created_at = date('Y-m-d H:i:s');
        $lastInsertId = comment_insert($content, $product_id, $user_id, 0, $created_at);
        echo $lastInsertId ?? false;
        die();
    } else if (array_key_exists('btn_repCmt', $_REQUEST)) {
        // click buttom trả lời
        echo '
        <img src="'. $IMG_URL . '/' . $_SESSION['user']['avatar'] .'" alt="" class="comment__rep-form-avatar">
        <div class="comment__rep-form-wrap">
            <textarea type="text" rows="1" class="comment__rep-form-control" placeholder="Nhập nội dung trả lời" data-id="'. $id .'" data-product-id="'. $product_id .'"></textarea>
            <button class="comment__rep-form-send" onclick="repComment(event);">
                <i class="fas fa-reply"></i>
            </button>
        </div>
        ';
        die();
    } else if (array_key_exists('repCmt_insert', $_REQUEST)) {
        // submit form rep cmt
        $created_at = date('Y-m-d H:i:s');
        $lastInsertId =  comment_insert($content, $product_id, $_SESSION['user']['id'], $comment_parent_id, $created_at);
        echo $lastInsertId ?? false;
        die();
    } else if (array_key_exists('delete_cmt', $_REQUEST)) {
        comment_delete($id);
        echo true;
        die();
    } else if (array_key_exists('render_cmt_rep', $_REQUEST)) {
        $cmtInfo = comment_select_by_id($id);
        $html = '';
        $html .= '
        <li class="comment__rep-item comment__rep-item-' . $cmtInfo['id'] . '">
            <img src="' . $IMG_URL . '/' . $cmtInfo['avatar'] . '" alt="">
            <div class="comment__rep-item-info">
                <div class="comment__rep-item-title">
                    <span class="comment__rep-item-name">' . $cmtInfo['fullName'] . '</span>
                    <span class="cmt__title-date">
                        (' . date_format(date_create($cmtInfo['created_at']), "d") . '
                        Tháng ' . date_format(date_create($cmtInfo['created_at']), "m") . ',
                        ' . date_format(date_create($cmtInfo['created_at']), "Y") . ')
                    </span>
                </div>
                <p class="comment__rep-item-content">
                    ' . nl2br($cmtInfo['content']) . '
                </p>
                <ul class="info_cmt-actions">
                <!-- admin và người cmt có quyền xóa bình luận -->';

                if ($cmtInfo['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role']) {
                    $html .= '<li class="info_cmt-action info_cmt-action--delete" onclick="deleteComment(' . $cmtInfo['id'] . ');">Xóa</li>';
                }

                $html .= '
                    <li class="info_cmt-action info_cmt-action--rep">Trả lời</li>
                </ul>
            </div>
        </li>
        ';
        echo $html;
        die();
    } else if (array_key_exists('render_cmt', $_REQUEST)) {
        $cmtInfo = comment_select_by_id($id);
        $html = '';
        $html .= '
        <div class="comment comment-'. $cmtInfo['id'] .'">
            <img src="' . $IMG_URL . '/' . $cmtInfo['avatar'] . '" alt="" width="70px">
            <div class="info_cmt info_cmt-' . $cmtInfo['id'] . '" data-id="' . $cmtInfo['id'] . '" data-product-id="' . $cmtInfo['product_id'] . '">
                <div class="stars">
                    <!-- số sao còn lại -->';
                for($i = 1; $i <= (5 - $cmtInfo['rating_number']); $i++) {
                    $html .= '
                    <div class="star">
                        <i class="fas fa-star"></i>
                    </div>';
                }

                for($i = 1; $i <= $cmtInfo['rating_number']; $i++) {
                    $html .= '
                    <div class="star star__item--active">
                        <i class="fas fa-star"></i>
                    </div>
                    ';
                }
                $html .= '
                </div>
                <div class="cmt_title">
                    <span class="cmt__title-name">' . $cmtInfo['fullName'] . '</span>
                    <span class="cmt__title-date">
                        (' . date_format(date_create($cmtInfo['created_at']), "d") . '
                        Tháng ' . date_format(date_create($cmtInfo['created_at']), "m") . ',
                        ' . date_format(date_create($cmtInfo['created_at']), "Y") . ')
                    </span>
                </div>
                <p class="cmt">
                    ' . $cmtInfo['content'] . '
                </p>
                <ul class="info_cmt-actions">
                    <!-- admin và người cmt có quyền xóa bình luận -->';

                if ($cmtInfo['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role']) {
                    $html .= '<li class="info_cmt-action info_cmt-action--delete" onclick="deleteComment(' . $cmtInfo['id'] . ');">Xóa</li>';
                }
                    $html .= '
                    <li class="info_cmt-action info_cmt-action--rep" onclick="repCmt(event);">Trả lời</li>
                </ul>

                <div action="" class="comment__rep">
                    <ul class="comment__rep-list">
                        <!-- duyệt mảng cmt rep -->
                    </ul>
                    
                    <!-- form rep comment -->
                    <form action="" class="comment__rep-form" onsubmit="return false;"></form>
                </div>
            </div>
        </div>
        ';
        echo $html;
        die();
    } else if (array_key_exists('filter', $_REQUEST)) {
        // jquery ajax
        $productData = product_filter($type, $cate_id);
        function renderProduct($item) {
            global $IMG_URL;
            global $SITE_URL;
            return '
            <div class="pro">
                <div class="cha">
                    <div class="img">
                        <img src="' . $IMG_URL . '/' . $item['product_image'] . '" alt="" width="245px" height="245px">
                    </div>
                <div class="content_con">
                    <button class="bt" name="btn_pro"> <a href="' . $SITE_URL . '/product/?detail&id=' . $item['id'] . '">Xem chi tiết</a></button>
                </div>
                
                </div>
                
                <div class="content_pro">
                    <a href="' . $SITE_URL . '/product/?detail&id=' . $item['id'] . '">' . $item['product_name'] . '</a>
                    <div>
                        <span>' . number_format($item['price']) . 'đ</span>
                    </div>
                </div>
            </div>
            ';
        }
        $html = array_map("renderProduct", $productData);
        echo join('', $html);
        die();
    } else {
        $titlePage = 'Thực đơn';
        $active = 'product';
        // phân trang
        $totalProduct = count(product_select_all('', '', false));
        $limit = 12;
        $totalPage = ceil($totalProduct / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $SITE_URL . '/product/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;
        $item = product_select_all($start, $limit, false);

        $listCategory = category_select_all();

        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>