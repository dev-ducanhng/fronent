<link rel="stylesheet" href="/stores/css/list-insurance.css" type="text/css" />

<div class="container">
    <div class="breadcrumbs">
        <a href="https://thebank.vn">Trang chủ</a>
        <i></i>
        <span>Danh sách công ty bảo hiểm</span>
    </div>
    <div class="hr">
        <hr>
    </div>
    <div class="list_insurance">
        <div class="title">
            <h1>DANH SÁCH CÁC CÔNG TY BẢO HIỂM TẠI VIỆT NAM
            </h1>
        </div>
        <div class="description">
            <p>Cập nhật thông tin liên hệ, thông tin giao dịch, danh sách chi nhánh, văn phòng đại lý bảo hiểm và sản phẩm bảo hiểm của các công ty bảo hiểm trên toàn quốc</p>
            <h3 style="display: none;">Danh sách công ty bảo hiểm</h3>
        </div>
        <div class="list_hr">
            <hr>
        </div>
        <div class="list">
            <div class="row">
                <?php foreach ($data2 as $key => $item) : ?>
                    <div class="col_style col-6 col-md-3 <?php if ($key >= 20) echo "mobile_hidden" ?>">
                        <a href="<?= $item['url'] ?>" target="_blank">
                            <i class="icon_list"></i>
                            <span class="span_list"><?= $item['name'] ?></span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="see_more">
                <button class="btn_see_more">
                    <span class="span_see_more">Xem thêm</span>
                    <i class="icon_see_more"></i>
                </button>
            </div>
        </div>
    </div>
    <h3 class="d-none">Đăng nhập</h3>
    <h3></h3>
    <h3 class="d-none">Xác thực mã OTP</h3>
    <h3 class="d-none">Xác thực mã OTP</h3>
    <h4 class="d-none">Chào buổi sáng, chào mừng bạn quay lại :)</h4>
    <h4></h4>
    <h4 class="d-none">Modal title</h4>
</div>
<script src="/stores/js/jquery.min.js"></script>
<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        var count_click = 1;
        $('.btn_see_more').click(function() {
            var page_size = ++count_click * 20;
            var max_click = <?= $max_click ?>;

            for (i = 1; i <= page_size; i++) {
                $('.col_style:nth-child(' + i + ')').removeClass('mobile_hidden');

            }
            if (count_click == (max_click + 1)) {
                $('.see_more').hide();
            }
        });
    });
</script>