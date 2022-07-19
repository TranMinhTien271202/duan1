
<?php

    require_once 'pdo.php';

    function order_detail_insert($order_id, $product_id, $product_size, $quantity, $price) {
        $sql = "INSERT INTO order_detail(order_id, product_id, product_size, quantity, price)
        VALUES(?, ?, ?, ?, ?)";
        pdo_execute($sql, $order_id, $product_id, $product_size, $quantity, $price);
    }

    // function order_detail_update($order_id, $product_id, $product_size, $quantity, $price, $id) {
    //     $sql = "UPDATE order_detail SET order_id = ?, product_id = ?, product_size = ?, quantity = ?, price = ? WHERE id = ?";
    //     pdo_execute($sql,$order_id, $product_id, $product_size, $quantity, $price, $id);
    // }

    // function order_detail_delete($id) {
    //     $sql = "DELETE FROM order_detail WHERE id = ?";

    //     if (is_array($id)) {
    //         foreach ($id as $id_item) {
    //             pdo_execute($sql, $id_item);
    //         }
    //     } else {
    //         pdo_execute($sql, $id);
    //     }
    // }

    function order_detail_select_all() {
        $sql = "SELECT * FROM order_detail ORDER BY id DESC";
        return pdo_query($sql);
    }

    function order_detail_select_all_by_o_id($order_id) {
        $sql = "SELECT o.*, p.product_name, p.product_image FROM order_detail o JOIN product p ON o.product_id = p.id
        WHERE o.order_id = ?";
        return pdo_query($sql, $order_id);
    }

    function order_detail_exits($id) {
        $sql = "SELECT COUNT(*) FROM order_detail WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }

?>