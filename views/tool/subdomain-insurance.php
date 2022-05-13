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
<style>
@media screen and (max-width: 1024px) {
    .main_page{
        margin-top: 0;
    }
}
</style>
<div class="main-internet-banking container">
    <div class="breadcrumbs">
        <a href="https://thebank.vn">Trang chủ</a>
        <i></i>
        <span>Danh bạ ngân hàng</span>
    </div>

    <div class="container-internet-banking">
        <h1 class="title-internet-banking">danh bạ các ngân hàng tại việt nam</h1>
        <div class="description-internet-banking des_sub">Cập nhật tin tức, thông tin liên hệ, thông tin giao dịch, danh sách chi nhánh, mạng lưới cây ATM và sản phẩm tài chính các ngân hàng trên toàn quốc.</div>
        <div class="list-internet-banking content_tab active" id="tab1">
            <ul class="ul-internet-banking">
                <?php foreach ($companies as $items ) :
                    if ($items['short_name'] == null) {
                        $url = "";
                    } else {
                        $url = 'https://thebank.vn/ngan-hang-' . $this->context->actionSlug($items['short_name']) . '-' . $items['id'] . '.html';
                    }
                ?>

                <?php if(!empty($url)) : ?>
                    <li class="li-internet-banking li_sub">
                        <i></i>
                        <div class="li-internet-banking-distance"></div>
                        <a href="<?= $url ?>">
                            <?= $items['short_name'] ?> 
                        </a>
                    </li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>

</div>