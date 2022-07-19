<?php

    require_once '../../global.php';
    require_once '../../dao/order.php';
    require_once '../../dao/voucher.php';
    require_once '../../dao/order_logs.php';
    require_once '../../dao/settings.php';
    require_once '../../dao/order_detail.php';

    check_login();

    require_once '../../vendor/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

    extract($_REQUEST);

    if (array_key_exists('update_stt', $_REQUEST)) {
        $updated_at = Date('Y-m-d H:i:s');
        
        // lấy thông tin sp từ hóa đơn chi tiết
        $orderDetail = order_detail_select_all_by_o_id($id);

        
        switch ($status) {
            // 0 - đơn mới, 1 - đã xác nhận, 2 - đang giao, 3 - đã giao, 4 - hủy
            case '4':
                // cập nhật trạng thái đơn hàng
                order_update_status($status, $updated_at, $id);

                // thông tin hóa đơn
                $orderInfo = order_select_by_id($id);

                // gửi mail thông báo hủy
                order_cancel_noti($orderDetail, $orderInfo);
                break;
            case '3':
                // cập nhật trạng thái đơn hàng
                order_update_status($status, $updated_at, $id);

                // thông tin hóa đơn
                $orderInfo = order_select_by_id($id);

                // thông báo đặt thành công
                order_success_noti($orderDetail, $orderInfo);
                break;
            default:
                order_update_status($status, $updated_at, $id);
        }

        log_insert($id, $status, $_SESSION['user']['id'], $updated_at);
        header('Location: ' . $ADMIN_URL . '/order/?detail&id=' . $id);
    } else if (array_key_exists('detail', $_REQUEST)) {
        $titlePage = 'Order Details';
        // chi tiết hóa đơn
        $listOrderDetail = order_detail_select_all_by_o_id($id);

        // thông tin hóa đơn
        $orderInfo = order_select_by_id($id);

        // mảng voucher
        $vouchers = explode(',', $orderInfo['voucher']);

        $VIEW_PAGE = "detail.php";
    } else if (array_key_exists('invoice', $_REQUEST)) {
        // xuất hóa đơn

        require_once 'invoice.php';
        exit();
    } else if(array_key_exists('keyword', $_REQUEST)) {
        $listOrder = order_search($keyword, $status);
        function renderOrder($order_item) {
            global $ADMIN_URL;
            $html = '';
            $html .= '
            <tr>
                <!-- <td>
                    <input type="checkbox" data-id="">
                </td> -->
                <td>
                    DH' . $order_item['id'] . '
                </td>
                <td>
                    <span class="content__table-text-black">
                        ' . $order_item['customer_name'] . '
                    </span>
                </td>
                <td>
                    <span class="content__table-text-success">
                        ' . date_format(date_create($order_item['created_at']), 'd/m/Y H:i') . '
                    </span>
                </td>
                <td>
                    ' . number_format($order_item['total_price'], 0, '', ',') . ' VNĐ
                </td>
                <td>';
                    switch($order_item['status']) {
                        case 0:
                            $html .= '<span class="content__table-stt-active">Đơn hàng mới</span>';
                            break;
                        case 1:
                            $html .= '<span class="content__table-stt-active">Đã xác nhận</span>';
                            break;
                        case 2:
                            $html .= '<span class="content__table-stt-active">Đang giao hàng</span>';
                            break;
                        case 3:
                            $html .= '<span class="content__table-stt-active">Đã giao hàng</span>';
                            break;
                        case 4:
                            $html .= '<span class="content__table-stt-locked">Đã hủy</span>';
                    }
                $html .= '
                </td>
                <td>
                    <a href="' . $ADMIN_URL . '/order/?detail&id=' . $order_item['id'] . '" class="content__table-stt-active">Chi tiết</a>
                    <a href="' . $ADMIN_URL . '/order/?invoice&id=' . $order_item['id'] . '" target="_blank" class="content__table-stt-active">
                        <i class="fas fa-download"></i>
                        Xuất hóa đơn
                    </a>
                </td>
            </tr>
            ';
            return $html;
        }
        $html = array_map('renderOrder', $listOrder);
        echo join('', $html);
        die();
    } else if (array_key_exists('btn_log', $_REQUEST)) {
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
    } else {
        $titlePage = 'List Order';
        // phân trang
        $totalOrder = count(order_select_all());
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/order/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $listOrder = order_select_all($start, $limit);

        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>