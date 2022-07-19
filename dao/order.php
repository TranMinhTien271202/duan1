<?php

    require_once 'pdo.php';

    function order_insert($user_id, $customer_name, $address, $phone, $email, $total_price, $message, $status, $voucher, $created_at, $updated_at) {
        $sql = "INSERT INTO `order`(user_id, customer_name, address, phone, email, total_price, message, status, voucher, created_at, updated_at)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return pdo_execute($sql, $user_id, $customer_name, $address, $phone, $email, $total_price, $message, $status, $voucher, $created_at, $updated_at);
    }

    // function order_show($start = '', $limit = ''){
    //     $sql = "SELECT COUNT(*)as tong, DATE(created_at) as ngay, SUM(total_price) as tien FROM `order` GROUP BY DATE(created_at)";
    //   return  pdo_query($sql);
    // }

    // function order_update($user_id, $customer_name, $address, $phone, $total_price, $message, $status, $created_at, $id) {
    //     $sql = "UPDATE `order` SET user_id = ?, customer_name = ?, address = ?, phone = ?, total_price = ?, message = ?, status = ?, created_at = ? WHERE id = ?";
    //     pdo_execute($sql, $user_id, $customer_name, $address, $phone, $total_price, $message, $status, $created_at, $id);
    // }

    // function order_delete($id) {
    //     $sql = "DELETE FROM `order` WHERE id = ?";

    //     if (is_array($id)) {
    //         foreach ($id as $id_item) {
    //             pdo_execute($sql, $id_item);
    //         }
    //     } else {
    //         pdo_execute($sql, $id);
    //     }
    // }

    function order_select_all($start = 0, $limit = 0) {
        $sql = "SELECT * FROM `order` ORDER BY id DESC";
        if ($limit && $start >= 0) {
            $sql .= " LIMIT $start, $limit";
        }
        
        return pdo_query($sql);
    }

    function order_select_by_id($id) {
        $sql = "SELECT * FROM `order` WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    // ds đơn hàng của tôi
    function order_select_all_by_user_id($id, $start = 0, $limit = 0) {
        $sql = "SELECT * FROM `order` WHERE user_id = ? ORDER BY id DESC";
        if ($limit && $start >= 0) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql, $id);
    }

    // function order_exits($id) {
    //     $sql = "SELECT COUNT(*) FROM `order` WHERE id = ?";
    //     return pdo_query_value($sql, $id) > 0;
    // }

    // check hủy đơn hàng
    function order_check_delivered($id) {
        $sql = "SELECT * FROM `order` WHERE id = ? AND status IN (2, 3)";
        return pdo_query($sql, $id);
    }

    // cập nhật trạng thái đơn hàng 0 - Đơn hàng mới, 1 - Đã xác nhận, 2 - Đang giao hàng, 3 - Đã giao, 4 - Đã hủy
    function order_update_status($status, $updated_at, $id) {
        $sql = "UPDATE `order` SET status = ?, updated_at = ? WHERE id = ?";
        pdo_execute($sql, $status, $updated_at, $id);
    }

    function convert_number_to_words($number) {
        $hyphen      = ' ';
        $conjunction = '  ';
        $separator   = ' ';
        $negative    = 'âm ';
        $decimal     = ' phẩy ';
        $dictionary  = array(
        0                   => 'Không',
        1                   => 'Một',
        2                   => 'Hai',
        3                   => 'Ba',
        4                   => 'Bốn',
        5                   => 'Năm',
        6                   => 'Sáu',
        7                   => 'Bảy',
        8                   => 'Tám',
        9                   => 'Chín',
        10                  => 'Mười',
        11                  => 'Mười một',
        12                  => 'Mười hai',
        13                  => 'Mười ba',
        14                  => 'Mười bốn',
        15                  => 'Mười năm',
        16                  => 'Mười sáu',
        17                  => 'Mười bảy',
        18                  => 'Mười tám',
        19                  => 'Mười chín',
        20                  => 'Hai mươi',
        30                  => 'Ba mươi',
        40                  => 'Bốn mươi',
        50                  => 'Năm mươi',
        60                  => 'Sáu mươi',
        70                  => 'Bảy mươi',
        80                  => 'Tám mươi',
        90                  => 'Chín mươi',
        100                 => 'trăm',
        1000                => 'ngàn',
        1000000             => 'triệu',
        1000000000          => 'tỷ',
        1000000000000       => 'nghìn tỷ',
        1000000000000000    => 'ngàn triệu triệu',
        1000000000000000000 => 'tỷ tỷ'
        );
    
        if (!is_numeric($number)) {
            return false;
        }
    
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }
    
        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }
        
        $string = $fraction = null;
        
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
    
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
            break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
            break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
            break;
        }
    
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
    
        return $string;
    }

    // gửi mail thông báo đặt hàng thành công
    function order_send_mail_customer($email, $name, $address, $phone, $customer_message, $total_price, $totalPriceVoucher) {
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
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
            foreach ($_SESSION['cart'] as $key => $item) {
                $mail->AddEmbeddedImage("../../uploads/$item[product_image]", "image_$key", "$item[product_image]"); // Optional name
            }
            // Content
            $htmlStr = '
            <div class="wrapper" style="background-color: #EFEFEF; padding: 0 15px;">
                <div class="container" style="width: 700px; max-width: 100%; margin: 0 auto;">
                    <header style="text-align: center; padding: 12px 0;">
                        <h2>
                            <strong>Xin chào ' . $name . '</strong>
                            <p style="font-size: 16px; font-weight: normal;">Bạn đã đặt hàng thành công. Cảm ơn bạn đã tin tưởng và ủng hộ cửa hàng. Chúng tôi sẽ sớm liên hệ với bạn để giao hàng.</p>
                        </h2>
                    </header>
            
                    <div class="content" style="padding-bottom: 32px;">
                        <h3>
                            <strong>Người nhận hàng</strong>
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
                                    <td style="padding: 10px 12px; font-weight: bold;">Địa chỉ nhận hàng</td>
                                    <td style="padding: 10px 12px;">' . $address . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Ghi chú</td>
                                    <td style="padding: 10px 12px;">' . $customer_message . '</td>
                                </tr>
                            </tbody>
                        </table>
            
                        <h3>
                            <strong>Thông tin sản phẩm</strong>
                        </h3>
                        <table table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="font-weight: bold; padding: 8px; text-align: center;">STT</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Ảnh SP</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Tên SP</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Size</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Đơn giá</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Số lượng</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Thành tiền</th>
                                </tr>
                            </thead>
            
                            <tbody>';
                            $stt = 0;
                            $totalPrice = 0;
                            foreach ($_SESSION['cart'] as $key => $item) {
                                $stt++;
                                $totalPrice += $item['price'] * $item['quantity'];
                                $htmlStr .= '
                                <tr>
                                    <td style="text-align: center;">'. $stt .'</td>
                                    <td style="padding: 8px;">
                                        <img src="cid:image_'. $key .'" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td style="padding: 8px 12px;">' . $item['product_name'] . '</td>
                                    <td style="padding: 8px 12px;">' . $item['size'] . '</td>
                                    <td style="padding: 8px 12px;">'. number_format($item['price'], 0, '', ',') .' VNĐ</td>
                                    <td style="padding: 8px 12px;">' . $item['quantity'] . '</td>
                                    <td style="padding: 8px 12px;">'. number_format(($item['price'] * $item['quantity']), 0, '', ',') .' VNĐ</td>
                                </tr>
                                ';
                            }
                                
                            $htmlStr .= '
                            </tbody>
            
                            <tfoot>
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 12px;">Tạm tính</td>
                                    <td colspan="6" style="padding: 8px 12px;">'. number_format($totalPrice, 0, '', ',') .' VNĐ</td>
                                </tr>';
                                if ($_SESSION['voucher']) {
                                    $htmlStr .= '
                                    <tr>
                                        <td style="font-weight: bold; padding: 8px 12px;">Voucher</td>
                                        <td colspan="6" style="padding: 8px 12px;">
                                    ';
                                    $tempStr = '';
                                    foreach ($_SESSION['voucher'] as $voucher) {
                                        $tempStr .= $voucher['code'] . ', ';
                                    }

                                    $htmlStr .= substr($tempStr, 0, -2);

                                    $htmlStr .= '
                                        </td>
                                    </tr>
                                    ';
                                }
                                $htmlStr .= '
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 12px;">Tổng giảm</td>
                                    <td colspan="6" style="padding: 8px 12px;">' . number_format($totalPriceVoucher) . ' VNĐ</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 12px;">Tổng thanh toán</td>
                                    <td colspan="6" style="padding: 8px 12px;">'. number_format($total_price) .' VNĐ ('. convert_number_to_words($total_price) .')</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>';

            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Đặt hàng thành công | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // gửi mail thông báo cho nhân viên
    function order_send_mail_admin($customer_email, $customer_name, $customer_address, $customer_phone, $customer_message, $total_price, $totalPriceVoucher) {
        global $SMTP_UNAME;
        global $SMTP_PASS;
        global $ADMIN_MAIL;

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
            $mail->addAddress($ADMIN_MAIL, 'Admin'); // Add a recipient
            // $mail->addAddress('ellen@example.com'); // Name is optional
            $mail->addReplyTo($SMTP_UNAME, 'Tea House');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
            foreach ($_SESSION['cart'] as $key => $item) {
                $mail->AddEmbeddedImage("../../uploads/$item[product_image]", "image_$key", "$item[product_image]"); // Optional name
            }
            // Content
            $htmlStr = '
            <div class="wrapper" style="background-color: #EFEFEF; padding: 0 15px;">
                <div class="container" style="width: 700px; max-width: 100%; margin: 0 auto;">
                    <header style="text-align: center; padding: 12px 0;">
                        <h2>
                            <strong>Tea House có đơn hàng mới</strong>
                            <p style="font-size: 16px; font-weight: normal;">Hãy tiến hành xác minh đơn hàng và giao hàng.</p>
                        </h2>
                    </header>
            
                    <div class="content" style="padding-bottom: 32px;">
                        <h3>
                            <strong>Người nhận hàng</strong>
                        </h3>
                        <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Họ tên</td>
                                    <td style="padding: 10px 12px;">' . $customer_name . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Email</td>
                                    <td style="padding: 10px 12px;">' . $customer_email . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số điện thoại</td>
                                    <td style="padding: 10px 12px;">' . $customer_phone . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Địa chỉ nhận hàng</td>
                                    <td style="padding: 10px 12px;">' . $customer_address . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Thời gian đặt</td>
                                    <td style="padding: 10px 12px;">' . $date_format . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Ghi chú</td>
                                    <td style="padding: 10px 12px;">' . $customer_message . '</td>
                                </tr>
                            </tbody>
                        </table>
            
                        <h3>
                            <strong>Thông tin sản phẩm</strong>
                        </h3>
                        <table table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="font-weight: bold; padding: 8px; text-align: center;">STT</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Ảnh SP</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Tên SP</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Size</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Đơn giá</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Số lượng</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Thành tiền</th>
                                </tr>
                            </thead>
            
                            <tbody>';
                            $stt = 0;
                            $totalPrice = 0;
                            foreach ($_SESSION['cart'] as $key => $item) {
                                $stt++;
                                $totalPrice += $item['price'] * $item['quantity'];
                                $htmlStr .= '
                                <tr>
                                    <td style="text-align: center;">'. $stt .'</td>
                                    <td style="padding: 8px;">
                                        <img src="cid:image_'. $key .'" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td style="padding: 8px 12px;">' . $item['product_name'] . '</td>
                                    <td style="padding: 8px 12px;">' . $item['size'] . '</td>
                                    <td style="padding: 8px 12px;">'. number_format($item['price'], 0, '', ',') .' VNĐ</td>
                                    <td style="padding: 8px 12px;">' . $item['quantity'] . '</td>
                                    <td style="padding: 8px 12px;">'. number_format(($item['price'] * $item['quantity']), 0, '', ',') .' VNĐ</td>
                                </tr>
                                ';
                            }
                                
                            $htmlStr .= '
                            </tbody>
            
                            <tfoot>
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 12px;">Tạm tính</td>
                                    <td colspan="6" style="padding: 8px 12px;">'. number_format($totalPrice, 0, '', ',') .' VNĐ</td>
                                </tr>';
                                if ($_SESSION['voucher']) {
                                    $htmlStr .= '
                                    <tr>
                                        <td style="font-weight: bold; padding: 8px 12px;">Voucher</td>
                                        <td colspan="6" style="padding: 8px 12px;">
                                    ';
                                    $tempStr = '';
                                    foreach ($_SESSION['voucher'] as $voucher) {
                                        $tempStr .= $voucher['code'] . ', ';
                                    }

                                    $htmlStr .= substr($tempStr, 0, -2);

                                    $htmlStr .= '
                                        </td>
                                    </tr>
                                    ';
                                }
                                $htmlStr .= '
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 12px;">Tổng giảm</td>
                                    <td colspan="6" style="padding: 8px 12px;">' . number_format($totalPriceVoucher) . ' VNĐ</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 12px;">Tổng thanh toán</td>
                                    <td colspan="6" style="padding: 8px 12px;">'. number_format($total_price) .' VNĐ ('. convert_number_to_words($total_price) .')</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>';

            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Đơn hàng mới từ ' . $customer_name . ' | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function order_search($keyword, $status = '', $id = 0) {
        $sql = "SELECT * FROM `order` WHERE (customer_name LIKE ? OR id LIKE ?)";
        if ($id) {
            $sql .= " AND user_id = $id";
        }

        if ($status != '') {
            $sql .= " AND status = $status";
        }
        
        $sql .= ' ORDER BY id DESC';
        return pdo_query($sql, '%'.$keyword.'%', '%'.$keyword.'%');
    }

    // thông báo hủy đơn cho khách
    function order_cancel_noti($orderDetail, $orderInfo) {
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
            $mail->addAddress($orderInfo['email'], $orderInfo['customer_name']); // Add a recipient
            // $mail->addAddress('ellen@example.com'); // Name is optional
            $mail->addReplyTo($SMTP_UNAME, 'Tea House');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
            foreach ($orderDetail as $key => $item) {
                $mail->AddEmbeddedImage("../../uploads/$item[product_image]", "image_$key", "$item[product_image]"); // Optional name
            }
            // Content
            $htmlStr = '
            <div class="wrapper" style="background-color: #EFEFEF; padding: 0 15px;">
                <div class="container" style="width: 700px; max-width: 100%; margin: 0 auto;">
                    <header style="text-align: center; padding: 12px 0;">
                        <h2>
                            <strong>Xin chào '. $orderInfo['customer_name'] .'</strong>
                            <p style="font-size: 16px; font-weight: normal;">Đơn hàng #'. $orderInfo['id'] .' của bạn đã bị hủy lúc '. date('d/m/Y H:i', strtotime($orderInfo['updated_at'])) .'.</p>
                        </h2>
                    </header>
            
                    <div class="content" style="padding-bottom: 32px;">
                        <h3>
                            <strong>Người nhận hàng</strong>
                        </h3>
                        <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Họ tên</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['customer_name'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Email</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['email'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số điện thoại</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['phone'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Địa chỉ nhận hàng</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['address'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Thời gian đặt</td>
                                    <td style="padding: 10px 12px;">' . date('d/m/Y H:i', strtotime($orderInfo['created_at'])) . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Ghi chú</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['message'] . '</td>
                                </tr>
                            </tbody>
                        </table>
            
                        <h3>
                            <strong>Thông tin sản phẩm</strong>
                        </h3>
                        <table table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="font-weight: bold; padding: 8px; text-align: center;">STT</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Ảnh SP</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Tên SP</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Size</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Đơn giá</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Số lượng</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Thành tiền</th>
                                </tr>
                            </thead>
            
                            <tbody>';
                            $stt = 0;
                            foreach ($orderDetail as $key => $item) {
                                $stt++;
                                $htmlStr .= '
                                <tr>
                                    <td style="text-align: center;">'. $stt .'</td>
                                    <td style="padding: 8px;">
                                        <img src="cid:image_'. $key .'" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td style="padding: 8px 12px;">' . $item['product_name'] . '</td>
                                    <td style="padding: 8px 12px;">' . $item['product_size'] . '</td>
                                    <td style="padding: 8px 12px;">'. number_format($item['price'], 0, '', ',') .' VNĐ</td>
                                    <td style="padding: 8px 12px;">' . $item['quantity'] . '</td>
                                    <td style="padding: 8px 12px;">'. number_format(($item['price'] * $item['quantity']), 0, '', ',') .' VNĐ</td>
                                </tr>
                                ';
                            }
                                
                            $htmlStr .= '
                            </tbody>
            
                            <tfoot>
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 12px;">Tổng thanh toán</td>
                                    <td colspan="6" style="padding: 8px 12px;">'. number_format($orderInfo['total_price']) .' VNĐ ('. convert_number_to_words($orderInfo['total_price']) .')</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>';

            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Đơn hàng #' . $orderInfo['id'] . ' đã bị hủy | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // thông báo đã giao hàng
    function order_success_noti($orderDetail, $orderInfo) {
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
            $mail->addAddress($orderInfo['email'], $orderInfo['customer_name']); // Add a recipient
            // $mail->addAddress('ellen@example.com'); // Name is optional
            $mail->addReplyTo($SMTP_UNAME, 'Tea House');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
            foreach ($orderDetail as $key => $item) {
                $mail->AddEmbeddedImage("../../uploads/$item[product_image]", "image_$key", "$item[product_image]"); // Optional name
            }
            // Content
            $htmlStr = '
            <div class="wrapper" style="background-color: #EFEFEF; padding: 0 15px;">
                <div class="container" style="width: 700px; max-width: 100%; margin: 0 auto;">
                    <header style="text-align: center; padding: 12px 0;">
                        <h2>
                            <strong>Xin chào '. $orderInfo['customer_name'] .'</strong>
                            <p style="font-size: 16px; font-weight: normal;">Đơn hàng #'. $orderInfo['id'] .' của bạn đã giao thành công lúc '. date('d/m/Y H:i', strtotime($orderInfo['updated_at'])) .'.</p>
                        </h2>
                    </header>
            
                    <div class="content" style="padding-bottom: 32px;">
                        <h3>
                            <strong>Người nhận hàng</strong>
                        </h3>
                        <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Họ tên</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['customer_name'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Email</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['email'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số điện thoại</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['phone'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Địa chỉ nhận hàng</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['address'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Thời gian đặt</td>
                                    <td style="padding: 10px 12px;">' . date('d/m/Y H:i', strtotime($orderInfo['created_at'])) . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Ghi chú</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['message'] . '</td>
                                </tr>
                            </tbody>
                        </table>
            
                        <h3>
                            <strong>Thông tin sản phẩm</strong>
                        </h3>
                        <table table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="font-weight: bold; padding: 8px; text-align: center;">STT</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Ảnh SP</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Tên SP</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Size</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Đơn giá</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Số lượng</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Thành tiền</th>
                                </tr>
                            </thead>
            
                            <tbody>';
                            $stt = 0;
                            foreach ($orderDetail as $key => $item) {
                                $stt++;
                                $htmlStr .= '
                                <tr>
                                    <td style="text-align: center;">'. $stt .'</td>
                                    <td style="padding: 8px;">
                                        <img src="cid:image_'. $key .'" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td style="padding: 8px 12px;">' . $item['product_name'] . '</td>
                                    <td style="padding: 8px 12px;">' . $item['product_size'] . '</td>
                                    <td style="padding: 8px 12px;">'. number_format($item['price'], 0, '', ',') .' VNĐ</td>
                                    <td style="padding: 8px 12px;">' . $item['quantity'] . '</td>
                                    <td style="padding: 8px 12px;">'. number_format(($item['price'] * $item['quantity']), 0, '', ',') .' VNĐ</td>
                                </tr>
                                ';
                            }
                                
                            $htmlStr .= '
                            </tbody>
            
                            <tfoot>
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 12px;">Tổng thanh toán</td>
                                    <td colspan="6" style="padding: 8px 12px;">'. number_format($orderInfo['total_price']) .' VNĐ ('. convert_number_to_words($orderInfo['total_price']) .')</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>';

            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Đơn hàng #' . $orderInfo['id'] . ' đã giao hàng thành công | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // thông báo hủy đơn cho admin
    function order_cancel_noti_admin($orderDetail, $orderInfo) {
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
            // $mail->addAddress('ellen@example.com'); // Name is optional
            $mail->addReplyTo($SMTP_UNAME, 'Tea House');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
            foreach ($orderDetail as $key => $item) {
                $mail->AddEmbeddedImage("../../uploads/$item[product_image]", "image_$key", "$item[product_image]"); // Optional name
            }
            // Content
            $htmlStr = '
            <div class="wrapper" style="background-color: #EFEFEF; padding: 0 15px;">
                <div class="container" style="width: 700px; max-width: 100%; margin: 0 auto;">
                    <header style="text-align: center; padding: 12px 0;">
                        <h2>
                            <strong>'. $orderInfo['customer_name'] .' đã hủy đặt hàng.</strong>
                            <p style="font-size: 16px; font-weight: normal;">Đơn hàng #'. $orderInfo['id'] .' đã bị hủy lúc '. date('d/m/Y H:i', strtotime($orderInfo['updated_at'])) .'.</p>
                        </h2>
                    </header>
            
                    <div class="content" style="padding-bottom: 32px;">
                        <h3>
                            <strong>Người nhận hàng</strong>
                        </h3>
                        <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Họ tên</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['customer_name'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Email</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['email'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Số điện thoại</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['phone'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Địa chỉ nhận hàng</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['address'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Thời gian đặt</td>
                                    <td style="padding: 10px 12px;">' . date('d/m/Y H:i', strtotime($orderInfo['created_at'])) . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 12px; font-weight: bold;">Ghi chú</td>
                                    <td style="padding: 10px 12px;">' . $orderInfo['message'] . '</td>
                                </tr>
                            </tbody>
                        </table>
            
                        <h3>
                            <strong>Thông tin sản phẩm</strong>
                        </h3>
                        <table table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="font-weight: bold; padding: 8px; text-align: center;">STT</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Ảnh SP</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Tên SP</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Size</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Đơn giá</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Số lượng</th>
                                    <th style="font-weight: bold; padding: 8px 12px; text-align: left;">Thành tiền</th>
                                </tr>
                            </thead>
            
                            <tbody>';
                            $stt = 0;
                            foreach ($orderDetail as $key => $item) {
                                $stt++;
                                $htmlStr .= '
                                <tr>
                                    <td style="text-align: center;">'. $stt .'</td>
                                    <td style="padding: 8px;">
                                        <img src="cid:image_'. $key .'" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td style="padding: 8px 12px;">' . $item['product_name'] . '</td>
                                    <td style="padding: 8px 12px;">' . $item['product_size'] . '</td>
                                    <td style="padding: 8px 12px;">'. number_format($item['price'], 0, '', ',') .' VNĐ</td>
                                    <td style="padding: 8px 12px;">' . $item['quantity'] . '</td>
                                    <td style="padding: 8px 12px;">'. number_format(($item['price'] * $item['quantity']), 0, '', ',') .' VNĐ</td>
                                </tr>
                                ';
                            }
                                
                            $htmlStr .= '
                            </tbody>
            
                            <tfoot>
                                <tr>
                                    <td style="font-weight: bold; padding: 8px 12px;">Tổng thanh toán</td>
                                    <td colspan="6" style="padding: 8px 12px;">'. number_format($orderInfo['total_price']) .' VNĐ ('. convert_number_to_words($orderInfo['total_price']) .')</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>';

            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Khách hàng ' . $orderInfo['customer_name'] . ' đã hủy đặt hàng | Tea House';
            $mail->Body = $htmlStr;
            $mail->AltBody = $htmlStr;
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

?>