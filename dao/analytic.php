<?php

    require_once 'pdo.php';

    // thống kê tài khoản (khóa, hoạt động)
    function analytics_user() {
        $sql = "SELECT active, COUNT(*) AS total FROM `user` GROUP BY active ORDER BY active DESC";
        return pdo_query($sql);
    }

    // thống kê kh đăng ký theo tháng
    function analytics_user_reg() {
        $sql = "SELECT MONTH(created_at) AS month, COUNT(*) AS total FROM `user` GROUP BY MONTH(created_at)";
        return pdo_query($sql);
    }

    // thống kê doanh thu theo tháng
    function analytics_price() {
        $sql = "SELECT MONTH(created_at) AS month, SUM(total_price) AS totalPrice FROM `order` WHERE status = 3 GROUP BY MONTH(created_at)";
        return pdo_query($sql);
    }
    
    // thống kê số lượng sản phẩm theo danh mục
    function analytics_quantity_product_by_cate() {
        $sql = "SELECT c.cate_name, c.cate_image, c.id, COUNT(*) AS totalProduct FROM product p JOIN category c ON p.cate_id = c.id GROUP BY c.id ORDER BY c.id DESC";
        return pdo_query($sql);
    }

    // thống kê giá sản phẩm theo danh mục
    function analytics_cate_by_product() {
        $sql = "SELECT c.cate_name, COUNT(*) AS totalProduct, MIN(p.price) AS minPrice, MAX(p.price) AS maxPrice, AVG(p.price) AS avgPrice
        FROM category c JOIN product p ON c.id = p.cate_id
        GROUP BY c.id";
        return pdo_query($sql);
    }

    // thống kê đơn hàng (mới, đã hủy)
    function analytics_select_totalOrder_by_stt($status) {
        $sql = "SELECT COUNT(*) AS total FROM `order` WHERE `status` = ?";
        return pdo_query_value($sql, $status);
    }

    // thống kê tổng doanh thu (stt3 - đã giao)
    function analytics_total_money() {
        $sql = "SELECT SUM(total_price) AS total FROM `order` WHERE status = 3";
        return pdo_query_one($sql);
    }

    // thống kê sp bán chạy
    function analytics_product_trend() {
        $sql = "SELECT p.*, SUM(o.quantity) AS total
        FROM ((order_detail o JOIN product p ON o.product_id = p.id)
        JOIN `order` od ON o.order_id = od.id)
        WHERE od.`status` = 3
        GROUP BY p.id
        ORDER BY SUM(o.quantity) DESC
        LIMIT 10";
        return pdo_query($sql);
    }
?>