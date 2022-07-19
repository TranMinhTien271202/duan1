<?php

    require_once '../../global.php';
    require_once '../../dao/contact.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('btn_rep_feedback', $_REQUEST)) {
        $feedbackInfo = contact_select_by_id($id);
        $errorMessage = [];
        $feedback = [];

        $feedback['content_rep'] = $content_rep ?? '';

        if (!$feedback['content_rep']) {
            $errorMessage['content_rep'] = 'Vui lòng nhập nội dung phản hồi khách hàng';
        }

        if (empty($errorMessage)) {
            // gửi mail phản hồi
            contact_send_mail($feedbackInfo, $content_rep);

            // cập nhật trạng thái đã phản hồi
            contact_update_stt($id);
            $MESSAGE = 'Gửi phản hồi thành công, hệ thống sẽ chuyển hướng sau 3s';
            unset($feedback);
            header('Refresh: 3; URL = ' . $ADMIN_URL . '/feedback');
        }

        $VIEW_PAGE = 'detail.php';

    } else if (array_key_exists('detail', $_REQUEST)) {
        $feedbackInfo = contact_select_by_id($id);
        $VIEW_PAGE = 'detail.php';
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        contact_delete($id);
        header('location: '. $ADMIN_URL.'/feedback');
    } else {
        $titlePage = 'List Feedback';
        $limit = 10;
        $totalUser = count(contact_select_all());
        $totalPage = ceil($totalUser / $limit);
        $currentPage = $page ?? 1;
        
        if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        } else if ($currentPage < 0) {
            $currentPage = 1;
        }
        
        $start = ($currentPage - 1) * $limit;
        $items = contact_select_all($start, $limit);
        $VIEW_PAGE = 'list.php';
    }

    require_once '../layout.php';

?>