<?php

    require_once '../../global.php';
    require_once '../../dao/user.php';

    extract($_REQUEST);

    if (array_key_exists('btn_register', $_REQUEST)) {
        // đăng ký
        $errorMessage = [];
        $user_dk = [];

        $user_dk['username'] = $username ?? '';
        $user_dk['password'] = $password ?? '';
        $user_dk['confirm'] = $confirm ?? '';
        $user_dk['fullName'] = $fullName ?? '';
        $user_dk['phone']= $phone ?? '';
        $user_dk['email'] = $email ?? '';

        if (!$user_dk['fullName']) {
            $errorMessage['fullName'] = 'Vui lòng nhập họ tên';
        } else if (!preg_match('/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+$/', $user_dk['fullName'])) {
            $errorMessage['fullName'] = 'Vui lòng nhập lại, họ tên không đúng định dạng';
        }

        if (!$user_dk['username']) {
            $errorMessage['username'] = 'Vui lòng nhập tên đăng nhập';
        } else if (!preg_match('/^[a-zA-Z0-9.\-_$@*!]{3,30}$/', $user_dk['username'])) {
            $errorMessage['username'] = 'Vui lòng nhập lại, tên đăng nhập không đúng định dạng';
        } else if (username_exits($user_dk['username'])) {
            $errorMessage['username'] = 'Vui lòng nhập lại, tên đăng nhập đã tồn tại';
        }

        if (!$user_dk['password']) {
            $errorMessage['password'] = 'Vui lòng nhập mật khẩu';
        } else if (strlen($user_dk['password']) < 3) {
            $errorMessage['password'] = 'Vui lòng nhập lại, mật khẩu tối thiểu 3 ký tự';
        }

        if (!$user_dk['confirm']) {
            $errorMessage['confirm'] = 'Vui lòng nhập mật khẩu xác nhận';
        } else if ($user_dk['password'] != $user_dk['confirm']) {
            $errorMessage['confirm'] = 'Vui lòng nhập lại, mật khẩu xác nhận không chính xác';
        }

        if (!$user_dk['phone']) {
            $errorMessage['phone'] = 'Vui lòng nhập số điện thoại';
        } else if (!preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $user_dk['phone'])) {
            $errorMessage['phone'] = 'Vui lòng nhập lại, số điện thoại không đúng định dạng';
        }

        if (!$user_dk['email']) {
            $errorMessage['email'] = 'Vui lòng nhập email';
        } else if (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $user_dk['email'])) {
            $errorMessage['email'] = 'Vui lòng nhập lại, email không đúng định dạng';
        } else if (khach_hang_email_exits($user_dk['email'])) {
            $errorMessage['email'] = 'Vui lòng nhập lại, email đã tồn tại';
        }

        if (empty($errorMessage)) {
            $password = password_hash($user_dk['password'], PASSWORD_DEFAULT);
            $created_at = Date('Y-m-d H:i:s');
            $avatar = "image_default.png";
            $active = 1;
            $role = 0;
            $address = '';
            
            $last_id = user_insert($username, $password, $email, $phone, $fullName, $address, $avatar, $active, $role, $created_at);
            unset($user_dk);

            $user_info = user_select_by_id($last_id);
            $_SESSION['user'] = $user_info;
            $MESSAGE = 'Đăng ký thành công, hệ thống tự động đăng nhập sau 3s';
            header('Refresh: 3; URL = ' . $SITE_URL);
        }

        
        $VIEW_PAGE = 'register.php';
    } else if (array_key_exists('register', $_REQUEST)) {
        if (check_user_logged()) {
            header('Location: ' . $SITE_URL);
        }
        $VIEW_PAGE = 'register.php';
    } else if (array_key_exists('btn_forgot', $_REQUEST)) {
        $getUser = user_exits($user);

        $userInfo = [];
        $errorMessage = [];

        $userInfo['user'] = $user ?? '';

        if (!$userInfo['user']) {
            $errorMessage['user'] = 'Vui lòng nhập tên đăng nhập hoặc email';
        } else if (!$getUser) {
            $errorMessage['user'] = 'Tên đăng nhập hoặc email không tồn tại trên hệ thống';
        }

        if (empty($errorMessage)) {
            // gửi email
            $token = user_send_reset_pass($getUser['email'], $getUser['fullName']);

            // insert mã token
            user_token_insert($token, $getUser['id']);
            
            unset($userInfo);
            $MESSAGE = 'Email khôi phục mật khẩu đã được gửi. Vui lòng kiểm tra Email và click vào link xác nhận để đổi mật khẩu.';
        }

        $VIEW_PAGE = "forgot_pass.php";
    } else if (array_key_exists('forgot_pass', $_REQUEST)) {
        $VIEW_PAGE = "forgot_pass.php";
    } else if (array_key_exists('btn_update_pass', $_REQUEST)) {
        $getUser = user_exits_by_options('token', $code);

        $passInfo = [];
        $errorMessage = [];

        $passInfo['new_password'] = $new_password ?? '';
        $passInfo['confirm_password'] = $confirm_password ?? '';

        if (!$passInfo['new_password']) {
            $errorMessage['new_password'] = 'Vui lòng nhập mật khẩu mới';
        } else if (strlen($passInfo['new_password']) < 3) {
            $errorMessage['new_password'] = 'Mật khẩu tối thiểu 3 ký tự';
        }

        if (!$passInfo['confirm_password']) {
            $errorMessage['confirm_password'] = 'Vui lòng xác nhận mật khẩu';
        } else if (strlen($passInfo['confirm_password']) < 3) {
            $errorMessage['confirm_password'] = 'Mật khẩu tối thiểu 3 ký tự';
        } else if ($passInfo['new_password'] != $passInfo['confirm_password']) {
            $errorMessage['confirm_password'] = 'Mật khẩu xác nhận không chính xác, vui lòng nhập lại';
        }

        if (empty($errorMessage)) {
            // update password
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            user_change_pass($new_password, $getUser['id']);

            // delete token
            user_token_delete($getUser['id']);

            // gửi mail thông báo đổi mật khẩu thành công
            user_changed_pass($getUser['email'], $getUser['fullName']);

            unset($passInfo);
            $MESSAGE = 'Đổi mật khẩu thành công';

            header('Refresh: 5; URL = ' . $SITE_URL . '/account');
        }

        $VIEW_PAGE = "forgot_code.php";
    } else if (array_key_exists('code', $_REQUEST)) {
        // khi click link reset pass
        // nếu mã xác nhận ko tồn tại
        $getUser = user_exits_by_options('token', $code);
        if (empty($getUser)) header('Location: ' . $SITE_URL);
        $VIEW_PAGE = "forgot_code.php";
    } else if (array_key_exists('btn_login', $_REQUEST)) {
        $userInfo = [];
        $errorMessage = [];

        $userInfo['user'] = $user ?? '';
        $userInfo['password'] = $password ?? '';

        if (!$userInfo['user']) {
            $errorMessage['user'] = 'Vui lòng nhập tên tài khoản hoặc email';
        }

        if (!$userInfo['password']) {
            $errorMessage['password'] = 'Vui lòng nhập mật khẩu';
        }

        if (empty($errorMessage)) {
            // nếu tồn tại username hoặc pass
            $getUser = user_exits($user);
            if ($getUser) {
                // check user locked
                if ($getUser['active']) {
                    // check password
                    if (password_verify($password, $getUser['password'])) {
                        $_SESSION['user'] = $getUser;
                        
                        // nếu click đăng nhập ở trang chi tiết sp
                        if (isset($page, $id)) {
                            header('Location: ' . $SITE_URL . '/product/?detail&id=' . $id);
                        } else if ($getUser['role']) {
                            // đăng nhập với vai trò QTV => dashboard
                            header('Location: ' . $ADMIN_URL);
                        } else {
                            header('Location: ' . $SITE_URL);
                        }
                    } else {
                        $errorMessage['password'] = 'Mật khẩu không chính xác, vui lòng nhập lại';
                    }
                } else {
                    $errorMessage['user'] = 'Tên tài khoản của bạn đã bị khóa, vui lòng liên hệ QTV';
                }
            } else {
                $errorMessage['user'] = 'Tên tài khoản hoặc email không tồn tại trên hệ thống';
            }
        }

        $VIEW_PAGE = "login.php";
    } else {
        if (check_user_logged()) {
            header('Location: ' . $SITE_URL);
        }
        $VIEW_PAGE = "login.php";
    }

    require_once '../layout.php';

?>