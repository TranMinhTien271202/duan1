<?php

    session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    // biến toàn cục
    $ROOT_URL = '/duan1';
    $ADMIN_URL = "$ROOT_URL/admin";
    $SITE_URL = "$ROOT_URL/site";
    $IMG_URL = "$ROOT_URL/uploads";

    $IMG_PATH = $_SERVER['DOCUMENT_ROOT'] . $IMG_URL;

    function save_file($filename, $dir_path) {
        $file_upload = $_FILES[$filename];
        $file_name = $file_upload['name'];
        $file_dir_path = $dir_path . $file_name;
        move_uploaded_file($file_upload['tmp_name'], $file_dir_path);
        return $file_name;
    }

    // php mailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once "vendor/PHPMailer/src/PHPMailer.php";
    require_once "vendor/PHPMailer/src/SMTP.php";
    require_once "vendor/PHPMailer/src/Exception.php";

    // phpMailer settings
    $PATH_URL = 'http://localhost' . $SITE_URL;
    $SMTP_UNAME = 'levantuan.fpoly@gmail.com';
    $ADMIN_MAIL = 'tuanlvph14271@fpt.edu.vn';
    $SMTP_PASS = 'hlloutphdgmcgtue';

    // check login
    function check_login($role = 1) {
        global $SITE_URL;
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] != 1 && $_SESSION['user']['role'] != $role) {
                header('Location: ' . $SITE_URL);
            }
        } else {
            header('Location: ' . $SITE_URL);
        }
    }
?>