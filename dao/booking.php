<?php

    require_once 'pdo.php';

    function booking_insert($user_id, $name, $email, $phone, $table_id, $date_book, $time_book, $status) {
        $sql = "INSERT INTO booking(user_id, name, email, phone, table_id, date_book, time_book, status) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        return pdo_execute($sql, $user_id, $name, $email, $phone, $table_id, $date_book, $time_book, $status);
    }

    function booking_select_all($start = 0, $limit = 0) {
        $sql = "SELECT b.*, t.name AS table_name FROM booking b JOIN `table` t ON b.table_id = t.id ORDER BY b.id DESC";
        if ($limit && $start >= 0) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql);
    }

    function booking_search($bk_keyword, $user_id = '') {
        $sql = "SELECT b.*, t.name AS table_name
        FROM booking b JOIN `table` t ON b.table_id = t.id";

        if ($user_id) {
            $sql .= " WHERE (b.name LIKE ? OR b.id = ?) AND b.user_id = ? ORDER BY id DESC";
            return pdo_query($sql, '%'.$bk_keyword.'%', $bk_keyword, $user_id);
        } else {
            $sql .= " WHERE b.name LIKE ? OR b.id = ?";
        }

        $sql .= " ORDER BY b.id DESC";
        
        return pdo_query($sql, '%'.$bk_keyword.'%', $bk_keyword);
    }

    function booking_select_by_id($id) {
        $sql = "SELECT b.*, t.name AS table_name, t.guest_number
        FROM booking b JOIN `table` t ON b.table_id = t.id
        WHERE b.id = ?
        ORDER BY b.id DESC";
        return pdo_query_one($sql, $id);
    }

    // ds booking theo user id
    function booking_select_all_by_uid($uid, $start = 0, $limit = 0) {
        $sql = "SELECT b.*, t.name AS table_name
        FROM booking b JOIN `table` t ON b.table_id = t.id
        WHERE user_id = ?
        ORDER BY b.id DESC";
        if ($limit && $start >= 0) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql, $uid);
    }

    // cập nhật trạng thái đặt bàn
    function booking_update_stt($stt, $id) {
        $sql = "UPDATE booking SET status = ? WHERE id = ?";
        pdo_execute($sql, $stt, $id);
    }

    // gửi email cho kh
    function booking_send_mail($id, $email, $name, $phone, $tableInfo, $date_book, $time_book) {
        global $SMTP_UNAME;
        global $SMTP_PASS;

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
            $htmlStr = '
            <div class="wrapper" style="background-color: #EFEFEF; padding: 0 15px;">
                <div class="container" style="width: 700px; max-width: 100%; margin: 0 auto;">
                    <header style="text-align: center; padding: 12px 0;">
                        <h2>
                            <strong>Xin chào ' . $name . '</strong>
                            <p style="font-size: 16px; font-weight: normal;">Bạn đã đặt bàn thành công. Mã đặt bàn: #'.$id.'</p>
                        </h2>
                    </header>
            
                    <div class="content" style="padding-bottom: 32px;">
                        <h3>
                            <strong>Thông tin đặt bàn</strong>
                        </h3>
                        <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Họ tên</td>
                                    <td style="padding: 10px 12px;">' . $name . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Email</td>
                                    <td style="padding: 10px 12px;">' . $email . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số điện thoại</td>
                                    <td style="padding: 10px 12px;">' . $phone . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số bàn</td>
                                    <td style="padding: 10px 12px;">' . $tableInfo['name'] . ' (' . $tableInfo['guest_number'] . ' người)</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Thời gian đặt bàn</td>
                                    <td style="padding: 10px 12px;">' . date('d/m/Y', strtotime($date_book)) . ' ' . date('H:i', strtotime($time_book)) . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';

            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Đặt bàn thành công | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // gửi email cho admin
    function booking_send_mail_admin($id, $email, $name, $phone, $tableInfo, $date_book, $time_book) {
        global $SMTP_UNAME;
        global $SMTP_PASS;
        global $ADMIN_MAIL;

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
            $mail->addAddress($ADMIN_MAIL, 'Tea House'); // Add a recipient
            $mail->addReplyTo($SMTP_UNAME, 'Tea House');
            $htmlStr = '
            <div class="wrapper" style="background-color: #EFEFEF; padding: 0 15px;">
                <div class="container" style="width: 700px; max-width: 100%; margin: 0 auto;">
                    <header style="text-align: center; padding: 12px 0;">
                        <h2>
                            <strong>Tea House có khách đặt bàn</strong>
                            <p style="font-size: 16px; font-weight: normal;">Hãy tiến hành xác minh đặt hàng.</p>
                        </h2>
                    </header>
            
                    <div class="content" style="padding-bottom: 32px;">
                        <h3>
                            <strong>Thông tin đặt bàn</strong>
                        </h3>
                        <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Mã đặt bàn</td>
                                    <td style="padding: 10px 12px;">#' . $id . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Họ tên</td>
                                    <td style="padding: 10px 12px;">' . $name . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Email</td>
                                    <td style="padding: 10px 12px;">' . $email . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số điện thoại</td>
                                    <td style="padding: 10px 12px;">' . $phone . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số bàn</td>
                                    <td style="padding: 10px 12px;">' . $tableInfo['name'] . ' (' . $tableInfo['guest_number'] . ' người)</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Thời gian đặt bàn</td>
                                    <td style="padding: 10px 12px;">' . date('d/m/Y', strtotime($date_book)) . ' ' . date('H:i', strtotime($time_book)) . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';

            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Khách hàng ' . $name . ' đã đặt bàn | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // thông báo cho KH đặt bàn bị hủy
    function booking_send_mail_cancel($bookingInfo) {
        global $SMTP_UNAME;
        global $SMTP_PASS;

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
            $mail->addAddress($bookingInfo['email'], $bookingInfo['name']); // Add a recipient
            $mail->addReplyTo($SMTP_UNAME, 'Tea House');
            $htmlStr = '
            <div class="wrapper" style="background-color: #EFEFEF; padding: 0 15px;">
                <div class="container" style="width: 700px; max-width: 100%; margin: 0 auto;">
                    <header style="text-align: center; padding: 12px 0;">
                        <h2>
                            <strong>Xin chào '. $bookingInfo['name'] .'</strong>
                            <p style="font-size: 16px; font-weight: normal;">Đặt bàn của bạn đã bị hủy.</p>
                        </h2>
                    </header>
            
                    <div class="content" style="padding-bottom: 32px;">
                        <h3>
                            <strong>Thông tin đặt bàn</strong>
                        </h3>
                        <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Mã đặt bàn</td>
                                    <td style="padding: 10px 12px;">#' . $bookingInfo['id'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Họ tên</td>
                                    <td style="padding: 10px 12px;">' . $bookingInfo['name'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Email</td>
                                    <td style="padding: 10px 12px;">' . $bookingInfo['email'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số điện thoại</td>
                                    <td style="padding: 10px 12px;">' . $bookingInfo['phone'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số bàn</td>
                                    <td style="padding: 10px 12px;">' . $bookingInfo['table_name'] . ' (' . $bookingInfo['guest_number'] . ' người)</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Thời gian đặt bàn</td>
                                    <td style="padding: 10px 12px;">' . date('d/m/Y', strtotime($bookingInfo['date_book'])) . ' ' . date('H:i', strtotime($bookingInfo['time_book'])) . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';

            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Đặt bàn của bạn đã bị hủy | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // thông báo đặt bàn bị hủy cho admin
    function booking_send_mail_admin_cancel($bookingInfo) {
        global $SMTP_UNAME;
        global $SMTP_PASS;
        global $ADMIN_MAIL;

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
            $mail->addAddress($ADMIN_MAIL, 'Tea House'); // Add a recipient
            $mail->addReplyTo($SMTP_UNAME, 'Tea House');
            $htmlStr = '
            <div class="wrapper" style="background-color: #EFEFEF; padding: 0 15px;">
                <div class="container" style="width: 700px; max-width: 100%; margin: 0 auto;">
                    <header style="text-align: center; padding: 12px 0;">
                        <h2>
                            <strong>'. $bookingInfo['name'] .' đã hủy đặt bàn</strong>
                            <p style="font-size: 16px; font-weight: normal;">Đặt bàn bị hủy.</p>
                        </h2>
                    </header>
            
                    <div class="content" style="padding-bottom: 32px;">
                        <h3>
                            <strong>Thông tin đặt bàn</strong>
                        </h3>
                        <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Mã đặt bàn</td>
                                    <td style="padding: 10px 12px;">#' . $bookingInfo['id'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Họ tên</td>
                                    <td style="padding: 10px 12px;">' . $bookingInfo['name'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Email</td>
                                    <td style="padding: 10px 12px;">' . $bookingInfo['email'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số điện thoại</td>
                                    <td style="padding: 10px 12px;">' . $bookingInfo['phone'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số bàn</td>
                                    <td style="padding: 10px 12px;">' . $bookingInfo['table_name'] . ' (' . $bookingInfo['guest_number'] . ' người)</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Thời gian đặt bàn</td>
                                    <td style="padding: 10px 12px;">' . date('d/m/Y', strtotime($bookingInfo['date_book'])) . ' ' . date('H:i', strtotime($bookingInfo['time_book'])) . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';

            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Khách hàng '. $bookingInfo['name'] .' đã hủy đặt bàn | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

?>