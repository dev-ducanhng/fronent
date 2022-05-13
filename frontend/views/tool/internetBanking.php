<script src="/stores/js/jquery.min.js"></script>

<link rel="stylesheet" href="/stores/css/internet-banking.css" type="text/css" />

<script>
$(document).ready(function() {

    $('.tab_inter').click(function() {
        var data_link = $(this).attr('data-link');
        $('.tab_inter').removeClass('active');
        $(this).addClass('active');
        $('.content_tab').hide();
        $('#' + data_link).fadeIn(300);
    });
});
</script>

<div class="main-internet-banking container">
    <div class="breadcrumbs">
        <a href="https://thebank.vn">Trang chủ</a>
        <i></i>
        <a href="https://thebank.vn/cong-cu.html">Công cụ</a>
        <i></i>
        <span>Internet Banking</span>
    </div>

    <div class="container-internet-banking">
        <h1 class="title-internet-banking">Kết nối hệ thống Internet Banking, Ebanking</h1>
        <div class="description-internet-banking">Giao dịch trực tuyến thông qua Internet Banking, Ebanking của các ngân
            hàng Việt Nam</div>
        <ul class="tab-internet-banking">
            <li class="tab-left tab_inter active" data-link="tab1">
                <a href="javascript:void(0)" id="tab-left">
                    <i></i>
                    <div class="tab-left-distance"></div>
                    <span>Cá nhân</span>
                </a>
            </li>

            <li class="tab-right tab_inter" data-link="tab2">
                <a href="javascript:void(0)" id="tab-right">
                    <i></i>
                    <div class="tab-right-distance"></div>
                    <span>Doanh nghiệp</span>
                </a>
            </li>
        </ul>

        <div class="list-internet-banking content_tab active" id="tab1">


            <ul class="ul-internet-banking">
                <?php foreach ($companies as $items ) : ?>


                <li class="li-internet-banking">
                    <i></i>
                    <div class="li-internet-banking-distance"></div>
                    <a href="<?php
                    if ($items['individual'] == null) {
                        echo "javascript:;";
                    } else {
                        echo $items['individual'];
                    }
                    ?>>" <?php
                    $msg = '"TheBank hiện chưa cập nhật hệ thống InternetBanking của ngân hàng này."';
                    if ($items['individual'] == null) {
                        echo "onClick='return alert($msg)'";
                    }
                    ?>>

                        <?= $items['short_name'] ?> Online
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>

        </div>
        <div class="list-internet-banking content_tab " id="tab2">


            <ul class="ul-internet-banking">
                <?php foreach ($companies as $items ) : ?>


                <li class="li-internet-banking">
                    <i></i>
                    <div class="li-internet-banking-distance"></div>
                    <a href=" <?= $items['institutions'] ?>" 
                        onClick="return alert('TheBank hiện chưa cập nhật hệ thống InternetBanking của ngân hàng này.');">
                        <?= $items['short_name'] ?> Online
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>

        </div>

        <div class="page-internet-banking">

            <a href="javascript:void(0)">1</a>
            <a href="javascript:void(0)">2</a>
            <a href="javascript:void(0)">3</a>
            <a href="javascript:void(0)">Tiếp</a>
            <a href="javascript:void(0)"><i></i></a>

        </div>

    </div>

</div>