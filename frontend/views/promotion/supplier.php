<link rel="stylesheet" href="/stores/css/chosen.css">
<script src="/stores/js/chosen.jquery.js"></script>
<link rel="stylesheet" href="/stores/css/promotion/supplier.css" type="text/css">
<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        $(".chosen_js").chosen({
            width: '100%'
        });
    });
</script>
<div class="container">
    <div class="breadcrumbs" id="breadcrumbs_supplier">
        <a target="_blank" href="https://thebank.vn">Trang chủ</a>
        <i></i>
        <a target="_blank" href="https://thebank.vn/cong-cu.html">Công cụ</a>
        <i></i>
        <a target="_blank" href="https://thebank.vn/cong-cu/diem-uu-dai.html">Điểm ưu đãi thẻ tín dụng</a>
        <i></i>
        <span>Danh sách nhà cung cấp</span>
    </div>
    <div class="sup_head">
        <h2>Nhà cung cấp dịch vụ</h2>
        <form action="" method="get">
            <div class="row">
                <div class="col_style2 col-12 col-sm-6 col-lg-4">
                    <div class="province">
                        <i class="icon_dichvu"></i>
                        <select name="service" class="select_province chosen_js" id="service">
                            <option value="">Dịch vụ</option>
                            <?php foreach ($all_service as $item) : ?>
                                <option value="<?= $item['id'] ?>" <?php if (isset($_GET['service'])) {
                                                                        if ($item['id'] == $_GET['service']) {
                                                                            echo "selected";
                                                                        }
                                                                    } ?>><?= $item['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col_style2 col-12 col-sm-6 col-lg-4">
                    <div class="province">
                        <i class="icon_province"></i>
                        <select name="province" class="select_province chosen_js" id="province">
                            <option value="">Tỉnh/Thành phố</option>
                            <?php foreach ($province as $item) : ?>
                                <option value="<?= $item['id'] ?>" <?php if (isset($_GET['province'])) {
                                                                        if ($item['id'] == $_GET['province']) {
                                                                            echo "selected";
                                                                        }
                                                                    } ?>><?= $item['province_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col_style2 col-6 col-sm-6 col-lg-4" id="btn_btn_btn">
                    <div class="button_submit">
                        <button type="submit" class="btn_submit" id="btn_submit">
                            <i></i>
                            <span class="span_button">Tìm kiếm</span>
                        </button>
                    </div>

                </div>

            </div>
        </form>
    </div>
    <div class="content_supplier">
        <div class="w_list_endov">
            <div class="nav_dsncc">
                <p>
                    <span class="dsncc">Danh sách nhà cung cấp <span class="hiden_540">|</span> </span>
                    Tìm thấy <?= $count ?> nhà cung cấp
                </p>
            </div>

            <div class="list_endov">
               
                <?php foreach ($arr_all_provider as $item) : ?>
                    <div class="list_child">
                        <div class="img_supplier_child">
                            <a href="<?= $item['url_detail'] ?>">
                                <img src="<?= $item['avatar'] ?>" alt="">
                            </a>
                        </div>
                        <div class="info_child_providers">
                            <a href="<?= $item['url_detail'] ?>">

                                <?= $item['name'] ?>
                            </a>
                            <p>
                                <span class="start">

                                    <img src="/stores/images/supplier/sao100.svg" alt="anh">
                                    <img src="/stores/images/supplier/sao100.svg" alt="anh">
                                    <img src="/stores/images/supplier/sao100.svg" alt="anh">
                                    <img src="/stores/images/supplier/sao100.svg" alt="anh">
                                    <img src="/stores/images/supplier/sao100.svg" alt="anh">
                                </span>
                                <span class="view">
                                    <?= $item['viewed'] ?> lượt xem
                                </span>
                            </p>
                            <div class="comment">
                                <div class="child_sl_ud">
                                    <?= $item['total_promotion'] ?> ưu đãi
                                </div>
                                <div>
                                    <span>
                                        <img src="/stores/images/supplier/bl.svg" alt="">
                                    </span>
                                    <span class="bl">

                                        <a href="<?= $item['url_detail'] ?>#binh_luan">Bình luận</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="box_see_more">
                <span> Xem thêm nhà cung cấp (3.292) <i class="icon_see_more"></i></span>
            </div>
        </div>
        <div class="list_providers">
            <h2 class="Latest">Điểm ưu đãi mới nhất</h2>
            
            <?php foreach ($arr_all_pro as $item) : ?>
                <div class="child_providers">
                <div class="child_p_img">
                    <div>
                        <span class="percent_service"> <?= $item['amount']?>% </span>
                    </div>
                    <div>
                        <a href="<?= $item['url_detail']?>">

                         <img  class="c_p_img" src="<?= $item['img']?>" alt="">
                        </a>
                       
                    </div>

                </div>
                <div>
                    <p class="c_p_name">
                        <a href="<?= $item['url_detail']?>"><?= $item['provider_name']?></a>
                        
                    </p>
                    <p>
                        <span class="new_lx"><?= $item['viewed']?> lượt xem -</span>
                        <span class="new_bl">
                             <a href="<?= $item['url_detail']?>#binh_luan">Bình luận</a> 
                            </span>
                    </p>
                    <p>
                        <img src="/stores/images/supplier/sao100.svg" alt="anh">
                        <img src="/stores/images/supplier/sao100.svg" alt="anh">
                        <img src="/stores/images/supplier/sao100.svg" alt="anh">
                        <img src="/stores/images/supplier/sao100.svg" alt="anh">
                        <img src="/stores/images/supplier/sao100.svg" alt="anh">
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="see_all_providers">
                <a href="#">Xem tất cả các điểm ưu đãi</a>
            </div>
        </div>

    </div>
</div>