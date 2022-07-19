<?php
    // domphp
    require_once '../../vendor/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    
    // chi tiết hóa đơn
    $listOrderDetail = order_detail_select_all_by_o_id($id);
            
    // thông tin hóa đơn
    $orderInfo = order_select_by_id($id);

    // mảng voucher
    $vouchers = explode(',', $orderInfo['voucher']);
    $voucherData = '';
    foreach ($vouchers as $voucher) {
        if ($voucher) {
            $voucherInfo = voucher_select_by_id($voucher);
            $voucherData .= $voucherInfo['code'] . ' (';
            if ($voucherInfo['condition']) {
                // nếu giảm theo tiền
                $voucherData .= 'Giảm ' . number_format($voucherInfo['voucher_number']) . ' VNĐ';
            } else {
                $voucherData .= 'Giảm ' . $voucherInfo['voucher_number'] . '%';
            }
            $voucherData .= '), ';
        }
    }

    // thông tin website
    $infoWebsite = settings_select_all();

    $html = '';
    $html .= '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hóa đơn - '.$orderInfo['customer_name'].'</title>
        <style>
            * {
                font-family: DejaVu Sans, sans-serif;
                box-sizing: border-box;
            }
            
            .container {
                color: #213983;
                line-height: 1.4;
            }
    
            .header__top {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
    
            .header__top-title {
                text-transform: uppercase;
                font-size: 30px;
                padding-top: 16px;
            }
    
    
            .header__bottom-label {
                font-weight: bold;
            }
    
            .table,
            .header__bottom {
                width: 100%;
                border-collapse: collapse;
            }
            
            .table td, th {
                border: 2px solid #213983;
            }
    
            .header__bottom {
                padding-bottom: 32px;
            }
    
            .table__header {
                text-transform: uppercase;
                color: #fff;
                background-color: #213983;
                font-weight: 400;
            }
    
            .table__header th {
                padding: 6px 0;
            }
    
            .table__content td, tfoot td {
                padding: 4px 12px;
            }
    
            .table__content tr td:first-child {
                text-align: center;
            }
    
            .footer__totalPrice {
                font-weight: bold;
                padding-top: 12px;
                margin-top: 12px;
            }
    
            .footer__totalPrice span {
                display: inline-block;
            }
            
            .footer__totalPrice-label {
                padding: 6px 12px 6px 0;
                margin-top: -4px;
            }
            
            .footer__totalPrice-price {
                padding: 6px 12px 6px 12px;
                border: 2px solid #213983;
            }
    
            .footer__date {
                padding-top: 12px;
                text-align: right;
            }
    
            .header__top-logo-img {
                width: 180px;
            }
    
            .header__top-logo {
                float: right;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header class="header">
                <div class="header__top">
                    <h2 class="header__top-title">Hóa đơn bán hàng</h2>
                    <div class="header__top-logo">
                        <img src="logo.png"
                        alt="" class="header__top-logo-img">
                    </div>
                </div>
    
                <table class="header__bottom">
                    <tr>
                        <td class="header__bottom-item">
                            <div class="header__bottom-group">
                                <label for="" class="header__bottom-label">Mã hóa đơn:</label>
                                ' . $orderInfo['id'] . '
                            </div>';

                            if ($voucherData) {
                                $html .= '
                                <div class="header__bottom-group">
                                    <label for="" class="header__bottom-label">Voucher:</label>
                                    ' . substr($voucherData, 0, -2) . '
                                </div>
                                ';
                            }

                            $html .= '
                            <div class="header__bottom-group">
                                <label for="" class="header__bottom-label">Khách hàng:</label>
                                ' . $orderInfo['customer_name'] . '
                            </div>
                            <div class="header__bottom-group">
                                <label for="" class="header__bottom-label">SĐT:</label>
                                ' . $orderInfo['phone'] . '
                            </div>
                            <div class="header__bottom-group">
                                <label for="" class="header__bottom-label">Địa chỉ:</label>
                                ' . $orderInfo['address'] . '
                            </div>
                            <div class="header__bottom-group">
                                <label for="" class="header__bottom-label">Email:</label>
                                ' . $orderInfo['email'] . '
                            </div>
                        </td>
    
                        <td class="header__bottom-item">
                            <div class="header__bottom-group">
                                <label for="" class="header__bottom-label">Địa chỉ Tea House:</label>
                                ' . $infoWebsite['address'] . '
                            </div>
                            <div class="header__bottom-group">
                                <label for="" class="header__bottom-label">SĐT:</label>
                                ' . $infoWebsite['phone'] . '
                            </div>
                            <div class="header__bottom-group">
                                <label for="" class="header__bottom-label">Email:</label>
                                ' . $infoWebsite['email'] . '
                            </div>
                            <div class="header__bottom-group">
                                <label for="" class="header__bottom-label">Website:</label>
                                teahouse.com
                            </div>
                        </td>
                    </tr>
                </table>
            </header>
    
            <table class="table">
                <thead class="table__header">
                    <tr>
                        <th>STT</th>
                        <th>Sản phẩm</th>
                        <th>Size</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
    
                <tbody class="table__content">';

                $stt = 0;
                $totalPrice = 0;
                foreach ($listOrderDetail as $item) {
                    $totalPrice += $item['quantity'] * $item['price'];
                    $stt++;
                    $html .= '
                    <tr>
                        <td>' . $stt . '</td>
                        <td>' . $item['product_name'] . '</td>
                        <td>' . $item['product_size'] . '</td>
                        <td>' . number_format($item['price'], 0, '', '.') . ' VNĐ</td>
                        <td>' . $item['quantity'] . '</td>
                        <td>' . number_format(($item['price'] * $item['quantity']), 0, '', '.') . ' VNĐ</td>
                    </tr>';
                }

                // tính tổng tiền được giảm khi áp vc
                $totalPriceVc = 0;
                foreach ($vouchers as $voucher) {
                    if ($voucher) {
                        $voucherInfo = voucher_select_by_id($voucher);
                        if ($voucherInfo['condition']) {
                            // nếu giảm theo tiền
                            $totalPriceVc += $voucherInfo['voucher_number'];
                        } else {
                            $totalPriceVc += $totalPrice * $voucherInfo['voucher_number'] / 100;
                        }
                    }
                }

                $html .= '
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            Tạm tính
                        </td>
                        <td colspan="4">
                            '. number_format($totalPrice, 0, '', '.') .' VNĐ
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Tổng giảm
                        </td>
                        <td colspan="4">
                            '. number_format($totalPriceVc, 0, '', '.') .' VNĐ
                        </td>
                    </tr>
                </tfoot>
            </table>
            <footer class="footer">
                <div class="footer__totalPrice">
                    <span class="footer__totalPrice-label">Tổng cộng</span>
                    
                    <span class="footer__totalPrice-price"> ' . number_format($orderInfo['total_price'], 0, '', '.') . ' VNĐ</span>
                </div>
                <div class="footer__totalPrice-text">
                    <strong>Bằng chữ: </strong>'. convert_number_to_words($orderInfo['total_price']) .'
                </div>
                <div class="footer__date">
                    Ngày ' . date_format(date_create($orderInfo['created_at']), 'd',) . '
                    tháng ' . date_format(date_create($orderInfo['created_at']), 'm',) . '
                    năm ' . date_format(date_create($orderInfo['created_at']), 'Y',) . '
                </div>
            </footer>
        </div>
    </body>
    </html>';


    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    // $dompdf->stream();
    $fileName = 'Invoice' . $orderInfo['id'] . '_' . $orderInfo['customer_name'];
    $dompdf->stream($fileName, array("Attachment"=>0));

?>

