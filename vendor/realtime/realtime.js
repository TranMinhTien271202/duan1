// toastr js
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "0",
    "extendedTimeOut": "0",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

const url = 'http://localhost/duan1';

function start() {
    // nếu đã đăng nhập với vai trò admin
    if (check_admin_login()) {
        // lấy tổng số hóa đơn và lưu vào localStorage
        update_total_order_to_localStorage();
        
        setInterval(function () {
            var totalOrder = JSON.parse(localStorage.getItem('total_order'));

            // lấy tổng số hóa đơn hiện tại
            var totalOrderRealTime = order_get_total_real_time();

            if (totalOrderRealTime > totalOrder) {
                var newOrder = totalOrderRealTime - totalOrder;
                // show toast message
                show_info_new_order(newOrder);

                // update lại tổng đơn hàng trong localStorage
                update_total_order_to_localStorage();
            }
        }, 1000);
    }
}

start();

// cập nhật tổng số đơn hàng vào localStorage
function update_total_order_to_localStorage() {
    $.ajax({
        url: url + '/vendor/realtime/index.php',
        type: 'POST',
        data: {
            get_total_order: ''
        },
        success: function (total_order) {
            localStorage.setItem('total_order', total_order);
        },
        error: function () {
            console.log('Lỗi');
        }
    });
}

// lấy tổng số order
function order_get_total_real_time() {
    var total = $.ajax({
        url: url + '/vendor/realtime/index.php',
        type: 'POST',
        data: {
            get_total_order: ''
        },
        async: false,
        success: function () {
        },
        error: function () {
            console.log('Lỗi');
        }
    }).responseText;

    return total;
}

// hiển thị lên màn hình
function show_info_new_order(newOrderQuantity) {
    $.ajax({
        url: url + '/vendor/realtime/index.php',
        type: 'POST',
        dataType: 'json',
        data: {
            get_new_order: '',
            newOrderQuantity: newOrderQuantity
        },
        success: function (response) {
            $.each(response, function (i, orderInfo) {
                var ok = toastr.success(`Đơn hàng mới từ ${orderInfo.customer_name}`);
                if (!ok) {
                    toastr.success(`Đơn hàng mới từ ${orderInfo.customer_name}`);
                }
                console.log('ok');
            });
        },
        error: function () {
            console.log('Lỗi');
        }
    });
}

// check admin login
function check_admin_login() {
    var isAdminLogged = $.ajax({
        url: url + '/vendor/realtime/index.php',
        type: 'POST',
        data: {
            check_admin_login: ''
        },
        async: false,
        success: function () {
        },
        error: function () {
            console.log('Lỗi');
        }
    }).responseText;

    return isAdminLogged;
}