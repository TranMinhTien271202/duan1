<?php

    require_once '../../global.php';
    require_once '../../dao/voucher.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('btn_insert', $_REQUEST)) {
        $titlePage = 'Add Voucher';
        $errorMessage = [];
        $voucher = [];

        $voucher['code'] = $code ?? '';
        $voucher['quantity'] = $quantity ?? '';
        $voucher['condition'] = $condition ?? '';
        $voucher['voucher_number'] = $voucher_number ?? '';
        $voucher['time_start'] = $time_start ?? '';
        $voucher['time_end'] = $time_end ?? '';
        $voucher['status'] = $status ?? '';

        if (!$voucher['code']) {
            $errorMessage['code'] = 'Vui lòng nhập mã Voucher';
        } else if (voucher_exits($code)) {
            $errorMessage['code'] = 'Vui lòng lại, Voucher đã tồn tại';
        }

        if ($voucher['quantity'] == '') {
            $errorMessage['quantity'] = 'Vui lòng nhập số lượng sử dụng Voucher';
        } else if (!is_numeric($voucher['quantity']) || $voucher['quantity'] < 0) {
            $errorMessage['quantity'] = 'Vui lòng nhập lại';
        }

        if ($voucher['condition'] == '') {
            $errorMessage['condition'] = 'Vui lòng chọn loại giảm';
        }

        if (!$voucher['voucher_number']) {
            $errorMessage['voucher_number'] = 'Vui lòng nhập mức giảm';
        } else if (!is_numeric($voucher['voucher_number']) || $voucher['voucher_number'] < 0) {
            $errorMessage['voucher_number'] = 'Vui lòng nhập lại';
        } else if ($voucher['condition'] == 0 && $voucher['voucher_number'] > 100) {
            $errorMessage['voucher_number'] = 'Vui lòng nhập lại phần trăm giảm';
        }

        if (!$voucher['time_start']) {
            $errorMessage['time_start'] = 'Vui lòng nhập thời gian hiệu lực';
        } elseif ($voucher['time_start'] < date('Y-m-d H:i')) {
            $errorMessage['time_start'] = 'Vui lòng nhập thời gian hiệu lực';
        }

        if (!$voucher['time_end']) {
            $errorMessage['time_end'] = 'Vui lòng nhập thời gian hết hạn';
        } else if ($voucher['time_end'] <= $voucher['time_start']) {
            $errorMessage['time_end'] = 'Vui lòng nhập lại thời gian';
        } else if ($voucher['time_end'] < date('Y-m-d H:i')) {
            $errorMessage['time_end'] = 'Vui lòng nhập lại thời gian';
        }

        if ($voucher['status'] == '') {
            $errorMessage['status'] = 'Vui lòng chọn trạng thái Voucher';
        }

        if (empty($errorMessage)) {
            $created_at = Date('Y-m-d H:i:s');
            $code = strtoupper($code);
            voucher_insert($code, $quantity, $condition, $voucher_number, $status, $time_start, $time_end, $created_at);

            unset($voucher);
            $MESSAGE = 'Thêm Voucher thành công';
        }

        $VIEW_PAGE = 'add.php';
    } else if (array_key_exists('btn_add', $_REQUEST)) {
        $titlePage = 'Add Voucher';
        $VIEW_PAGE = 'add.php';
    } else if (array_key_exists('btn_update', $_REQUEST)) {
        $titlePage = 'Update Voucher';
        $voucherInfo = voucher_select_by_id($id);
        $errorMessage = [];
        $voucher = [];

        $voucher['code'] = $code ?? '';
        $voucher['quantity'] = $quantity ?? '';
        $voucher['condition'] = $condition ?? '';
        $voucher['voucher_number'] = $voucher_number ?? '';
        $voucher['time_start'] = $time_start ?? '';
        $voucher['time_end'] = $time_end ?? '';
        $voucher['status'] = $status ?? '';

        if (!$voucher['code']) {
            $errorMessage['code'] = 'Vui lòng nhập mã Voucher';
        } else if ($code != $voucherInfo['code'] && voucher_exits($code)) {
            $errorMessage['code'] = 'Vui lòng lại, Voucher đã tồn tại';
        }

        if ($voucher['quantity'] == '') {
            $errorMessage['quantity'] = 'Vui lòng nhập số lượng sử dụng Voucher';
        } else if (!is_numeric($voucher['quantity']) || $voucher['quantity'] < 0) {
            $errorMessage['quantity'] = 'Vui lòng nhập lại';
        }

        if ($voucher['condition'] == '') {
            $errorMessage['condition'] = 'Vui lòng chọn loại giảm';
        }

        if (!$voucher['voucher_number']) {
            $errorMessage['voucher_number'] = 'Vui lòng nhập mức giảm';
        } else if (!is_numeric($voucher['voucher_number']) || $voucher['voucher_number'] < 0) {
            $errorMessage['voucher_number'] = 'Vui lòng nhập lại';
        } else if ($voucher['condition'] == 0 && $voucher['voucher_number'] > 100) {
            $errorMessage['voucher_number'] = 'Vui lòng nhập lại phần trăm giảm';
        }

        if (!$voucher['time_start']) {
            $errorMessage['time_start'] = 'Vui lòng nhập thời gian hiệu lực';
        }

        if (!$voucher['time_end']) {
            $errorMessage['time_end'] = 'Vui lòng nhập thời gian hết hạn';
        } else if ($voucher['time_end'] <= $voucher['time_start']) {
            $errorMessage['time_end'] = 'Vui lòng nhập lại thời gian';
        }

        if ($voucher['status'] == '') {
            $errorMessage['status'] = 'Vui lòng chọn trạng thái Voucher';
        }

        if (empty($errorMessage)) {
            $updated_at = Date('Y-m-d H:i:s');
            $code = strtoupper($code);
            voucher_update($code, $quantity, $condition, $voucher_number, $status, $time_start, $time_end, $updated_at, $id);

            $MESSAGE = 'Cập nhật thành công, hệ thống tự động chuyển hướng sau 3s';
            header('Refresh: 3; URL = ' . $ADMIN_URL . '/voucher');
        }

        $VIEW_PAGE = 'edit.php';
    } else if (array_key_exists('btn_edit', $_REQUEST)) {
        $titlePage = 'Update Voucher';
        $voucherInfo = voucher_select_by_id($id);
        $VIEW_PAGE = 'edit.php';
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        voucher_delete($id);
        header('Location: ' . $ADMIN_URL . '/voucher');
    } else if (array_key_exists('keyword', $_REQUEST)) {
        // jquery ajax
        $listVoucher = voucher_search($keyword);
        function renderVoucher($voucher_item) {
            global $ADMIN_URL;
            $html = '
            <tr>
                <td>
                    <input type="checkbox" data-id="' . $voucher_item['id'] . '">
                </td>
                <td>' . $voucher_item['id'] . '</td>
                <td>' . $voucher_item['code'] . '</td>
                <td>' . $voucher_item['quantity'] . '</td>
                <td>
                    Giảm';

                    if ($voucher_item['condition']) {
                        $html .= number_format($voucher_item['voucher_number']) . ' VNĐ';

                    } else {
                        $html .= $voucher_item['voucher_number'] . '%';

                    }
                $html .= '
                </td>
                <td>
                    <span class="content__table-text-success">
                        ' . date_format(date_create($voucher_item['time_start']), 'd/m/Y H:i:s') . '
                    </span>
                </td>
                <td>
                    <span class="content__table-text-success">
                        ' . date_format(date_create($voucher_item['time_end']), 'd/m/Y H:i:s') . '
                    </span>
                </td>
                
                <td>';
                    if ($voucher_item['status']) {
                        $html .= '<span class="content__table-stt-active">Kích hoạt</span>';
                    } else {
                        $html .= '<span class="content__table-stt-locked">Khóa</span>';
                    }
                $html .= '
                </td>
                <td>
                    <div class="user_list-action">
                        <a onclick="return confirm(\'Bạn có chắc muốn xóa voucher này không?\') ?
                        window.location.href = \'?btn_delete&id=' . $voucher_item['id'] . ' : false;
                        " class="content__table-action danger">
                            <i class="fas fa-trash"></i>
                        </a>
                        <a href="' . $ADMIN_URL . '/voucher/?btn_edit&id=' . $voucher_item['id'] . '" class="content__table-action info">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </td>
            </tr>
            ';
            return $html;
        }
        $html = array_map('renderVoucher', $listVoucher);
        echo join('', $html);
        die();
    } else {
        $titlePage = 'List Voucher';
        // phân trang
        $totalVoucher = count(voucher_select_all());
        $limit = 10;
        $totalPage = ceil($totalVoucher / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/voucher/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;
        $listVoucher = voucher_select_all($start, $limit);
        $VIEW_PAGE = 'list.php';
    }

    require_once '../layout.php';

?>