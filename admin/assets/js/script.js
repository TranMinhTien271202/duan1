const admin_url = 'http://localhost/duan1/admin';

// đóng mở menu
$('.sidebar__btn-toggle').on('click', () => {
    $('.container').toggleClass('isMenuClosed');

    if ($('.container').hasClass('isMenuClosed')) {
        $('.aside_menu-session-icon').removeClass('hide');
    } else {
        $('.aside_menu-session-icon').addClass('hide');
    }
});

$('.header__top-bar').on('click', () => {
    $('.container').removeClass('isMenuHide');
    $('.container').toggleClass('isMenuClosed');

    if ($('.container').hasClass('isMenuClosed')) {
        $('.aside_menu-session-icon').removeClass('hide');
    } else {
        $('.aside_menu-session-icon').addClass('hide');
    }
});

// đóng mở user panel
$('.header__toolbar').on('click', () => {
    openUserPanel();
});

$('.user__panel-heading-icon').on('click', () => {
    $('.user__panel').toggleClass('active');
});

$('.user__panel-overlay').on('click', () => {
    openUserPanel();
});

function openUserPanel() {
    $('.user__panel').toggleClass('active');
}

// ẩn menu khi resize
$(window).on('resize', () => {
    handleResize();
});

$(window).on('load', () => {
    handleResize();
});

function handleResize() {
    var widthScreen = $(window).width();
    if (widthScreen < 1023) {
        $('.container').addClass('isMenuHide');
    } else {
        $('.container').removeClass('isMenuHide');
    }
}

// xem trước ảnh
function preImage(e) {
    $('.form-image-box').html('<img src="' + URL.createObjectURL(e.target.files[0]) + '" alt="">');

    if (e.target.files.length >= 0) {
        $('.form-image-box').closest('.form__group').removeClass('hide');
    } else {
        $('.form-image-box').closest('.form__group').addClass('hide');
    }
}

// chọn tất cả
$('.content__header-item-btn-select-all').on('click', () => {
    $('.content__table-table input:checkbox').prop('checked', true);
});

$('.content__header-item-btn-unselect-all').on('click', () => {
    $('.content__table-table input:checkbox').prop('checked', false);
});

$('.select_all').on('change', () => {
    $('.content__table-table input:checkbox').prop('checked', $('.select_all').prop('checked'));
});

// xóa tất cả
$('.content__header-item-btn-del-all').on('click', () => {
    var isConfirmed = confirm('Bạn có chắc chắn muốn xóa mục đã chọn không?');
    if (isConfirmed) {
        // danh sách checkbox checked
        var checkboxElement = $('.content__table-body input:checkbox:checked');
        var ids = [];
        $.each(checkboxElement, function(index) {
            ids[index] = $(this).attr('data-id');
        });
        
        if (!ids.length) {
            alert('Vui lòng chọn ít nhất 1 mục');
        } else {
            $.ajax({
                url: 'index.php',
                type: 'POST',
                data: {
                    btn_delete: '',
                    id: ids
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    alert('Có lỗi xảy ra, vui lòng thử lại');
                }
            });
        }
    }
});

// reset form
$('.content__header-item-btn-reset').on('click', () => {
    $('.content__form')[0].reset();
});

// tìm kiếm hóa đơn (be)
$('.form__control-order').on('keyup', function() {
    var keyword = $(this).val();
    var status = $(this).next().val();

    order_search(keyword, status);
});

$('.form__select-order').on('change', function() {
    var status = $(this).val();
    var keyword = $(this).prev().val();

    order_search(keyword, status);
});

function order_search(keyword, status) {
    $.ajax({
        url: admin_url + '/order/index.php',
        type: 'POST',
        data: {
            keyword: keyword,
            status: status
        },
        success: function(result) {
            if (result.trim()) {
                $('.content__table-table tbody').html(result);
            } else {
                $('.content__table-table tbody').html(`<div class="alert alert-success">Không tìm thấy đơn hàng nào</div>`);
            }
            // ẩn phân trang
            $('.content__table-pagination').hide();
        },
        error: function() {
            console.log('Lỗi');
        }
    });
}

// tìm kiếm sản phẩm trang be
$('.form__control-product').on('keyup', function() {
    var keyword = $(this).val();
    var cate_id = $(this).next().val();
    productSearch(keyword, cate_id);
});

$('select[name="cate_id"]').on('change', function() {
    var keyword = $(this).prev().val();
    var cate_id = $(this).val();
    productSearch(keyword, cate_id);
});

function productSearch(keyword, cate_id) {
    $.ajax({
        url: admin_url + '/product/index.php',
        type: 'POST',
        data: {
            keyword: keyword,
            cate_id: cate_id,
            search: ''
        },
        success: function(result) {
            if (result.trim()) {
                $('.content__table-table tbody').html(result);
            } else {
                $('.content__table-table tbody').html(`<div class="alert alert-success">Không tìm thấy sản phẩm nào</div>`);
            }
            // ẩn phân trang
            $('.content__table-pagination').hide();
        },
        error: function() {
            console.log('Lỗi');
        }
    });
}

// tìm kiếm bình luận (be)
$('.form__control-cmt').on('keyup', function() {
    var keyword = $(this).val();
    $.ajax({
        url: admin_url + '/comment/index.php',
        type: 'POST',
        data: {
            keyword: keyword
        },
        success: function(result) {
            if (result.trim()) {
                $('.content__table-table tbody').html(result);
            } else {
                $('.content__table-table tbody').html(`<div class="alert alert-success">Không tìm thấy bình luận nào</div>`);
            }
            // ẩn phân trang
            $('.content__table-pagination').hide();
        },
        error: function() {
            console.log('Lỗi');
        }
    });
});

// tìm kiếm cmt theo sp
function commentSearch(evt) {
    var formElement = evt.target.closest('form');
    var product_id = formElement.getAttribute('data-product-id');
    var keyword = formElement.querySelector('input[name="detail_keyword"]').value;
    var user_id = formElement.querySelector('select[name="user_id"]').value;
    var rating_number = formElement.querySelector('select[name="rating"]').value;

    $.ajax({
        url: admin_url + '/comment/index.php',
        type: 'POST',
        data: {
            p_id: product_id,
            content: keyword,
            u_id: user_id,
            rating: rating_number,
            cmt_detail_search: ''
        },
        success: function(result) {
            if (result.trim()) {
                // console.log(result);
                $('.content__table-body').html(result);
            } else {
                $('.content__table-body').html(`<div class="alert alert-success">Không tìm thấy bình luận nào</div>`);
            }
            // ẩn phân trang
            $('.content__table-pagination').hide();
        },
        error: function() {
            console.log('Lỗi');
        }
    });
}

$('.form__control-cmt-detail').on('keyup', function(event) {
    commentSearch(event);
});

$('.form__control-cmt-user').on('change', function(event) {
    commentSearch(event);
});

$('.form__control-cmt-rating').on('change', function(event) {
    commentSearch(event);
});

// tìm kiếm thuộc tính theo tên sp
$('.form__control-attribute').on('keyup', function() {
    var keyword = $(this).val();
    $.ajax({
        url: admin_url + '/attribute/index.php',
        type: 'POST',
        data: {
            keyword: keyword
        },
        success: function(result) {
            if (result.trim()) {
                $('.content__table-body').html(result);
            } else {
                $('.content__table-body').html(`<div class="alert alert-success">Không tìm thấy kết quả nào</div>`);
            }
            // ẩn phân trang
            $('.content__table-pagination').hide();
        },
        error: function() {
            console.log('Lỗi');
        }
    });
});

// tìm kiếm voucher
$('.form__control-voucher').on('keyup', function() {
    var keyword = $(this).val();
    $.ajax({
        url: admin_url + '/voucher/index.php',
        type: 'POST',
        data: {
            keyword: keyword
        },
        success: function(result) {
            if (result.trim()) {
                $('.content__table-body').html(result);
            } else {
                $('.content__table-body').html(`<div class="alert alert-success">Không tìm thấy kết quả nào</div>`);
            }
            // ẩn phân trang
            $('.content__table-pagination').hide();
        },
        error: function() {
            console.log('Lỗi');
        }
    });
});

// tìm kiếm đặt bàn
$('.form__control-booking').on('keyup', function() {
    var keyword = $(this).val();
    $.ajax({
        url: admin_url + '/booking/index.php',
        type: 'POST',
        data: {
            booking_search: '',
            bk_keyword: keyword
        },
        success: function(result) {
            if (result.trim()) {
                $('.content__table-table tbody').html(result);
            } else {
                $('.content__table-table tbody').html(`<div class="alert alert-success">Không tìm thấy kết quả nào</div>`);
            }
            // ẩn phân trang
            $('.content__table-pagination').hide();
        },
        error: function() {
            console.log('Lỗi');
        }
    });
});

// button logs
$('.content__header-item-btn--log').on('click', function() {
    var order_id = $(this).attr('data-order-id');

    $.ajax({
        url: admin_url + '/order/index.php',
        type: 'POST',
        data: {
            btn_log: '',
            order_id: order_id
        }, success: function(data) {
            $('.logs__inner-body').html(data);
            toggleLogs();
        }, error: function() {
            alert('Có lỗi xảy ra, vui lòng thử lại');
        }
    });
});

$('.logs__inner-header-icon').on('click', function() {
    toggleLogs();
});

$('.logs__overlay').on('click', function() {
    toggleLogs();
});

$('.logs__inner-footer-close').on('click', function() {
    toggleLogs();
});

function toggleLogs() {
    $('.logs__wrapper').toggleClass('active');
}