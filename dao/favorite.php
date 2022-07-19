<?php

    require_once 'pdo.php';

    function favorite_insert($user_id, $product_id, $created_at) {
        $sql = "INSERT INTO favorite_products(user_id, product_id, created_at) VALUES(?, ?, ?)";
        pdo_execute($sql, $user_id, $product_id, $created_at);
    }

    function favorite_delete($id) {
        $sql = "DELETE FROM favorite_products WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function favorite_exits($user_id, $product_id) {
        $sql = "SELECT * FROM favorite_products WHERE user_id = ? AND product_id = ?";
        return pdo_query_one($sql, $user_id, $product_id);
    }

    // ds sp yêu thích theo user
    function favorite_select_by_uid($user_id) {
        $sql = "SELECT p.*, f.created_at AS time_heart, f.id AS heart_id FROM favorite_products f JOIN product p ON f.product_id = p.id
        WHERE f.user_id = ?";
        return pdo_query($sql, $user_id);
    }

?>