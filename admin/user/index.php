<?php

    require_once '../../global.php';
    require_once '../../dao/user.php';
    
    check_login();

    extract($_REQUEST);

    if (array_key_exists('btn_insert', $_REQUEST)) {
        $titlePage = 'Add User';
        $errorMessage = [];
        $user = [];

        $user['username'] = $username ?? '';
        $user['fullName'] = $fullName ?? '';
        $user['password'] = $password ?? '';
        $user['confirm'] = $confirm ?? '';
        $user['address'] = $address ?? '';
        $user['phone'] = $phone ?? '';
        $user['email'] = $email ?? '';
        $user['role'] = $role ?? '';
        $user['active'] = $active ?? '';
        

        if (!$user['fullName']) {
            $errorMessage['fullName'] = 'Vui lòng nhập họ tên';
        } else if (!preg_match('/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+$/', $user['fullName'])) {
            $errorMessage['fullName'] = 'Vui lòng nhập lại, họ tên không đúng định dạng';
        }

        if (!$user['username']) {
            $errorMessage['username'] = 'Vui lòng nhập tên đăng nhập';
        } else if (!preg_match('/^[a-zA-Z0-9.\-_$@*!]{3,30}$/', $user['username'])) {
            $errorMessage['username'] = 'Vui lòng nhập lại, tên đăng nhập không đúng định dạng';
        } else if (user_exits($user['username'])) {
            $errorMessage['username'] = 'Vui lòng nhập lại, tên đăng nhập đã tồn tại';
        }

        if (!$user['password']) {
            $errorMessage['password'] = 'Vui lòng nhập mật khẩu';
        } else if (strlen($user['password']) < 3) {
            $errorMessage['password'] = 'Vui lòng nhập lại, mật khẩu tối thiểu 3 ký tự';
        }

        if (!$user['confirm']) {
            $errorMessage['confirm'] = 'Vui lòng nhập mật khẩu xác nhận';
        } else if ($user['password'] != $user['confirm']) {
            $errorMessage['confirm'] = 'Vui lòng nhập lại, mật khẩu xác nhận không chính xác';
        }

        if (!$user['address']) {
            $errorMessage['address'] = 'Vui lòng nhập địa chỉ';
        }

        if (!$user['phone']) {
            $errorMessage['phone'] = 'Vui lòng nhập số điện thoại';
        } else if (!preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $user['phone'])) {
            $errorMessage['phone'] = 'Vui lòng nhập lại, số điện thoại không đúng định dạng';
        }

        if (!$user['email']) {
            $errorMessage['email'] = 'Vui lòng nhập email';
        } else if (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $user['email'])) {
            $errorMessage['email'] = 'Vui lòng nhập lại, email không đúng định dạng';
        } else if (khach_hang_email_exits($user['email'])) {
            $errorMessage['email'] = 'Vui lòng nhập lại, email đã tồn tại';
        }

       
      $created_at = Date('Y-m-d H:i:s');

        if (empty($errorMessage)) {
            $avatar = save_file('avatar', $IMG_PATH . '/');
            $avatar = strlen($avatar) > 0 ? $avatar : 'image_default.png';
            $mat_khau = password_hash($password, PASSWORD_DEFAULT);

            user_insert($username, $mat_khau, $email, $phone, $fullName, $address, $avatar, $active, $role, $created_at);
            $MESSAGE = 'Thêm thành công';
            unset($user);
        }

        $VIEW_PAGE = 'add.php';
    } else if (array_key_exists('btn_add', $_REQUEST)) {
        $titlePage = 'Add User';
        $VIEW_PAGE = 'add.php';
    } else if (array_key_exists('btn_update', $_REQUEST)) {
        $titlePage = 'Edit User';
        $userData = user_select_by_id($ma_kh);
        $user = [];
        $errorMessage = [];

        $user['username'] = $username ?? '';
        $user['fullName'] = $fullName ?? '';
        $user['password'] = $password ?? '';
        $user['confirm'] = $confirm ?? '';
        $user['address'] = $address ?? '';
        $user['phone'] = $phone ?? '';
        $user['email'] = $email ?? '';
        $user['role'] = $role ?? '';
        $user['active'] = $active ?? '';

        if (!$user['password']) {
            $errorMessage['password'] = 'Vui lòng nhập mật khẩu';
        } else if (strlen($user['password']) < 3) {
            $errorMessage['password'] = 'Vui lòng nhập lại, mật khẩu tối thiểu 3 ký tự';
        }

        if (!$user['confirm']) {
            $errorMessage['confirm'] = 'Vui lòng nhập mật khẩu xác nhận';
        } else if ($user['password'] != $user['confirm']) {
            $errorMessage['confirm'] = 'Vui lòng nhập lại, mật khẩu xác nhận không chính xác';
        } else {
            $newPassword = ($user['password'] != $userData['password']) ? password_hash($password, PASSWORD_DEFAULT) : $password;
        }

        if (!$user['fullName']) {
            $errorMessage['fullName'] = 'Vui lòng nhập họ tên';
        } else if (!preg_match('/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+$/', $user['fullName'])) {
            $errorMessage['fullName'] = 'Vui lòng nhập lại, họ tên không đúng định dạng';
        }

        if (!$user['address']) {
            $errorMessage['address'] = 'Vui lòng nhập địa chỉ';
        }

        if (!$user['phone']) {
            $errorMessage['phone'] = 'Vui lòng nhập số điện thoại';
        } else if (!preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $user['phone'])) {
            $errorMessage['phone'] = 'Vui lòng nhập lại, số điện thoại không đúng định dạng';
        }

        if (!$user['email']) {
            $errorMessage['email'] = 'Vui lòng nhập email';
        } else if (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $user['email'])) {
            $errorMessage['email'] = 'Vui lòng nhập lại, email không đúng định dạng';
        } else if ($user['email'] != $userData['email'] && khach_hang_email_exits($user['email'])) {
            $errorMessage['email'] = 'Vui lòng nhập lại, email đã tồn tại';
        }

        if (empty($errorMessage)) {
            $anh = save_file('avatar', $IMG_PATH . '/');
            $anh = strlen($anh) > 0 ? $anh : $userData['avatar'];

            user_update($newPassword, $email, $phone, $fullName, $address, $anh, $active, $role, $ma_kh);

            $MESSAGE = 'Cập nhật thành công, vui lòng đợi 3s';
            header('Refresh: 3; URL = ' . $ADMIN_URL . '/user');
        }

        $VIEW_PAGE = 'edit.php';
    } else if (array_key_exists('btn_edit', $_REQUEST)) {
        $titlePage = 'Edit User';
        $userData = user_select_by_id($ma_kh);
        $VIEW_PAGE = 'edit.php';
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        // không xóa chính mình
        if (is_array($id)) {
            foreach ($id as $item) {
                if ($_SESSION['user']['id'] != $item) {
                    user_delete($item);
                } else {
                    echo
                    '<script>
                        alert("Bạn không thể xóa chính bạn")
                        window.location.href = "'.$ADMIN_URL . '/user'.'"
                    </script>
                    ';
                }
            }
        } else {
            if ($_SESSION['user']['id'] != $id) {
                user_delete($id);
                header('Location: ' . $ADMIN_URL . '/user');
            } else {
                echo
                '<script>
                    alert("Bạn không thể xóa chính bạn")
                    window.location.href = "'.$ADMIN_URL . '/user'.'"
                </script>
                ';
            }
        }

    } else if (array_key_exists('btn_lock', $_REQUEST)) {
        if ($_SESSION['user']['id'] != $ma_kh) {
            khach_hang_action($ma_kh, 'lock');
            header('Location: ' . $ADMIN_URL . '/user');
        } else {
            echo
            '<script>
                alert("Bạn không thể khóa chính bạn")
                window.location.href = "'.$ADMIN_URL . '/user'.'"
            </script>
            ';
        }
    } else if (array_key_exists('btn_unlock', $_REQUEST)) {
        khach_hang_action($ma_kh, 'unlock');
        header('Location: ' . $ADMIN_URL . '/user');
    } else if (array_key_exists('keyword', $_REQUEST)) {
        $titlePage = 'Search User';
        $userList = user_search($keyword);
        $VIEW_PAGE = 'search.php';
    } else {
        $titlePage = 'List User';
        $limit = 10;
        $totalUser = user_quantity();
        $totalPage = ceil($totalUser / $limit);
        $currentPage = $page ?? 1;
        
        if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        } else if ($currentPage < 0) {
            $currentPage = 1;
        }
        
        $start = ($currentPage - 1) * $limit;

        $userList = user_select_all($start, $limit);

        $VIEW_PAGE = 'list.php';
    }
    

    require_once '../layout.php';

?>