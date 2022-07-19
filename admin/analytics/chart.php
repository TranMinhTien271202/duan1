        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Thống kê</h5>
                        <span class="content__header-description">Thống kê loại hàng</span>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap order__card">
                    <div class="order__card-item order__card-item--new">
                        <div class="order__card-item-inner">
                            <div class="order__card-content">
                                <div class="order__card-content-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="order__card-content-text">
                                    <strong><?=$totalOrderNew;?></strong>
                                    <p>Đơn hàng mới</p>
                                </div>
                            </div>
                            <div class="order__card-percent" style="--width-percent: <?=($totalOrderNew/$totalOrder) * 100;?>%;"></div>
                        </div>
                    </div>
                    <div class="order__card-item order__card-item--verified">
                        <div class="order__card-item-inner">
                            <div class="order__card-content">
                                <div class="order__card-content-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="order__card-content-text">
                                    <strong><?=$totalOrderVerified;?></strong>
                                    Đã xác nhận
                                </div>
                            </div>
                            <div class="order__card-percent" style="--width-percent: <?=($totalOrderVerified/$totalOrder) * 100;?>%;"></div>
                        </div>
                    </div>
                    <div class="order__card-item order__card-item--progress">
                        <div class="order__card-item-inner">
                            <div class="order__card-content">
                                <div class="order__card-content-icon">
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                                <div class="order__card-content-text">
                                    <strong><?=$totalOrderShip;?></strong>
                                    Đang giao hàng
                                </div>
                            </div>
                            <div class="order__card-percent" style="--width-percent: <?=($totalOrderShip/$totalOrder) * 100;?>%;"></div>
                        </div>
                    </div>
                    <div class="order__card-item order__card-item--success">
                        <div class="order__card-item-inner">
                            <div class="order__card-content">
                                <div class="order__card-content-icon">
                                    <i class="fas fa-money-check"></i>
                                </div>
                                <div class="order__card-content-text">
                                    <strong><?=$totalOrderSuccess;?></strong>
                                    Đã giao hàng
                                </div>
                            </div>
                            <div class="order__card-percent" style="--width-percent: <?=($totalOrderSuccess/$totalOrder) * 100;?>%;"></div>
                        </div>
                    </div>
                    <div class="order__card-item order__card-item--cancel">
                        <div class="order__card-item-inner">
                            <div class="order__card-content">
                                <div class="order__card-content-icon">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div class="order__card-content-text">
                                    <strong><?=$totalOrderCancel;?></strong>
                                    Đã hủy
                                </div>
                            </div>
                            <div class="order__card-percent" style="--width-percent: <?=($totalOrderCancel/$totalOrder) * 100;?>%;"></div>
                        </div>
                    </div>
                </div>

                <div class="content__table-wrap dashboard__card">
                    <div class="dashboard__card-item">
                        <div class="dashboard__card-item-inner">
                            <div class="dashboard__card-content">
                                <div class="dashboard__card-content-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="dashboard__card-content-text">
                                    <strong><?=$totalProduct;?></strong>
                                    <p>Số sản phẩm hiện có</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard__card-item">
                        <div class="dashboard__card-item-inner">
                            <div class="dashboard__card-content">
                                <div class="dashboard__card-content-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="dashboard__card-content-text">
                                    <strong><?=$totalUser;?></strong>
                                    <p>Số tài khoản hiện có</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard__card-item">
                        <div class="dashboard__card-item-inner">
                            <div class="dashboard__card-content">
                                <div class="dashboard__card-content-icon">
                                    <i class="fas fa-money-check"></i>
                                </div>
                                <div class="dashboard__card-content-text">
                                    <strong><?=$totalMoney ? number_format($totalMoney['total']) . ' VNĐ' : 0;?></strong>
                                    <p>Tổng doanh thu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content__dashboard">
                    <div class="content__table-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Thống kê hàng hóa theo loại</h3>
                            <span class="content__table-text">Analytic management made easy</span>
                        </div>
    
                        <section class="content__analytics">
                            <div id="chart"></div>
                        </section>
                    </div>

                    <div class="content__table-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Thống kê tài khoản</h3>
                            <span class="content__table-text">User management made easy</span>
                        </div>
    
                        <section class="content__analytics">
                            <div id="chart_user"></div>
                        </section>
                    </div>

                </div>

                <!-- thống kê sản phẩm bán chạy -->
                <div class="content__table-wrap">
                    <section class="content__analytics">
                        <div id="chart_product-trend"></div>
                    </section>
                </div>

                <!-- thống kê người dùng đăng ký theo tháng -->
                <div class="content__table-wrap">
                    <section class="content__analytics">
                        <div id="chart_user-register"></div>
                    </section>
                </div>

                <!-- thống kê doanh thu -->
                <div class="content__table-wrap">
                    <section class="content__analytics">
                        <div id="chart_price"></div>
                    </section>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            <script>
                // chart product
                var optionsChartProduct = {
                    series: [<?php foreach ($quantityAnalytics as $item) { echo $item['totalProduct'] . ', ' ;}?>],
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    labels: [<?php foreach ($quantityAnalytics as $item) { echo "'$item[cate_name]', " ;}?>],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chartProduct = new ApexCharts(document.querySelector("#chart"), optionsChartProduct);
                chartProduct.render();

                // chart user
                var optionsChartUser = {
                    series: [<?php foreach ($userAnalytics as $item) { echo $item['total'] . ', ' ;}?>],
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    colors:['rgb(0, 143, 251)', 'rgb(255, 69, 96)'],
                    labels: [<?php foreach ($userAnalytics as $item) { echo ($item['active'] ? '"Đang hoạt động"' : '"Bị khóa"') . ', ' ;}?>],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chartUser = new ApexCharts(document.querySelector("#chart_user"), optionsChartUser);
                chartUser.render();

                // chart user register
                var optionsChartUserReg = {
                    series: [{
                        name: "User",
                        data: [<?php foreach ($userRegAnalytics as $item) { echo $item['total'] . ', '; }?>]
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    title: {
                        text: 'Thông kê khách hàng đăng ký theo tháng',
                        align: 'left'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: [<?php foreach ($userRegAnalytics as $item) { echo "'Tháng $item[month]', ";}?>],
                    }
                };
                var chartUserReg = new ApexCharts(document.querySelector("#chart_user-register"), optionsChartUserReg);
                chartUserReg.render();

                // sản phẩm bán chạy
                var optionsProductTrend = {
                    series: [{
                        name: 'Đã bán',
                        data: [<?php foreach ($analyticsProductTrend as $item) {echo $item['total'] . ', ';};?>]
                    }],
                    // annotations: {
                    //     points: [{
                    //         x: 'Bananas',
                    //         seriesIndex: 0,
                    //         label: {
                    //             borderColor: '#775DD0',
                    //             offsetY: 0,
                    //         style: {
                    //             color: '#fff',
                    //             background: '#775DD0',
                    //         },
                    //             text: 'Bananas are good',
                    //         }
                    //     }]
                    // },
                    chart: {
                        height: 350,
                        type: 'bar',
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 10,
                            columnWidth: '50%',
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2
                    },
                    
                    grid: {
                        row: {
                            colors: ['#fff', '#f2f2f2']
                        }
                    },
                    xaxis: {
                        labels: {
                            rotate: -45
                        },
                        categories: [<?php foreach ($analyticsProductTrend as $item) {echo "'$item[product_name]', ";}?>],
                        tickPlacement: 'on'
                    },
                    yaxis: {
                        title: {
                            text: 'Top Product',
                        },
                        labels: {
                            formatter: function(val, index) {
                                return val;
                            }
                        }
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: "horizontal",
                            shadeIntensity: 0.25,
                            gradientToColors: undefined,
                            inverseColors: true,
                            opacityFrom: 0.85,
                            opacityTo: 0.85,
                            stops: [50, 0, 100]
                        },
                    }
                };

                var chartProductTrend = new ApexCharts(document.querySelector("#chart_product-trend"), optionsProductTrend);
                chartProductTrend.render();
                
                // thống kê doanh thu
                var optionsChartPrice = {
                    series: [{
                        name: "Tổng tiền",
                        data: [<?php foreach ($priceAnalytics as $item) { echo $item['totalPrice'] . ', '; }?>]
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    title: {
                        text: 'Thông kê doanh thu hàng tháng',
                        align: 'left'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: [<?php foreach ($priceAnalytics as $item) { echo "'Tháng $item[month]', ";}?>],
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val, index) {
                                val = val.toLocaleString('it-IT', {style : 'currency', currency : 'VND'});
                                return val;
                            }
                        }
                    }
                };

                var chartPrice = new ApexCharts(document.querySelector("#chart_price"), optionsChartPrice);
                chartPrice.render();
            </script>
        </main>