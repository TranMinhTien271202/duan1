
<?php

    require_once 'pdo.php';

    function voucher_insert($code, $quantity, $condition, $voucher_number, $status, $time_start, $time_end, $created_at) {
        $sql = "INSERT INTO voucher(code, quantity, `condition`, voucher_number, status, time_start, time_end, created_at)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        pdo_execute($sql, $code, $quantity, $condition, $voucher_number, $status, $time_start, $time_end, $created_at);
    }

    function voucher_update($code, $quantity, $condition, $voucher_number, $status, $time_start, $time_end, $updated_at, $id) {
        $sql = "UPDATE voucher SET code = ?, quantity = ?, `condition` = ?, voucher_number = ?, status = ?, time_start = ?, time_end = ?, updated_at = ? WHERE id = ?";
        pdo_execute($sql, $code, $quantity, $condition, $voucher_number, $status, $time_start, $time_end, $updated_at, $id);
    }

    function voucher_delete($id) {
        $sql = "DELETE FROM voucher WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function voucher_select_all($start = 0, $limit = 0) {
        $sql = "SELECT * FROM voucher ORDER BY id DESC";
        if ($limit && $start >= 0) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql);
    }

    function voucher_select_by_id($id) {
        $sql = "SELECT * FROM voucher WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    // kiểm tra voucher tồn tại
    function voucher_exits($code) {
        $sql = "SELECT * FROM voucher WHERE code = ?";
        return pdo_query_one($sql, $code);
    }

    function voucher_search($keyword) {
        $sql = "SELECT * FROM voucher WHERE code LIKE ?";
        return pdo_query($sql, '%'.$keyword.'%');
    }

    function voucher_select_by_code($code) {
        $sql = "SELECT * FROM voucher WHERE code = ?";
        return pdo_query_one($sql, $code);
    }

    // cập nhật số lượng vc
    function voucher_update_qnt($id) {
        $sql = "UPDATE voucher SET quantity = quantity - 1 WHERE id = ?";
        pdo_execute($sql, $id);
    }

    // kiểm tra khách hàng đã sd voucher
    function voucher_check_user_used($user_id, $voucher_code) {
        $sql = "SELECT * FROM voucher WHERE `code` = ?";
        $used_ids = pdo_query_one($sql, $voucher_code);

        // nếu chưa có id user nào
        if (!$used_ids['used_id']) {
            return false;
        } else {
            $used_ids = explode(',', $used_ids['used_id']);
            $isUserUsed = false;

            foreach ($used_ids as $id) {
                if ($id == $user_id) {
                    $isUserUsed = true;
                }
            }

            return $isUserUsed;
        }

    }

    // insert id người sd voucher
    function voucher_insert_user_used($user_id, $voucher_id) {
        $sql = "SELECT * FROM voucher WHERE id = ?";
        $used_ids = pdo_query_one($sql, $voucher_id);

        $sql_update_used_id = "UPDATE voucher SET used_id = ? WHERE id = ?";

        // nếu chưa có id nào sử dụng vc
        if (!$used_ids['used_id']) {
            pdo_execute($sql_update_used_id, $user_id, $voucher_id);
        } else {
            $used_id_arr = explode(',', $used_ids['used_id']);
            $used_id_arr[] = $user_id;
            $user_id_str = implode(',', $used_id_arr);
            pdo_execute($sql_update_used_id, $user_id_str, $voucher_id);
        }
    }
?>