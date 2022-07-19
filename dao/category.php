
<?php
    require_once 'pdo.php';

    function category_insert($cate_name, $cate_image) {
        $sql = "INSERT INTO category(cate_name, cate_image)
        VALUES(?, ?)";
        pdo_execute($sql, $cate_name, $cate_image);
    }

    function category_update($ten_loai, $cate_image, $id) {
        $sql = "UPDATE category SET cate_name = ?, cate_image = ? WHERE id = ?";
        pdo_execute($sql, $ten_loai, $cate_image, $id);
    }

    function category_delete($id) {
       $sql = "DELETE FROM category WHERE id = ?";
 
        if(is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function category_select_all() {
        $sql = "SELECT * FROM category ORDER BY id DESC";
        return pdo_query($sql);
    }

    // danh sách loại hàng + số lượng sp (còn hàng) ở trang chủ
    function category_home_select_all() {
        $sql = "SELECT c.*, COUNT(*) AS totalProduct
        FROM category c JOIN product p ON c.id = p.cate_id
        WHERE p.`status` = 1 GROUP BY c.id";
        return pdo_query($sql);
    }

    function category_select_by_id($id) {
        $sql = "SELECT * FROM category WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    function category_exits($id) {
        $sql = "SELECT COUNT(*) FROM category WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }
    function category_name_exist($ten_loai) {
        $sql = "SELECT COUNT(*) FROM category WHERE cate_name = ?";
        return pdo_query_value($sql, $ten_loai) > 0;
    }

    function loai_hang_search($keyword) {
        $sql = "SELECT * FROM category WHERE cate_name LIKE ? ORDER BY id DESC";
        return pdo_query($sql, '%'.$keyword.'%');
    }

    function loai_hang_quantity() {
        $sql = "SELECT COUNT(*) FROM category";
        return pdo_query_value($sql);
    }

?>