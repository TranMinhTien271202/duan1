<?php
    require_once 'pdo.php';
    // Thêm
    function table_insert($name, $guest_number, $status){
        $sql = "INSERT INTO `table`(name, guest_number, status) VALUES(?,?,?)";
        pdo_execute($sql,$name, $guest_number, $status );
    }
    // Cập nhật
    function table_edit($name, $guest_number, $status, $id){
        $sql = "UPDATE `table` SET name = ?, guest_number = ?, status = ? WHERE id = ?";
        pdo_execute($sql, $name, $guest_number, $status, $id);
    }
    // Xóa
    function table_delete($id) {
        $sql = "DELETE FROM `table` WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }
    // Lấy ra danh sách bàn
    function table_select_all($start = 0, $limit = 0) {
        $sql = "SELECT * FROM `table` ORDER BY id DESC";
        if ($limit) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql);
    }

    // Lấy 1 bàn
    function table_select_by_id($id){
        $sql = "SELECT * FROM `table` WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    //Kiểm tra đã tồn tại bàn hay chưa
    function table_exits($name){
        $sql = "SELECT * FROM `table` WHERE `name` = ?";
        return pdo_query_one($sql, $name);
    }

    function table_search($keywords){
        $sql = "SELECT * FROM `table` WHERE `name` LIKE ? ORDER BY id DESC";
        return pdo_query($sql, '%'.$keywords.'%');
    }

    // lấy bàn trống
    function table_select_exits() {
        $sql = "SELECT * FROM `table` WHERE status = 0";
        return pdo_query($sql);
    }

    function table_update_stt($stt, $id) {
        $sql = "UPDATE `table` SET status = ? WHERE id = ?";
        pdo_execute($sql, $stt, $id);
    }
?>