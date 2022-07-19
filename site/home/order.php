        <!-- CONTENT -->
        <div class="content-wrapper">
            <div class="grid">
                <div class="content">
                    <h2 class="content__title">Đặt bàn</h2>
                    <div class="main-content main-content-time-open">
                        <div class="time-open-wrapper">
                            <div class="time-open">
                               <div class="time">
                                <h4>Giờ mở cửa</h4>
                                <div class="text">
                                    <p>Thứ 2 - Thứ 6 hàng tuần</p>
                                <span>7h sáng - 11h sáng</span>
                                <span>11h sáng - 10h tối</span>
                                </div>
    
                                <div class="text">
                                <p>Thứ 7,Chủ nhật hàng tuần</p>
                                <span>8h sáng - 1h chiều</span>
                                <span>1h chiều - 9h tối</span>
                                </div>
    
                                <hr>
    
                                <div class="phone">
                                    <p>Số điện thoại</p>
                                    <a href="tel:<?=$isWebsiteOpen['phone'] ?? '';?>"><?=$isWebsiteOpen['phone'] ?? '';?></a>
                                </div>
                               </div>
                            </div>
                        </div>
                        <!--  -->
    
                        <div class="reserve-table-wrapper">
                            <form class="reserve-table" method="post">
                                <h4>Gọi ngay cho chúng tôi để đặt bàn</h4>
                                <div class="form-wrapper">
                                    <div>
                                        <div class="control-wrapper">
                                            <input type="text" name="name" placeholder="Họ và tên" value="<?=$order['name'] ?? $_SESSION['user']['fullName'] ?? '';?>">
                                            <div class="form-message">
                                                <?=$errorMessage['name'] ?? '';?>
                                            </div>
                                        </div>
                                        <!--  -->
                                        <div class="control-wrapper">
                                            <input type="text" name="phone" placeholder="Số điện thoại" value="<?=$order['phone'] ?? $_SESSION['user']['phone'] ?? '';?>">
                                            <div class="form-message">
                                                <?=$errorMessage['phone'] ?? '';?>
                                            </div>
                                        </div>
                                        <!--  -->
                                        <div class="control-wrapper">
                                            <input type="date" name="date_book" placeholder="Chọn ngày" value="<?=$order['date_book'] ?? '';?>">
                                            <div class="form-message">
                                                <?=$errorMessage['date_book'] ?? '';?>
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                    <!--  -->
                                    <div>
                                        <div class="control-wrapper">
                                            <input type="text" name="email" placeholder="Nhập địa chỉ email" value="<?=$order['email'] ?? $_SESSION['user']['email'] ?? '';?>">
                                            <div class="form-message">
                                                <?=$errorMessage['email'] ?? '';?>
                                            </div>
                                        </div>
                                        <!--  -->
                                        <div class="control-wrapper">
                                           <select name="table_id">
                                               <option value="">Số bàn đang trống</option>
                                               <?php foreach ($listTableExits as $table): ?>
                                                <?php if (isset($order['table_id']) && $order['table_id'] == $table['id']): ?>
                                               <option value="<?=$table['id'];?>" selected><?=$table['name'];?> (<?=$table['guest_number'] . ' người';?>)</option>
                                               <?php else: ?>
                                                <option value="<?=$table['id'];?>"><?=$table['name'];?> (<?=$table['guest_number'] . ' người';?>)</option>
                                                <?php endif; ?>
                                               <?php endforeach; ?>
                                           </select>
                                           <div class="form-message">
                                               <?=$errorMessage['table_id'] ?? '';?>
                                           </div>
                                        </div>
                                        <!--  -->
                                        <div class="control-wrapper">
                                            <input type="time" name="time_book" placeholder="Chọn giờ" value="<?=$order['time_book'] ?? '';?>">
                                            <div class="form-message">
                                                <?=$errorMessage['time_book'] ?? '';?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="button-control">
                                    <?=isset($MESSAGE) ? '<div class="alert alert-success">'. $MESSAGE .'</div>' : '';?>
                                    <div class="control-wrapper">
                                        <button type="submit" name="order_insert">Đặt bàn</button>
                                    </div>
                                </div>
    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- END CONTENT -->