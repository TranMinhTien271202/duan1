
<?php

    require_once 'pdo.php';

    function comment_insert($content, $product_id, $user_id, $comment_parent_id, $created_at) {
        $sql = "INSERT INTO comment(content, product_id, user_id, comment_parent_id,  created_at)
        VALUES(?, ?, ?, ?, ?)";
        return pdo_execute($sql, $content, $product_id, $user_id, $comment_parent_id, $created_at);
    }

    // function comment_update($content, $product_id, $user_id, $comment_parent_id,  $created_at, $id) {
    //     $sql = "UPDATE comment SET content = ?, product_id = ?, user_id = ?, comment_parent_id = ?,  created_at = ? WHERE id = ?";
    //     pdo_execute($sql, $content, $product_id, $user_id, $comment_parent_id,  $created_at, $id);
    // }

    function comment_delete($id) {
        $sql = "DELETE FROM comment WHERE id = ? OR comment_parent_id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item, $id_item);
            }
        } else {
            pdo_execute($sql, $id, $id);
        }
    }

    // lấy bình luận theo id
    function comment_select_by_id($id) {
        $sql = "SELECT u.fullName, u.avatar, c.*, r.rating_number
        FROM ((`comment` c JOIN `user` u ON c.user_id = u.id)
        LEFT JOIN rating r ON u.id = r.user_id AND c.product_id = r.product_id)
        WHERE c.id = ?";
        return pdo_query_one($sql, $id);
    }
    // function comment_select_by_id($id) {
    //     $sql = "SELECT c.*, u.fullName, u.avatar FROM `comment` c JOIN `user` u ON c.user_id = u.id WHERE c.id = ?";
    //     return pdo_query_one($sql, $id);
    // }

    // lấy bình luận + rating theo id
    

    // lấy danh sách bình luận theo mã sp (be)
    // function comment_select_all_by_pid($p_id, $start = 0, $limit = 0) {
    //     $sql = "SELECT c.*, u.fullName, u.username, p.product_name FROM ((`comment` c JOIN product p ON c.product_id = p.id)
    //     JOIN `user` u ON c.user_id = u.id) WHERE p.id = ? ORDER BY c.id DESC";
    //     if ($limit) {
    //         $sql .= " LIMIT $start, $limit";
    //     }
    //     return pdo_query($sql, $p_id);
    // }

    // lấy danh sách bình luận + đánh giá theo mã sp (fe + be)
    function comment_home_select_all_by_pid($product_id, $start = 0, $limit = 0) {
        $sql = "SELECT u.fullName, u.avatar, u.username, c.*, r.rating_number
        FROM ((`comment` c JOIN `user` u ON c.user_id = u.id)
        LEFT JOIN rating r ON u.id = r.user_id AND c.product_id = r.product_id)
        WHERE c.product_id = ?
        ORDER BY c.created_at DESC
        ";
        if ($limit) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql, $product_id);
    }

    // tìm kiếm (js)
    function comment_detail_search($p_id, $content = '', $u_id = 0, $rating = 0) {
        $sql = "SELECT u.fullName, u.avatar, u.username, c.*, r.rating_number
        FROM ((`comment` c JOIN `user` u ON c.user_id = u.id)
        LEFT JOIN rating r ON u.id = r.user_id AND c.product_id = r.product_id)
        WHERE c.product_id = ?";


        if ($content) {
            $sql .= " AND c.content LIKE '%$content%'";
        }
        
        if ($u_id) {
            $sql .= " AND c.user_id = $u_id";
        }
        
        if ($rating) {
            $sql .= " AND r.rating_number = $rating";
        }
        
        $sql .= " ORDER BY c.created_at DESC";
        return pdo_query($sql, $p_id);
    }

    function comment_exits($id) {
        $sql = "SELECT COUNT(*) FROM comment WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }

    // thống kê bình luận theo sản phẩm
    function comment_select_all($start = 0, $limit = 0) {
        $sql = "SELECT p.product_name, p.id, COUNT(*) AS totalComment, MIN(c.created_at) AS oldest, MAX(c.created_at) AS latest
        FROM `comment` c JOIN product p ON c.product_id = p.id GROUP BY p.id ORDER BY c.id DESC";
        if ($limit) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql);
    }

    // tìm kiếm cmt theo tên sp
    function comment_search($keyword) {
        $sql = "SELECT p.product_name, p.id, COUNT(*) AS totalComment, MIN(c.created_at) AS oldest, MAX(c.created_at) AS latest
        FROM `comment` c JOIN product p ON c.product_id = p.id WHERE 1";

        if ($keyword) {
            $sql .= " AND p.product_name LIKE ? GROUP BY p.id ORDER BY c.id DESC";
            return pdo_query($sql, '%'.$keyword.'%');
        }

        $sql .= " GROUP BY p.id ORDER BY c.id DESC";
        return pdo_query($sql);
    }

?>