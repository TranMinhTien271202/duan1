
<?php

    require_once 'pdo.php';

    function user_insert($username, $password, $email, $phone, $fullName, $address, $avatar, $active, $role, $created_at) {
        $sql = "INSERT INTO user(username, password, email, phone, fullName, address, avatar, active, role, created_at)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return pdo_execute($sql, $username, $password, $email, $phone, $fullName, $address, $avatar, $active, $role, $created_at);
    }

    function user_update($password, $email, $phone, $fullName, $address, $avatar, $active, $role, $id) {
        $sql = "UPDATE user SET password = ?, email = ?, phone = ?, fullName = ?, address = ?, avatar = ?, active = ?, role = ? WHERE id = ?";
        pdo_execute($sql, $password, $email, $phone, $fullName, $address, $avatar, $active, $role, $id);
    }

    function user_delete($id) {
        $sql = "DELETE FROM user WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function user_select_all($start = '', $limit = '') {
        $sql = "SELECT * FROM user ORDER BY id DESC";
        return pdo_query($sql);
    }

    function user_select_by_id($id) {
        $sql = "SELECT * FROM user WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    // check user exits login
    function user_exits($user) {
        $sql = "SELECT * FROM user WHERE username = ? OR email = ?";
        return pdo_query_one($sql, $user, $user);
    }

    // check email, sdt tồn tại
    function user_exits_by_options($column, $value) {
        $sql = "SELECT * FROM user WHERE $column = ?";
        return pdo_query_one($sql, $value);
    }

    // cập nhật mật khẩu
    function user_change_pass($newPassword, $id) {
        $sql = "UPDATE user SET password = ? WHERE id = ?";
        pdo_execute($sql, $newPassword, $id);
    }

    // insert mã xác nhận đổi mật khẩu
    function user_token_insert($token, $id) {
        $sql = "UPDATE user SET token = ? WHERE id = ?";
        pdo_execute($sql, $token, $id);
    }

    // xóa token sau khi đổi mật khẩu
    function user_token_delete($id) {
        $sql = "UPDATE user SET token = '' WHERE id = ?";
        pdo_execute($sql, $id);
    }

    // gửi email khôi phục mật khẩu
    function user_send_reset_pass($email, $name) {
        global $PATH_URL;
        global $SMTP_UNAME;
        global $SMTP_PASS;

        $token = md5(rand(100000000, 99999999));
        $verificationLink = $PATH_URL . '/account/?code=' . $token;
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        try {
            //Server settings
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0;// Enable verbose debug output
            $mail->isSMTP();// gửi mail SMTP
            $mail->Host = 'smtp.gmail.com';// Set the SMTP server to send through
            $mail->SMTPAuth = true;// Enable SMTP authentication
            $mail->Username = $SMTP_UNAME;// SMTP username
            $mail->Password = $SMTP_PASS; // SMTP password
            $mail->SMTPSecure = 'ssl';// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = 465; // TCP port to connect to
            //Recipients
            $mail->setFrom($SMTP_UNAME, 'Tea House');
            $mail->addAddress($email, $name); // Add a recipient
            // $mail->addAddress('ellen@example.com'); // Name is optional
            $mail->addReplyTo($SMTP_UNAME, 'Tea House');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
            // Content
            $htmlStr = "";
            $htmlStr .= "Xin chào <strong>" . $name . '</strong> (' . $email . "),<br /><br />";
            $htmlStr .= "Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu Tea House của bạn.<br /><br /><br />";
            $htmlStr .= "Vui lòng truy cập tại link sau để đổi mật khẩu mới.<br><br>";
            $htmlStr .= "<a href='{$verificationLink}' target='_blank' style='padding:1em; font-weight:bold; text-decoration:none; background-color:#4d8a54; color:#fff;'>Change New Password</a><br /><br /><br />";
            $htmlStr .= "Lưu ý: Tuyệt đối không nhấp vào button link trên nếu bạn không thực hiện hành động này!.<br><br>";
            $htmlStr .= "Cảm ơn bạn đã tham gia và đồng hành cùng Tea House.<br><br>";
            $htmlStr .= "Trân trọng.";
            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Khôi phục tài khoản | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
            return $token;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // thông báo đổi mật khẩu thành công
    // gửi email khôi phục mật khẩu
    function user_changed_pass($email, $name) {
        global $SMTP_UNAME;
        global $SMTP_PASS;

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        try {
            $date = date('Y-m-d H:i:s');
            $date_format = date_format(date_create($date), 'd/m/Y H:i');
            //Server settings
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0;// Enable verbose debug output
            $mail->isSMTP();// gửi mail SMTP
            $mail->Host = 'smtp.gmail.com';// Set the SMTP server to send through
            $mail->SMTPAuth = true;// Enable SMTP authentication
            $mail->Username = $SMTP_UNAME;// SMTP username
            $mail->Password = $SMTP_PASS; // SMTP password
            $mail->SMTPSecure = 'ssl';// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = 465; // TCP port to connect to
            //Recipients
            $mail->setFrom($SMTP_UNAME, 'Tea House');
            $mail->addAddress($email, $name); // Add a recipient
            // $mail->addAddress('ellen@example.com'); // Name is optional
            $mail->addReplyTo($SMTP_UNAME, 'Tea House');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
            // Content
            $htmlStr = "";
            $htmlStr .= "Xin chào <strong>" . $name . '</strong> (' . $email . "),<br /><br />";
            $htmlStr .= "Mật khẩu Tea House của bạn đã được thay đổi vào lúc ". $date_format ." <br />";
            $htmlStr .= "Nếu bạn không làm điều này, vui lòng liên hệ với QTV.<br><br>";
            $htmlStr .= "Cảm ơn bạn đã tham gia và đồng hành cùng Tea House.<br><br>";
            $htmlStr .= "Trân trọng.";
            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Đổi mật khẩu | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    function khach_hang_email_exits($email) {
        $sql = "SELECT COUNT(*) FROM user WHERE email = ?";
        return pdo_query_value($sql, $email) > 0;
    }
    function username_exits($email) {
        $sql = "SELECT COUNT(*) FROM user WHERE username = ?";
        return pdo_query_value($sql, $email) > 0;
    }
    
    function khach_hang_action($id, $type = '') {
        if ($type && $type == 'lock') {
            $sql = "UPDATE user SET active = 0 WHERE id = ?";
        } else if ($type == 'unlock') {
            $sql = "UPDATE user SET active = 1 WHERE id = ?";
        }

        if (is_array($id)) {
            foreach ($id as $ma) {
                pdo_execute($sql, $ma);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }
    function user_search($keyword) {
        $sql = "SELECT * FROM user WHERE username LIKE ? OR fullName LIKE ? ORDER BY id DESC";
        return pdo_query($sql, '%'.$keyword.'%', '%'.$keyword.'%');
    }
    // Lấy ra số user hiện có
    function user_quantity() {
        $sql = "SELECT COUNT(*) FROM user";
        return pdo_query_value($sql);
    }

    function check_user_logged() {
        if (isset($_SESSION['user']['id'])) {
            return true;
        }
        return false;
    }
?>