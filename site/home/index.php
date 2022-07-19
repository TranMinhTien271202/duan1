<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';
    require_once '../../dao/favorite.php';
    require_once '../../dao/slide.php';
    require_once '../../dao/category.php';
    require_once '../../dao/contact.php';
    require_once '../../dao/booking.php';
    require_once '../../dao/table.php';
    require_once '../../dao/settings.php';
    require_once '../../dao/analytic.php';

    $isWebsiteOpen = settings_select_all();
    if (!$isWebsiteOpen || !$isWebsiteOpen['status']) header('Location: ' . $SITE_URL . '/home/close.php');

    extract($_REQUEST);

    if (array_key_exists('intro', $_REQUEST)) {
        $titlePage = 'Giới thiệu';
        $active = 'intro';
        $VIEW_PAGE = "intro.php";
    } else if (array_key_exists('order_insert', $_REQUEST)) {
        $titlePage = 'Đặt bàn';
        $active = 'order';
        $listTableExits = table_select_exits();

        $order = [];
        $errorMessage = [];

        $order['name'] = $name ?? '';
        $order['phone'] = $phone ?? '';
        $order['date_book'] = $date_book ?? '';
        $order['email'] = $email ?? '';
        $order['table_id'] = $table_id ?? '';
        $order['time_book'] = $time_book ?? '';

        if (!$order['name']) {
            $errorMessage['name'] = 'Vui lòng nhập tên';
        }

        if (!$order['phone']) {
            $errorMessage['phone'] = 'Vui lòng nhập số điện thoại';
        } else if (!preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $order['phone'])) {
            $errorMessage['phone'] = 'Vui lòng nhập lại, số điện thoại không đúng định dạng';
        }

        if (!$order['email']) {
            $errorMessage['email'] = 'Vui lòng nhập email';
        } else if (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $order['email'])) {
            $errorMessage['email'] = 'Vui lòng nhập lại, email không đúng định dạng';
        }

        if (!$order['date_book']) {
            $errorMessage['date_book'] = 'Vui lòng chọn ngày';
        } else if ($order['date_book'] < date('Y-m-d')) {
            $errorMessage['date_book'] = 'Vui lòng chọn lại ngày';
        }

        if (!$order['time_book']) {
            $errorMessage['time_book'] = 'Vui lòng chọn thời gian';
        } else {
            // từ t2 - t6
            if (date('N') <= 5) {
                if (($order['time_book']) > date('H:i', strtotime('22:00')) || ($order['time_book']) < date('H:i', strtotime('7:00'))) {
                    $errorMessage['time_book'] = 'Chúng tôi không mở cửa vào thời gian này';
                }
            } else {
                if (($order['time_book']) > date('H:i', strtotime('21:00')) || ($order['time_book']) < date('H:i', strtotime('8:00'))) {
                    $errorMessage['time_book'] = 'Chúng tôi không mở cửa vào thời gian này';
                }
            }
        }

        if (!$order['table_id']) {
            $errorMessage['table_id'] = 'Vui lòng chọn bàn';
        }

        if (empty($errorMessage)) {
            $user_id = $_SESSION['user']['id'] ?? 0;

            $lastId = booking_insert($user_id, $name, $email, $phone, $table_id, $date_book, $time_book, 0);

            // lấy thông tin bàn
            $tableInfo = table_select_by_id($table_id);

            // gửi email cho kh
            booking_send_mail($lastId, $email, $name, $phone, $tableInfo, $date_book, $time_book);

            // gửi email cho admin
            booking_send_mail_admin($lastId, $email, $name, $phone, $tableInfo, $date_book, $time_book);

            // cập nhật trạng thái bàn => đã đặt trước
            table_update_stt(2, $table_id);

            $MESSAGE = 'Đặt bàn thành công, mã đặt bàn của bạn là: #' . $lastId;
            unset($order);
        }
        
        $VIEW_PAGE = 'order.php';
    } else if (array_key_exists('order', $_REQUEST)) {
        $titlePage = 'Đặt bàn';
        $active = 'order';
        $listTableExits = table_select_exits();
        $VIEW_PAGE = "order.php";
    } else if(array_key_exists('contact_insert', $_REQUEST)){
        $titlePage = 'Liên hệ';
        $active = 'contact';

        $title = 'Liên hệ - Góp ý';
        $errorMessage = [];
        $contact = [];

        $contact['name'] = $name ?? '';
        $contact['email'] = $email ?? '';
        $contact['phone'] = $phone ?? '';
        $contact['content'] = $content ?? '';

        if (!$contact['name']) {
            $errorMessage['name'] = 'Vui lòng nhập họ tên';
        } else if (!preg_match('/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+$/', $contact['name'])) {
            $errorMessage['name'] = 'Vui lòng nhập lại, họ tên không đúng định dạng';
        }
        
        if (!$contact['email']) {
            $errorMessage['email'] = 'Vui lòng nhập email';
        } else if (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $contact['email'])) {
            $errorMessage['email'] = 'Vui lòng nhập lại, email không đúng định dạng';
        }

        if (!$contact['phone']) {
            $errorMessage['phone'] = 'Vui lòng nhập số điện thoại';
        } else if (!preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $contact['phone'])) {
            $errorMessage['phone'] = 'Vui lòng nhập lại, số điện thoại không đúng định dạng';
        }

        if (!$contact['content']) {
            $errorMessage['content'] = 'Vui lòng nhập nội dung góp ý';
        }

        if (empty($errorMessage)) {
            $user_id = $_SESSION['user']['id'] ?? 0;
            $created_at = Date('Y-m-d H:i:s');
            // Thêm lh
            contact_insert($name, $content, $email, $phone, $created_at);
            unset($contact);
            $MESSAGE = 'Gửi góp ý thành công';
        }
        $VIEW_PAGE = "contact.php";
    } else if (array_key_exists('contact', $_REQUEST)) {
        $titlePage = 'Liên hệ';
        $active = 'contact';
        $VIEW_PAGE = 'contact.php';
    } else {
        $active = 'index';

        // danh sách menu (ko lấy sản phẩm ẩn)
        $listProduct = product_select_all(0, 8, false);

        // danh mục sản phẩm
        $categoryInfo = category_home_select_all();

        // danh sách slide
        $listSlide = slide_select_all();
        $VIEW_PAGE = "home.php";
    }

    require_once '../layout.php';

?>