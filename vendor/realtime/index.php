<?php

    require_once '../../global.php';
    require_once '../../dao/order.php';

    extract($_REQUEST);

    if (array_key_exists('get_total_order', $_REQUEST)) {
        $totalOrder = count(order_select_all());
        echo $totalOrder;
    } else if (array_key_exists('get_new_order', $_REQUEST)) {
        $newOrder = order_select_all(0, $newOrderQuantity);
        echo json_encode($newOrder);
    } else if (array_key_exists('check_admin_login', $_REQUEST)) {
        if (isset($_SESSION['user']) && $_SESSION['user']['role']) {
            echo true;
        }
        echo false;
    }

?>