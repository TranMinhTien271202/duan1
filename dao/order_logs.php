<?php

    require_once 'pdo.php';

    function log_select_by_oid($order_id) {
        $sql = "SELECT o.customer_name, o.phone, o.address, o.email, l.created_at,
        l.`status`, u.username, u.fullName, o.created_at AS time_order, o.message, l.user_id
        FROM (order_logs l JOIN `order` o ON l.order_id = o.id)
        LEFT JOIN `user` u ON l.user_id = u.id
        WHERE l.order_id = ?
        GROUP BY l.`status`";
        return pdo_query($sql, $order_id);
    }

    function log_insert($order_id, $status, $user_id, $created_at) {
        $sql = "INSERT INTO order_logs (order_id, status, user_id, created_at) VALUES(?, ?, ?, ?)";
        pdo_execute($sql, $order_id, $status, $user_id, $created_at);
    }

?>