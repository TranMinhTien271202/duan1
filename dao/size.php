<?php

    require_once 'pdo.php';

    function size_insert($product_size, $price_increase, $created_at, $updated_at) {
        $sql = "INSERT INTO size(product_size, price_increase, created_at, updated_at) VALUES(?, ?, ?, ?)";
        pdo_execute($sql, $product_size, $price_increase, $created_at, $updated_at);
    }

    function size_update($product_size, $price_increase, $updated_at, $id) {
        $sql = "UPDATE size SET product_size = ?, price_increase = ?, updated_at = ? WHERE id = ?";
        pdo_execute($sql, $product_size, $price_increase, $updated_at, $id);
    }

    function size_delete($id) {
        $sql = "DELETE FROM size WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function size_select_by_id($id) {
        $sql = "SELECT * FROM size WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    function size_select_by_size($product_size) {
        $sql = "SELECT * FROM size WHERE product_size = ?";
        return pdo_query_one($sql, $product_size);
    }

    function size_select_all($order_by = 'id') {
        $sql = "SELECT * FROM size";
        if ($order_by == 'size') {
            $sql .= " ORDER BY product_size DESC";
        } else {
            $sql .= " ORDER BY id DESC";
        }
        return pdo_query($sql);
    }

    // kiểm tra size tồn tại
    function size_exits($product_size) {
        $sql = "SELECT COUNT(*) FROM size WHERE product_size = ?";
        return pdo_query_value($sql, $product_size) > 0;
    }

?>