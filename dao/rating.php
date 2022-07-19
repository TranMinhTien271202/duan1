
<?php

    require_once 'pdo.php';

    function rating_insert($product_id, $user_id, $rating_number) {
        $sql = "INSERT INTO rating(product_id, user_id, rating_number )
        VALUES(?, ?, ?)";
        pdo_execute($sql, $product_id, $user_id, $rating_number);
    }

    function rating_update($product_id, $user_id, $rating_number, $id) {
        $sql = "UPDATE rating SET product_id = ?, user_id = ?, rating_number = ? WHERE id = ?";
        pdo_execute($sql, $product_id, $user_id, $rating_number, $id);
    }

    function rating_delete($id) {
        $sql = "DELETE FROM rating WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function rating_select_all() {
        $sql = "SELECT * FROM rating ORDER BY id DESC";
        return pdo_query($sql);
    }

    function rating_select_by_id($id) {
        $sql = "SELECT * FROM rating WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    function rating_exits($p_id, $u_id) {
        $sql = "SELECT * FROM rating WHERE product_id = ? AND user_id = ?";
        return pdo_query_one($sql, $p_id, $u_id);;
    }

    // lấy số lượt đánh giá
    function rating_select_by_p_id($product_id) {
        $sql = "SELECT COUNT(*) AS total, AVG(rating_number) AS rating FROM rating WHERE product_id = ?";
        return pdo_query_one($sql, $product_id);
    }

?>