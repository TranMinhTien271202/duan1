
<?php

    require_once 'pdo.php';

    function settings_insert($title, $logo, $phone, $email, $address, $map, $facebook, $youtube, $instagram, $tiktok, $status) {
        $sql = "INSERT INTO settings(title, logo, phone, email, address, map, facebook, youtube, instagram, tiktok, status)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        pdo_execute($sql, $title, $logo, $phone, $email, $address, $map, $facebook, $youtube, $instagram, $tiktok, $status);
    }

    function settings_update($title, $logo, $phone, $email, $address, $map, $facebook, $youtube, $instagram, $tiktok, $status) {
        $sql = "UPDATE settings SET title = ?, logo = ?, phone = ?, email = ?, address = ?, map = ?, facebook = ?, youtube = ?, instagram = ?, tiktok = ?, status = ?";
        pdo_execute($sql, $title, $logo, $phone, $email, $address, $map, $facebook, $youtube, $instagram, $tiktok, $status);
    }

    // function settings_delete($id) {
    //     $sql = "DELETE FROM settings WHERE id = ?";

    //     if (is_array($id)) {
    //         foreach ($id as $id_item) {
    //             pdo_execute($sql, $id_item);
    //         }
    //     } else {
    //         pdo_execute($sql, $id);
    //     }
    // }

    function settings_select_all() {
        $sql = "SELECT * FROM settings";
        return pdo_query_one($sql);
    }

    // function settings_select_by_id($id) {
    //     $sql = "SELECT * FROM settings WHERE id = ?";
    //     return pdo_query_one($sql, $id);
    // }

    // function settings_exits($id) {
    //     $sql = "SELECT COUNT(*) FROM settings WHERE id = ?";
    //     return pdo_query_value($sql, $id) > 0;
    // }

?>