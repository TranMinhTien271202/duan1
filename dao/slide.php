
<?php

    require_once 'pdo.php';

    function slide_insert($title, $slide_image, $url) {
        $sql = "INSERT INTO slide (title, slide_image, url)
        VALUES(?, ?, ?)";
        pdo_execute($sql, $title, $slide_image, $url);
    }

    function slide_update($title, $slide_image, $url, $id) {
        $sql = "UPDATE slide SET title = ?, slide_image = ?, url = ? WHERE id = ?";
        pdo_execute($sql, $title, $slide_image, $url, $id);
    }

    function slide_delete($id) {
        $sql = "DELETE FROM slide WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function slide_select_all() {
        $sql = "SELECT * FROM slide ORDER BY id DESC";
        return pdo_query($sql);
    }

    function slide_select_by_id($id) {
        $sql = "SELECT * FROM slide WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    function slide_exits($id) {
        $sql = "SELECT COUNT(*) FROM slide WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }
    function slide_quantity() {
        $sql = "SELECT COUNT(*) FROM slide";
        return pdo_query_value($sql);
    }
?>