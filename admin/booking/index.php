<?php

    require_once '../../global.php';
    require_once '../../dao/booking.php';
    require_once '../../dao/table.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('', $_REQUEST)) {

    } else if (array_key_exists('update_stt', $_REQUEST)) {
        if ($status == 2) {
            // thông báo hủy bàn cho kh
            $bookingInfo = booking_select_by_id($id);

            // gửi mail cho khách
            booking_send_mail_cancel($bookingInfo);

            // cập nhật trạng thái bàn => bàn trống
            table_update_stt(0, $bookingInfo['table_id']);
        } else if ($status == 3) {
            // khi khách về => bàn trống
            table_update_stt(0, $bookingInfo['table_id']);
        }
        // cập nhật trạng thái đặt bàn
        booking_update_stt($status, $id);

        header('Location: ' . $ADMIN_URL . '/booking/?detail&id=' . $id);
    } else if (array_key_exists('detail', $_REQUEST)) {
        $titlePage = 'Booking Detail';
        $bookingInfo = booking_select_by_id($id);
        $VIEW_PAGE = 'detail.php';
    } else if (array_key_exists('booking_search', $_REQUEST)) {
        // js ajax
        $listBooking = booking_search($bk_keyword);
        function renderBooking($item) {
            global $ADMIN_URL;
            $html = '';
            $html .= '
            <tr>
                <!-- <td>
                    <input type="checkbox" data-id="">
                </td> -->
                <td>
                    #' . $item['id'] . '
                </td>
                <td>
                    <span class="content__table-text-black">
                        ' . $item['name'] . '
                    </span>
                </td>
                <td>
                    <span class="content__table-text-success">
                        ' . date('d/m/Y', strtotime($item['date_book'])) . ' ' . date('H:i', strtotime($item['time_book'])) . '
                    </span>
                </td>
                <td>
                    ' . $item['table_name'] . '
                </td>
                <td>';
                    switch($item['status']) {
                        case 0:
                            $html .= '<span class="content__table-stt-active">Đang xử lý</span>';
                            break;
                        case 1:
                            $html .= '<span class="content__table-stt-active">Đã xác nhận</span>';
                            break;
                        case 2:
                            $html .= '<span class="content__table-stt-locked">Đã hủy</span>';
                            break;
                    }
                $html .= '
                </td>
                <td>
                    <a href="' . $ADMIN_URL . '/booking/?detail&id=' . $item['id'] . '" class="content__table-stt-active">Chi tiết</a>
                </td>
            </tr>
            ';
            return $html;
        }
        $html = array_map('renderBooking', $listBooking);
        echo join('', $html);
        die();

    } else {
        $titlePage = 'List Booking';
        // phân trang
        $totalOrder = count(booking_select_all());
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/order/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $bookingList = booking_select_all($start, $limit);
        $VIEW_PAGE = 'list.php';
    }

    require_once '../layout.php';

?>