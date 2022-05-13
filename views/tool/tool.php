<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Post */

?>
<link rel="stylesheet" href="/stores/css/tool.css" type="text/css">

<div class="container">
    <div class="title">
        <a href="https://thebank.vn">Trang chủ</a>
        <i></i>
        <span>Công cụ tài chính</span>
    </div>
    <div class="gr-layout">
        <div class="gr-layout-card ">
            <div class="bd-group">
                <div class="gr-title-card">
                    <h2>Công cụ tài chính</h2>
                    <span>Giúp khách hàng sử dụng các sản phẩm tài chính tối ưu nhất
                    </span>
                </div>

                <div class="row">
                    <!-- group 1 -->
                    <div class="col-lg-4 col-md-6 col-12 hoverr">
                        <div class="gr-content-card">
                            <a href="https://thebank.vn/cong-cu/diem-uu-dai.html"
                                class="card_image" target="_blank">
                                <img alt="Điểm ưu đãi" src="/stores/images/tool/img-1.png"  class="ims">
                            </a>
                            <div class="heading ">
                                <a href="https://thebank.vn/cong-cu/diem-uu-dai.html"
                                    class="text-title" target="_blank">Tra cứu điểm ưu đãi</a>
                                <p>
                                  + <?= $count['indexpromotionsports'] ?>  Khách hàng đã sử dụng
                                </p>

                            </div>
                        </div>
                    </div>
                    <!-- group 2 -->
                    <div class="col-lg-4 col-md-6 col-12 hoverr">
                        <div class="gr-content-card">
                            <a href="https://thebank.vn/cong-cu/tim-atm.html"
                                class="card_image" target="_blank">
                                <img alt="Tìm atm" src="/stores/images/tool/img-2.png" class="ims">
                            </a>
                            <div class="heading ">
                                <a href="https://thebank.vn/cong-cu/tim-atm.html"
                                    class="text-title" target="_blank">Tìm ATM</a>
                                <p>
                                + <?= $count['toolatm'] ?> Khách hàng đã sử dụng
                                </p>

                            </div>
                        </div>
                    </div>
                    <!-- group 3 -->
                    <div class="col-lg-4 col-md-6 col-12 hoverr">
                        <div class="gr-content-card">
                            <a href="https://thebank.vn/cong-cu/tim-chi-nhanh-ngan-hang.html"
                                class="card_image" target="_blank">
                                <img alt="Tìm chi nhánh ngân hàng" src="/stores/images/tool/img-3.png" class="ims">
                            </a>
                            <div class="heading ">
                                <a href="https://thebank.vn/cong-cu/tim-chi-nhanh-ngan-hang.html"
                                    class="text-title" target="_blank">tìm chi nhánh ngân hàng</a>
                                <p>
                                    + <?= $count['toolbranch'] ?> Khách hàng đã sử dụng
                                </p>

                            </div>
                        </div>
                    </div>
                    <!-- group 4 -->
                    <div class="col-lg-4 col-md-6 col-12 hoverr">
                        <div class="gr-content-card">
                            <a href="https://thebank.vn/cong-cu/tinh-ty-gia-ngoai-te.html" 
                                class="card_image" target="_blank">
                                <img alt="Tính tỷ giá ngoại tệ" src="/stores/images/tool/img-4.png" class="ims">
                            </a>
                            <div class="heading ">
                                <a href="https://thebank.vn/cong-cu/tinh-ty-gia-ngoai-te.html"
                                    class="text-title" target="_blank">Tính tỷ giá ngoại tệ</a>
                                <p>
                                  + <?= $count['exchangerate'] ?> Khách hàng đã sử dụng
                                </p>

                            </div>
                        </div>
                    </div>
                    <!-- group 5 -->
                    <div class="col-lg-4 col-md-6 col-12 hoverr">
                        <div class="gr-content-card">
                            <a href="https://thebank.vn/cong-cu/tinh-lai-tien-gui-tiet-kiem.html"
                                class="card_image" target="_blank">
                                <img alt="Tính lãi tiền gửi tiết kiệm" src="/stores/images/tool/img-5.png" class="ims">
                            </a>
                            <div class="heading ">
                                <a href="https://thebank.vn/cong-cu/tinh-lai-tien-gui-tiet-kiem.html"
                                    class="text-title" target="_blank">Tính lãi tiền gửi</a>
                                <p>
                                    + <?= $count['savingsrate'] ?> Khách hàng đã sử dụng
                                </p>

                            </div>
                        </div>
                    </div>
                    <!-- group 6 -->
                    <div class="col-lg-4 col-md-6 col-12 hoverr">
                        <div class="gr-content-card">
                            <a href="https://thebank.vn/cong-cu/uoc-tinh-so-tien-co-the-vay.html"
                                class="card_image" target="_blank">
                                <img alt="Ước tính số tiền có thể vay" src="/stores/images/tool/img-6.png" class="ims">
                            </a>
                            <div class="heading ">
                                <a href="https://thebank.vn/cong-cu/uoc-tinh-so-tien-co-the-vay.html"
                                    class="text-title" target="_blank">Ước tính số tiền có thể vay</a>
                                <p>
                                    + <?= $count['interestrate'] ?> Khách hàng đã sử dụng
                                </p>

                            </div>
                        </div>
                    </div>
                    <!-- group 7 -->
                    <div class="col-lg-4 col-md-6 col-12 hoverr">
                        <div class="gr-content-card">
                            <a href="https://thebank.vn/cong-cu/uoc-tinh-so-tien-vay-phai-tra-hang-thang.html"
                                class="card_image" target="_blank">
                                <img alt="Ước tính số tiền vay phải trả hàng tháng" src="/stores/images/tool/img-7.png" class="ims">
                            </a>
                            <div class="heading ">
                                <a href="https://thebank.vn/cong-cu/uoc-tinh-so-tien-vay-phai-tra-hang-thang.html"
                                    class="text-title" target="_blank">ước tính số tiền vay
                                    <br/>phải trả ngân hàng</a>
                                <p>
                                    + <?= $count['interestrate'] ?> Khách hàng đã sử dụng
                                </p>

                            </div>
                        </div>
                    </div>
                    <!-- group 8 -->
                    <div class="col-lg-4 col-md-6 col-12 hoverr">
                        <div class="gr-content-card">
                            <a href="https://thebank.vn/cong-cu/tim-chi-nhanh-cong-ty-bao-hiem.html"
                                class="card_image" target="_blank">
                                <img alt="Tìm chi nhánh công ty bảo hiểm" src="/stores/images/tool/img-8.png" class="ims">
                            </a>
                            <div class="heading ">
                                <a href="https://thebank.vn/cong-cu/tim-chi-nhanh-cong-ty-bao-hiem.html"
                                    class="text-title" target="_blank">tìm chi nhánh công ty bảo hiểm</a>
                                <p>
                                + <?= $count['chat_online'] ?> Khách hàng đã sử dụng

                            </div>
                        </div>
                    </div>
                    <!-- group 9 -->
                    <div class="col-lg-4 col-md-6 col-12 hoverr">
                        <div class="gr-content-card">
                            <a href="https://thebank.vn/cong-cu/internet-banking.html"
                                class="card_image" target="_blank">
                                <img alt="Internet banking" src="/stores/images/tool/img-9.png" class="ims">
                            </a>
                            <div class="heading ">
                                <a href="https://thebank.vn/cong-cu/internet-banking.html"
                                    class="text-title" target="_blank">danh bạ internet banking</a>
                                <p>
                                + <?= $count['internetbanking'] ?> Khách hàng đã sử dụng
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<H1 style="display:none;">TRA CỨU ĐIỂM ƯU ĐÃI</H2>
<H2 style="display:none;">Tìm ATM</H2>
<H2 style="display:none;">TÌM CHI NHÁNH NGÂN HÀNG</H2>
<H2 style="display:none;">TÍNH TỶ GIÁ NGOẠI TỆ</H2>
<H2 style="display:none;">TÍNH LÃI TIỀN GỬI</H2>
<H2 style="display:none;">ƯỚC TÍNH SỐ TIỀN CÓ THỂ VAY</H2>
<H2 style="display:none;">ƯỚC TÍNH SỐ TIỀN VAY PHẢI TRẢ HÀNG THÁNG</H2>
<H2 style="display:none;">TÌM CHI NHÁNH CÔNG TY BẢO HIỂM</H2>
<H2 style="display:none;">DANH BẠ INTERNET BANKING</H2>
<H3 style="display:none;"></H3>
<H3 style="display:none;">Đăng nhập</H3>
<H3 style="display:none;">Xác thực mã OTP</H3>
<H3 style="display:none;">Xác thực mã OTP</H3>
<H4 style="display:none;">Chào buổi chiều, chào mừng bạn quay lại :)</H4>
<H4 style="display:none;"></H4>
<H4 style="display:none;">Modal title</H4>
