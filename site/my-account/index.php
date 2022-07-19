<?php

    require_once '../../global.php';
    require_once '../../dao/user.php';
    require_once '../../dao/order.php';
    require_once '../../dao/order_detail.php';
    require_once '../../dao/voucher.php';
    require_once '../../dao/order_logs.php';
    require_once '../../dao/booking.php';
    require_once '../../dao/table.php';

    check_login(0);
    extract($_REQUEST);

    $userInfo = $_SESSION['user'];
    $DASHBOARD = 'dashboard.php';

    if (array_key_exists('cart', $_REQUEST)) {
        $titlePage = 'My Cart';
        $active = 'cart';
        // phân trang
        $totalOrder = count(order_select_all_by_user_id($userInfo['id']));
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $SITE_URL . '/my-account/?cart&page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $myCarts = order_select_all_by_user_id($userInfo['id'], $start, $limit);
        $VIEW_PAGE = "cart_list.php";
    } else if (array_key_exists('cart_detail', $_REQUEST)) {
        $titlePage = 'My Cart Detail';
        $active = 'cart';
        // chi tiết đơn hàng
        $myCartDetail = order_detail_select_all_by_o_id($id);

        // thông tin đơn hàng
        $myCartInfo = order_select_by_id($id);

        // mảng voucher
        $vouchers = explode(',', $myCartInfo['voucher']);

        $VIEW_PAGE = "cart_detail.php";
    } else if (array_key_exists('my_cart_log', $_REQUEST)) {
        $logInfo = log_select_by_oid($order_id);
        $htmlLog = '';

        $htmlLog .= '
        <div class="logs__inner-body-item">
            <div class="logs__inner-body-group">
                <label for="" class="logs__inner-body-label">Tên khách hàng</label>
                <input type="text" class="logs__inner-body-control" disabled value="' . $logInfo[0]['customer_name'] . '">
            </div>

            <div class="logs__inner-body-group">
                <label for="" class="logs__inner-body-label">Số điện thoại</label>
                <input type="text" class="logs__inner-body-control" disabled value="' . $logInfo[0]['phone'] . '">
            </div>

            <div class="logs__inner-body-group">
                <label for="" class="logs__inner-body-label">Email</label>
                <input type="text" class="logs__inner-body-control" disabled value="' . $logInfo[0]['email'] . '">
            </div>

            <div class="logs__inner-body-group">
                <label for="" class="logs__inner-body-label">Địa chỉ giao hàng</label>
                <input type="text" class="logs__inner-body-control" disabled value="' . $logInfo[0]['address'] . '">
            </div>

            <div class="logs__inner-body-group">
                <label for="" class="logs__inner-body-label">Thời gian đặt hàng</label>
                <input type="text" class="logs__inner-body-control" disabled value="' . date('d/m/Y H:i', strtotime($logInfo[0]['time_order'])) . '">
            </div>

            <div class="logs__inner-body-group">
                <label for="" class="logs__inner-body-label">Ghi chú</label>
                <input type="text" class="logs__inner-body-control" disabled value="' . $logInfo[0]['message'] . '">
            </div>
        </div>
        <div class="logs__inner-body-item logs__inner-body-item-log">
            <table class="logs__inner-body-item-table">
        ';

        foreach ($logInfo as $key => $item) {
            if ($item['status'] == 0) {
                $status = 'Mới đặt hàng';
            } else if ($item['status'] == 1) {
                $status = 'Đã xác nhận';
            } else if ($item['status'] == 2) {
                $status = 'Đang giao hàng';
            } else if ($item['status'] == 3) {
                $status = 'Đã giao hàng';
            } else if ($item['status'] == 4) {
                $status = 'Đã hủy';
            }

            $userInfo = $item['user_id'] ? $item['fullName'] . ' (' . $item['username'] . ')' : $logInfo[0]['customer_name'];

            $htmlLog .= '
            <tr>
                <td>'.($key + 1).'</td>
                <td>'. $status .'</td>
                <td>' . $userInfo . '</td>
                <td>'. date('d/m/Y H:i', strtotime($item['created_at'])) .'</td>
            </tr>
            ';
        }

        $htmlLog .= '</table>
        </div>';

        echo $htmlLog;
        die();
    } else if (array_key_exists('cart_cancel', $_REQUEST)) {
        // đơn hàng đã/đang giao không thể hủy
        if (order_check_delivered($id)) {
            echo '<script>
            var result = confirm("Bạn không thể hủy đơn hàng này!")
            if (result) {
                window.location.href = "?cart_detail&id='.$id.'";
            } else {
                window.location.href = "?cart_detail&id='.$id.'";
            }
            </script>';
        } else {
            $updated_at = date('Y-m-d H:i:s');

            // cập nhật trạng thái hủy
            order_update_status(4, $updated_at, $id);

            // lấy thông tin sp từ hóa đơn chi tiết
            $orderDetail = order_detail_select_all_by_o_id($id);

            // gửi mail thông báo cho admin
            $orderInfo = order_select_by_id($id);

            // thông báo cho khách
            order_cancel_noti($orderDetail, $orderInfo);
            order_cancel_noti_admin($orderDetail, $orderInfo);

            // update log
            log_insert($id, 4, $userInfo['id'], $updated_at);
            header('Location: ' . $SITE_URL . '/my-account/?cart_detail&id=' . $id);
        }
    } else if (array_key_exists('keyword', $_REQUEST)) {
        $listOrder = order_search($keyword, $status, $userInfo['id']);
        function renderOrder($order_item) {
            global $SITE_URL;
            $html = '';

            $html .= '
            <tr>
                <td>#' . $order_item['id'] . '</td>
                <td>' . $order_item['customer_name'] . '</td>
                <td>' . date_format(date_create($order_item['created_at']), 'd/m/Y H:i') . '</td>
                <td>
                    ' . number_format($order_item['total_price'], 0, '', ',') . ' VNĐ
                </td>
                <td>';
                switch($order_item['status']) {
                    case 0:
                        $html .= '<span class="my-acc__order-table--active">Đơn hàng mới</span>';
                        break;
                    case 1:
                        $html .= '<span class="my-acc__order-table--active">Đã xác nhận</span>';
                        break;
                    case 2:
                        $html .= '<span class="my-acc__order-table--active">Đang giao hàng</span>';
                        break;
                    case 3:
                        $html .= '<span class="my-acc__order-table--active">Đã giao hàng</span>';
                        break;
                    case 4:
                        $html .= '<span class="my-acc__order-table--danger">Đã hủy</span>';
                }

                $html .= '
                </td>
                <td>
                    <button class="my-acc__order-table-btn">
                        <a href="' . $SITE_URL . '/my-account/?cart_detail&id=' . $order_item['id'] . '" class="my-acc__order-table-btn-link">VIEW</a>
                    </button>
                </td>
            </tr>
            ';
            return $html;
        }
        $html = array_map('renderOrder', $listOrder);
        echo join('', $html);
        die();
    } else if (array_key_exists('booking', $_REQUEST)) {
        $titlePage = 'List Booking';
        $active = 'booking';
        // phân trang
        $totalBooking = count(booking_select_all_by_uid($userInfo['id']));
        $limit = 10;
        $totalPage = ceil($totalBooking / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $SITE_URL . '/my-account/?booking&page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $bookingList = booking_select_all_by_uid($userInfo['id'], $start, $limit);
        $VIEW_PAGE = 'booking_list.php';
    } else if (array_key_exists('booking_search', $_REQUEST)) {
        // js ajax
        $listBooking = booking_search($bk_keyword, $userInfo['id']);
        function renderBooking($item) {
            global $SITE_URL;
            $html = '';
            $html .= '
            <tr>
                <td>#' . $item['id'] . '</td>
                <td>' . $item['name'] . '</td>
                <td>' . date_format(date_create($item['date_book']), 'd/m/Y H:i') . '</td>
                <td>
                    ' . $item['table_name'] . '
                </td>
                <td>';
                    switch($item['status']) {
                        case 0:
                            $html .= '<span class="my-acc__order-table--active">Chờ xử lý</span>';
                            break;
                        case 1:
                            $html .= '<span class="my-acc__order-table--active">Đã xác nhận</span>';
                            break;
                        case 2:
                            $html .= '<span class="my-acc__order-table--danger">Đã hủy</span>';
                            break;
                        case 3:
                            $html .= '<span class="my-acc__order-table--active">Hoàn thành</span>';
                            break;
                    }
                $html .= '
                </td>
                <td>
                    <button class="my-acc__order-table-btn">
                        <a href="' . $SITE_URL . '/my-account/?booking_detail&id=' . $item['id'] . '" class="my-acc__order-table-btn-link">VIEW</a>
                    </button>
                </td>
            </tr>
            ';
            return $html;
        }
        $html = array_map('renderBooking', $listBooking);
        echo join('', $html);
        die();
    } else if (array_key_exists('booking_detail', $_REQUEST)) {
        $titlePage = 'Booking Detail';
        $active = 'booking';
        $bookingInfo = booking_select_by_id($id);
        $VIEW_PAGE = 'booking_detail.php';
    } else if (array_key_exists('booking_cancel', $_REQUEST)) {
        // thông tin đặt bàn
        $bookingInfo = booking_select_by_id($id);

        // cập nhật trạng thái đặt bàn => đã hủy
        booking_update_stt(2, $id);

        // cập nhật trạng thái bàn => bàn trống
        table_update_stt(0, $bookingInfo['table_id']);

        // thông báo cho ad
        booking_send_mail_admin_cancel($bookingInfo);
        header('Location: ' . $SITE_URL . '/my-account/?booking_detail&id=' . $id);
    } else if (array_key_exists('btn_update_pass', $_REQUEST)) {
        $titlePage = 'Update Password';
        $active = 'update_pass';
        $password = [];
        $errorMessage = [];

        $password['old_password'] = $old_password ?? '';
        $password['new_password'] = $new_password ?? '';
        $password['confirm_password'] = $confirm_password ?? '';

        if (!$password['old_password']) {
            $errorMessage['old_password'] = 'Vui lòng nhập mật khẩu hiện tại';
        } else if (!password_verify($old_password, $_SESSION['user']['password'])) {
            $errorMessage['old_password'] = 'Vui lòng nhập lại, mật khẩu hiện tại không chính xác';
        }

        if (!$password['new_password']) {
            $errorMessage['new_password'] = 'Vui lòng nhập mật khẩu mới';
        } else if (strlen($password['new_password']) < 3) {
            $errorMessage['new_password'] = 'Vui lòng nhập mật khẩu tối thiểu 3 ký tự';
        }

        if (!$password['confirm_password']) {
            $errorMessage['confirm_password'] = 'Vui lòng nhập mật khẩu xác nhận';
        } else if (strlen($password['confirm_password']) < 3) {
            $errorMessage['confirm_password'] = 'Vui lòng nhập mật khẩu tối thiểu 3 ký tự';
        } else if ($password['new_password'] != $password['confirm_password']) {
            $errorMessage['confirm_password'] = 'Vui lòng nhập lại, mật khẩu xác nhận không chính xác';
        }

        if (empty($errorMessage)) {
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            user_change_pass($new_password, $userInfo['id']);
            $MESSAGE = "Cập nhật mật khẩu thành công";
            
            // cập nhật session
            $user = user_select_by_id($userInfo['id']);
            $_SESSION['user'] = $user;
            unset($password);
        }

        $VIEW_PAGE = "edit_pass.php";
    } else if (array_key_exists('update_pass', $_REQUEST)) {
        $titlePage = 'Update Password';
        $active = 'update_pass';
        $VIEW_PAGE = "edit_pass.php";
    } else if (array_key_exists('btn_update_info', $_REQUEST)) {
        $titlePage = 'Update Info';
        $active = 'edit_info';
        $infoUser = [];
        $errorMessage = [];

        $infoUser['fullName'] = $fullName ?? '';
        $infoUser['email'] = $email ?? '';
        $infoUser['phone'] = $phone ?? '';
        $infoUser['address'] = $address ?? '';

        if (!$infoUser['fullName']) {
            $errorMessage['fullName'] = 'Vui lòng nhập họ tên của bạn';
        }

        if (!$infoUser['email']) {
            $errorMessage['email'] = 'Vui lòng nhập địa chỉ email';
        } else if (!preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', $infoUser['email'])) {
            $errorMessage['email'] = 'Vui lòng nhập lại, email không đúng định dạng';
        } else if ($email != $_SESSION['user']['email'] && user_exits_by_options('email', $email)) {
            // email không được trùng nhau
            $errorMessage['email'] = 'Vui lòng nhập lại, email đã tồn tại trên hệ thống';
        }

        if (!$infoUser['phone']) {
            $errorMessage['phone'] = 'Vui lòng nhập số điện thoại';
        } else if (!preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $phone)) {
            $errorMessage['phone'] = 'Vui lòng nhập lại, định dạng không chính xác';
        } else if ($phone != $_SESSION['user']['phone'] && user_exits_by_options('phone', $phone)) {
            $errorMessage['phone'] = 'Vui lòng nhập lại, sđt đã tồn tại trên hệ thống';
        }

        if (!$infoUser['address']) {
            $errorMessage['address'] = 'Vui lòng nhập địa chỉ';
        }

        if (empty($errorMessage)) {
            $user = $_SESSION['user'];
            $avatar = save_file('avatar', $IMG_PATH . '/');
            $avatar = strlen($avatar) > 0 ? $avatar : $user['avatar'];
            user_update($user['password'], $email, $phone, $fullName, $address, $avatar, $user['active'], $user['role'], $user['id']);
            // cập nhật session
            $user = user_select_by_id($userInfo['id']);
            $_SESSION['user'] = $user;
            $MESSAGE = 'Cập nhật thông tin tài khoản thành công';
        }

        $VIEW_PAGE = "edit_info.php";
    } else if (array_key_exists('logout', $_REQUEST)) {
        unset($_SESSION['user']);
        header('Location: ' . $SITE_URL . '/account');
    }
     else {
        $titlePage = 'Update Info';
        $active = 'edit_info';
        $VIEW_PAGE = 'edit_info.php';
    }

    require_once '../layout.php';

?>