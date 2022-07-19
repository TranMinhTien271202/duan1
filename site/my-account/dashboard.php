<div class="my-acc__dashboard">
    <div class="my-acc__dashboard-user">
        <img src="<?=$IMG_URL . '/' . $_SESSION['user']['avatar'];?>" alt="" class="my-acc__dashboard-user-img">

        <div class="my-acc__dashboard-user-info">
            <span class="my-acc__dashboard-user-name"><?=$_SESSION['user']['fullName'];?></span>
            <span class="my-acc__dashboard-user-id"><?=ucfirst($userInfo['username']);?></span>
        </div>
    </div>

    <ul class="my-acc__dashboard-nav">
        <li class="my-acc__dashboard-nav-item <?=isset($active) && $active == 'edit_info' ? 'my-acc__dashboard-nav-item--active' : '';?>">
            <a href="<?=$SITE_URL . '/my-account'?>" class="my-acc__dashboard-nav-item-link">Thông tin tài khoản</a>
        </li>
        <li class="my-acc__dashboard-nav-item <?=isset($active) && $active == 'update_pass' ? 'my-acc__dashboard-nav-item--active' : '';?>">
            <a href="<?=$SITE_URL . '/my-account/?update_pass'?>" class="my-acc__dashboard-nav-item-link">Đổi mật khẩu</a>
        </li>
        <li class="my-acc__dashboard-nav-item <?=isset($active) && $active == 'cart' ? 'my-acc__dashboard-nav-item--active' : '';?>">
            <a href="<?=$SITE_URL . '/my-account/?cart'?>" class="my-acc__dashboard-nav-item-link">Đơn hàng</a>
        </li>
        <li class="my-acc__dashboard-nav-item <?=isset($active) && $active == 'booking' ? 'my-acc__dashboard-nav-item--active' : '';?>">
            <a href="<?=$SITE_URL . '/my-account/?booking'?>" class="my-acc__dashboard-nav-item-link">Lịch sử đặt bàn</a>
        </li>
        <li class="my-acc__dashboard-nav-item">
            <a href="<?=$SITE_URL . '/my-account/?logout'?>" class="my-acc__dashboard-nav-item-link">Đăng xuất</a>
        </li>
    </ul>
</div>