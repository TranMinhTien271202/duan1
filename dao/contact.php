
<?php

    require_once 'pdo.php';

    function contact_insert($name, $content, $email, $phone, $created_at) {
        $sql = "INSERT INTO contact(name, content, email, phone, created_at)
        VALUES(?, ?, ?, ?, ?)";
        pdo_execute($sql, $name, $content, $email, $phone, $created_at);
    }

    function contact_update($name, $content, $email, $phone, $created_at, $id) {
        $sql = "UPDATE contact SET name = ?, content = ?, email = ?, phone = ?,  created_at = ? WHERE id = ?";
        pdo_execute($sql, $name, $content, $email, $phone, $created_at, $id);
    }

    function contact_delete($id) {
        $sql = "DELETE FROM contact WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function contact_select_all($start = '', $limit = '') {
        $sql = "SELECT * FROM contact ORDER BY id DESC";
        if ($limit && $start >= 0) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql);
    }

    function contact_select_by_id($id) {
        $sql = "SELECT * FROM contact WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    function contact_exits($id) {
        $sql = "SELECT COUNT(*) FROM contact WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }
    
    // cập nhật trạng thái
    function contact_update_stt($id) {
        $sql = "UPDATE contact SET status = 1 WHERE id = ?";
        pdo_execute($sql, $id);
    }

    // gửi email phản hồi
    function contact_send_mail($feedbackInfo, $content_rep) {
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
            $mail->addAddress($feedbackInfo['email'], $feedbackInfo['name']); // Add a recipient
            // $mail->addAddress('ellen@example.com'); // Name is optional
            $mail->addReplyTo($SMTP_UNAME, 'Tea House');
            $htmlStr = '
            <div class="wrapper" style="background-color: #EFEFEF; padding: 0 15px;">
                <div class="container" style="width: 700px; max-width: 100%; margin: 0 auto;">
                    <header style="text-align: center; padding: 12px 0;">
                        <h2>
                            <strong>Xin chào ' . $feedbackInfo['name'] . '</strong>
                            <p style="font-size: 16px; font-weight: normal;">Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi đã nhận được Feedback của bạn và phản hồi cho bạn như sau.</p>
                        </h2>
                    </header>
            
                    <div class="content" style="padding-bottom: 32px;">
                        <h3>
                            <strong>Thông tin phản hồi</strong>
                        </h3>
                        <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Nội dung Feedback</td>
                                    <td style="padding: 10px 12px;">' . $feedbackInfo['content'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Phản hồi từ TeaHouse</td>
                                    <td style="padding: 10px 12px;">' . $content_rep . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';

            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Phản hồi khách hàng | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

?>