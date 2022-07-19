<?php

    require_once '../../global.php';
    require_once '../../dao/comment.php';
    require_once '../../dao/product.php';
    require_once '../../dao/user.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('detail', $_REQUEST)) {
        $titlePage = 'Comment Details';
        // phân trang
        $totalOrder = count(comment_home_select_all_by_pid($p_id));
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/order/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        // lấy danh sách bình luận của 1 sp
        $listCmt = comment_home_select_all_by_pid($p_id, $start, $limit);
        // lấy tên sp
        $productInfo = product_select_by_id($listCmt[0]['product_id']);

        // danh sách khách hàng
        $listUser = user_select_all();
        $VIEW_PAGE = "detail.php";
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        comment_delete($id);
        header('Location: ' . $ADMIN_URL . '/comment/?detail&p_id=' . $p_id);
    } else if (array_key_exists('cmt_detail_search', $_REQUEST)) {
        // jquery ajax
        $listComment = comment_detail_search($p_id, $content, $u_id, $rating);
        function renderComment($cmt_item) {
            // global $ADMIN_URL;
            global $p_id;
            $html = '';
            $html .= '
            <tr>
                <td>
                    <input type="checkbox" data-id="' . $cmt_item['id'] . '">
                </td>
                <td>
                    <textarea cols="30" readonly rows="4" class="content__table-comment">' . $cmt_item['content'] . '</textarea>
                </td>
                <td>
                    <ul class="cmt__stars">';

                        for($i = 1; $i <= $cmt_item['rating_number']; $i++) {
                            $html .= '
                            <li class="cmt__star cmt__star--active">
                                <i class="fas fa-star"></i>
                            </li>';
                        }
                        

                        for($i = 1; $i <= (5 - $cmt_item['rating_number']); $i++) {
                            $html .= '
                            <li class="cmt__star">
                                <i class="fas fa-star"></i>
                            </li>';
                        }
                        
                    $html .= '</ul>
                </td>
                <td>
                    <span class="content__table-text-success">
                        ' . date_format(date_create($cmt_item['created_at']), 'd/m/Y H:i') . '
                    </span>
                </td>
                <td>
                    <span class="content__table-text-black">' . $cmt_item['fullName'] . '</span>
                </td>
                <td>
                    ' . $cmt_item['username'] . '
                </td>
                <td>
                    <div class="user_list-action">
                        <a onclick="return confirm(\'Bạn có chắc muốn xóa bình luận này không?\') ?
                        window.location.href = \'?btn_delete&p_id=' . $p_id  . '&id=' . $cmt_item['id'] .'\' : false;
                        " class="content__table-action danger">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            ';
            return $html;
        }
        $html = array_map('renderComment', $listComment);
        echo join('', $html);
        die();
    } else if (array_key_exists('keyword', $_REQUEST)) {
        // jquery ajax
        $listComment = comment_search($keyword);
        function renderComment($cmt_item) {
            global $ADMIN_URL;
            return '<tr>
                <td>
                    ' .$cmt_item['product_name'] . '
                </td>
                <td>
                    ' .$cmt_item['totalComment'] . '
                </td>
                <td>
                    ' .date_format(date_create($cmt_item['latest']), 'd/m/Y') . ' ' .date_format(date_create($cmt_item['latest']), 'H:i') . '
                </td>
                <td>
                    ' .date_format(date_create($cmt_item['oldest']), 'd/m/Y') . ' ' .date_format(date_create($cmt_item['oldest']), 'H:i') . '
                </td>
                <td>
                    <a href="' .$ADMIN_URL . '/comment/?detail&p_id=' .$cmt_item['id'] . '" class="content__table-stt-active">Chi tiết</a>
                </td>
            </tr>
            ';
        }
        $html = array_map('renderComment', $listComment);
        echo join('', $html);
        die();
    } else {
        $titlePage = 'List Comment';
        // phân trang
        $totalOrder = count(comment_select_all());
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/order/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $listComment = comment_select_all($start, $limit);
        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>