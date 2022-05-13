<link rel="stylesheet" href="/stores/css/find-insurance.css" type="text/css" />
<link rel="stylesheet" href="/stores/css/chosen.css">
<script src="/stores/js/jquery.min.js"></script>
<script src="/stores/js/chosen.jquery.js"></script>
<script type='text/javascript' src='/stores/js/jquery.simply-toast.js' async="async"></script>
<script src="/stores/js/mustache.min.js"></script>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        $('#province').change(function() {
            var province_id = $(this).val();
            $.ajax({
                url: '/tool/get-district',
                data: {
                    province_id: province_id
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);

                    var option = '<option value="">Quận/Huyện</option>';
                    $.each(jsonData, function(key, val) {
                        option += '<option value="' + key + '">' + val + '</option>'
                    });
                    $('#district').html(option).trigger('chosen:updated');
                }
            });
        });

        $(".chosen_js").chosen({
            width: '100%'
        });

        var count_click = 1;
        var max_click = <?= $max_click ?>;
        var max_click_company = <?= isset($max_click_company) ? $max_click_company : 0 ?>;
        var max_click_province = <?= isset($max_click_province) ? $max_click_province : 0 ?>;
        $('.btn_see_more').click(function() {
            var page_size = ++count_click * 10;
            $.ajax({
                url: 'tim-chi-nhanh-ngan-hang.html',
                data: {
                    page_size: page_size
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_data_insurance_ex').html();
                    var rendered = '';
                    $.each(jsonData['data_bank'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#template_data_insurance").html(rendered);

                    if (count_click == (max_click + 1)) {
                        $('.see_more').hide();
                    }
                }
            });
        });

        var count_click_company = 1;
        $('.btn_see_more_company').click(function() {
            var page_size_company = ++count_click_company * 20;
            var company = $('#company').val();
            var company_name = removeUnicode($('#company option:selected').html());
            var URL = company_name + '-' + company + '.html';
            $.ajax({
                url: URL,
                data: {
                    page_size_company: page_size_company
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_data_company_ex').html();
                    var rendered = '';
                    $.each(jsonData['data_province'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#template_data_company").html(rendered);

                    if (count_click_company == (max_click_company + 1)) {
                        $('.see_more_company').addClass('hidden');
                        $('.hide_company').removeClass('hidden');
                    }
                }
            });
        });

        $('.btn_hide_company').click(function() {
            var page_size_company = 20;
            var company = $('#company').val();
            var company_name = removeUnicode($('#company option:selected').html());
            var URL = company_name + '-' + company + '.html';
            $.ajax({
                url: URL,
                data: {
                    page_size_company: page_size_company
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_data_company_ex').html();
                    var rendered = '';
                    $.each(jsonData['data_province'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#template_data_company").html(rendered);

                    $('.hide_company').addClass('hidden');
                    $('.see_more_company').removeClass('hidden');

                    count_click_company = 1;
                }
            });
        });

        var count_click_province = 1;
        $('.btn_see_more_province').click(function() {
            var page_size_province = ++count_click_province * 20;
            var company = $('#company').val();
            var company_name = removeUnicode($('#company option:selected').html());
            var province = $('#province').val();
            var province_name = removeUnicode($('#province option:selected').html());
            var URL = company_name + '-' + province_name + '-' + company + '-' + province + '.html';
            $.ajax({
                url: URL,
                data: {
                    page_size_province: page_size_province
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_data_province_ex').html();
                    var rendered = '';
                    $.each(jsonData['data_district'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#template_data_province_content").html(rendered);

                    if (count_click_province == (max_click_province + 1)) {
                        $('.see_more_province').addClass('hidden');
                        $('.hide_province').removeClass('hidden');
                    }
                }
            });
        });

        $('.btn_hide_province').click(function() {
            var page_size_province = 20;
            var company = $('#company').val();
            var company_name = removeUnicode($('#company option:selected').html());
            var province = $('#province').val();
            var province_name = removeUnicode($('#province option:selected').html());
            var URL = company_name + '-' + province_name + '-' + company + '-' + province + '.html';
            $.ajax({
                url: URL,
                data: {
                    page_size_province: page_size_province
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_data_province_ex').html();
                    var rendered = '';
                    $.each(jsonData['data_district'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#template_data_province_content").html(rendered);

                    $('.hide_province').addClass('hidden');
                    $('.see_more_province').removeClass('hidden');

                    count_click_province = 1;
                }
            });
        });

        var title = '';
        $('#btn_submit').on('click', function(e) {
            var error = false;
            var company = $('#company').val();
            var company_name = removeUnicode($('#company option:selected').html());
            var province = $('#province').val();
            var province_name = removeUnicode($('#province option:selected').html());
            var district = $('#district').val();
            var district_name = removeUnicode($('#district option:selected').html());

            if (company == '') {
                error = true;
            } else {
                if (province == '') {
                    var URL = encodeURI("cong-cu/tim-chi-nhanh-ngan-hang/" + company_name + '-' + company) + '.html';
                } else {
                    if (district == '') {
                        var URL = encodeURI("cong-cu/tim-chi-nhanh-ngan-hang/" + company_name + '-' + province_name + '-' + company + '-' + province) + '.html';
                    } else {
                        var URL = encodeURI("cong-cu/tim-chi-nhanh-ngan-hang/" + company_name + '-' + district_name + '-' + province_name + '-' + company + '-' + province + '-' + district + ".html");
                    }
                }
            }
            if (company == '' && province != '') {
                $('.simply-toast').fadeOut();
                $.simplyToast('warning', "Bạn muốn tìm chi nhánh của ngân hàng nào?");
            } else if (company == '' && province == '') {
                $('.simply-toast').fadeOut();
                $.simplyToast('warning', "Bạn muốn tìm chi nhánh của ngân hàng, Tỉnh/Thành Phố nào?");
            } else {
                window.location.href = window.location.protocol + '/' + URL;
            }
        });

        $('body').on('click', '.close', function() {
            $('.simply-toast').fadeOut();
        });
    });
</script>

<div class="container">
    <div class="breadcrumbs">
        <a href="https://thebank.vn">Trang chủ</a>
        <i></i>
        <a href="https://thebank.vn/cong-cu.html">Công cụ</a>
        <i></i>
        <?php if (!empty($_GET['company']) & empty($_GET['province'])) : ?>
            <a href="/cong-cu/tim-chi-nhanh-ngan-hang.html" class="span_pc">Tìm chi nhánh ngân hàng</a>
            <a href="/cong-cu/tim-chi-nhanh-ngan-hang.html" class="span_mobile">Tìm chi nhánh...</a>
            <i class="span_pc"></i>
            <span class="span_pc"><?= $array_company[$_GET['company']] ?></span>
        <?php elseif (!empty($_GET['company']) & !empty($_GET['province']) & empty($_GET['district'])) : ?>
            <a href="/cong-cu/tim-chi-nhanh-ngan-hang.html" class="span_pc">Tìm chi nhánh ngân hàng</a>
            <a href="/cong-cu/tim-chi-nhanh-ngan-hang.html" class="span_mobile">Tìm chi nhánh...</a>
            <i class="span_pc"></i>
            <a href="/cong-cu/tim-chi-nhanh-ngan-hang/<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= $_GET['company'] ?>.html" class="span_pc"><?= $array_company[$_GET['company']] ?></a>
            <i class="span_pc"></i>
            <span class="span_pc"><?= $array_province[$_GET['province']] ?></span>
        <?php elseif (!empty($_GET['company']) & !empty($_GET['province']) & !empty($_GET['district'])) : ?>
            <a href="/cong-cu/tim-chi-nhanh-ngan-hang.html" class="span_pc">Tìm chi nhánh ngân hàng</a>
            <a href="/cong-cu/tim-chi-nhanh-ngan-hang.html" class="span_mobile">Tìm chi nhánh...</a>
            <i class="span_pc"></i>
            <a href="/cong-cu/tim-chi-nhanh-ngan-hang/<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= $_GET['company'] ?>.html" class="span_pc"><?= $array_company[$_GET['company']] ?></a>
            <i class="span_pc"></i>
            <a href="/cong-cu/tim-chi-nhanh-ngan-hang/<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= $this->context->actionSlug($array_province[$_GET['province']]) ?>-<?= $_GET['company'] ?>-<?= $_GET['province'] ?>.html" class="span_pc"><?= $array_province[$_GET['province']] ?></a>
            <i class="span_pc"></i>
            <span class="span_pc"><?= $array_district[$_GET['district']] ?></span>
        <?php else : ?>
            <span class="span_pc">Tìm chi nhánh ngân hàng</span>
            <span class="span_mobile">Tìm chi nhánh...</span>
        <?php endif; ?>
    </div>
    <div class="filter">
        <div class="title">
            <?php if (!empty($_GET['company']) & empty($_GET['province'])) : ?>
                <h1>CHI NHÁNH, PHÒNG GIAO DỊCH NGÂN HÀNG <?= mb_strtoupper($array_company[$_GET['company']], 'UTF-8') ?> TRÊN TOÀN QUỐC</h1>
            <?php elseif (!empty($_GET['company']) & !empty($_GET['province']) & empty($_GET['district'])) : ?>
                <h1>CHI NHÁNH, PHÒNG GIAO DỊCH NGÂN HÀNG <?= mb_strtoupper($array_company[$_GET['company']], 'UTF-8') ?> TẠI <?= mb_strtoupper($array_province[$_GET['province']], 'UTF-8') ?></h1>
            <?php elseif (!empty($_GET['company']) & !empty($_GET['province']) & !empty($_GET['district'])) : ?>
                <h1>CHI NHÁNH, PHÒNG GIAO DỊCH NGÂN HÀNG <?= mb_strtoupper($array_company[$_GET['company']], 'UTF-8') ?> TẠI <?= mb_strtoupper($array_district[$_GET['district']], 'UTF-8') ?> - <?= mb_strtoupper($array_province[$_GET['province']], 'UTF-8') ?></h1>
            <?php else : ?>
                <h1>CHI NHÁNH, PHÒNG GIAO DỊCH NGÂN HÀNG NGÂN HÀNG TRÊN TOÀN QUỐC</h1>
            <?php endif; ?>
        </div>
        <div class="description">
            <?php if (!empty($_GET['company']) & empty($_GET['province'])) : ?>
                <h2>Cập nhật danh sách địa chỉ chi nhánh, phòng giao dịch <a href="https://thebank.vn/ngan-hang-<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= $_GET['company'] ?>.html"><?= $array_company[$_GET['company']] ?></a> trên toàn quốc, giúp bạn tiết kiệm tối đa thời gian di chuyển.</h2>
            <?php elseif (!empty($_GET['company']) & !empty($_GET['province']) & empty($_GET['district'])) : ?>
                <h2>Cập nhật danh sách địa chỉ chi nhánh, phòng giao dịch của ngân hàng <a href="https://thebank.vn/ngan-hang-<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= $_GET['company'] ?>.html"><?= $array_company[$_GET['company']] ?></a> tại <?= $array_province[$_GET['province']] ?>, giúp bạn tiết kiệm tối đa thời gian di chuyển.</h2>
            <?php elseif (!empty($_GET['company']) & !empty($_GET['province']) & !empty($_GET['district'])) : ?>
                <h2>Cập nhật danh sách địa chỉ chi nhánh, phòng giao dịch của ngân hàng <a href="https://thebank.vn/ngan-hang-<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= $_GET['company'] ?>.html"><?= $array_company[$_GET['company']] ?></a> tại <?= $array_district[$_GET['district']] ?> - <?= $array_province[$_GET['province']] ?>, giúp bạn tiết kiệm tối đa thời gian di chuyển.</h2>
            <?php else : ?>
                <h2>Cập nhật danh sách địa chỉ chi nhánh, phòng giao dịch của các ngân hàng trên toàn quốc, giúp bạn tiết kiệm tối đa thời gian di chuyển.</h2>
            <?php endif; ?>
            <h3 style="display: none;">Đăng nhập</h3>
            <h3 style="display: none;">Xác thực mã OTP</h3>
            <h3 style="display: none;">Xác thực mã OTP</h3>
            <h4 style="display: none;">Tìm đường ngắn nhất</h4>
            <h4 style="display: none;">Chào buổi sáng, chào mừng bạn quay lại :)</h4>
            <h4 style="display: none;"></h4>
            <h4 style="display: none;">Modal title</h4>
        </div>
        <div class="filter_hr">
            <hr>
        </div>
        <div class="filter_select">
            <div class="row">
                <div class="col_style col-12 col-sm-6 col-lg-3">
                    <div class="company_insurance">
                        <i class="icon_company"></i>
                        <select name="company" class="select_company chosen_js" id="company">
                            <option value="">Chọn ngân hàng</option>
                            <?php foreach ($all_company as $item) : ?>
                                <option value="<?= $item['id'] ?>" <?php if (isset($_GET['company'])) {
                                                                        if ($item['id'] == $_GET['company']) {
                                                                            echo "selected";
                                                                        }
                                                                    } ?>><?= $item['short_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col_style col-12 col-sm-6 col-lg-3">
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
                <div class="col_style col-12 col-sm-6 col-lg-3">
                    <div class="district">
                        <i class="icon_district"></i>
                        <select name="district" class="select_district chosen_js" id="district">
                            <option value="">Quận/Huyện</option>
                            <?php if (isset($_GET['province'])) : ?>
                                <?php foreach ($arr_district as $item) : ?>
                                    <option value="<?= $item['id'] ?>" <?php if (isset($_GET['district'])) {
                                                                            if ($item['id'] == $_GET['district']) {
                                                                                echo "selected";
                                                                            }
                                                                        } ?>><?= $item['district_name'] ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col_style col-12 col-sm-6 col-lg-3">
                    <div class="button_submit">
                        <button class="btn_submit" id="btn_submit">
                            <i></i>
                            <span class="span_button">Tìm kiếm</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="list">
        <div class="row content_row">
            <div class="left_content <?php if (empty($_GET['district'])) echo "col-12 col-lg-8" ?>" style="padding-left: 15px;padding-right: 15px;width: 100%;">
                <?php if (!empty($_GET['company']) & empty($_GET['province'])) : ?>
                    <div id="template_data_province">
                        <div class="title_province">CHI NHÁNH, PHÒNG GIAO DỊCH <?= mb_strtoupper($array_company[$_GET['company']], 'UTF-8') ?> CÁC TỈNH THÀNH</div>
                        <?php if ($count_company >= 4) : ?>
                            <h4>Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có mạng lưới Chi nhánh/Phòng giao dịch rộng khắp trên cả nước. Hiện nay, Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có tổng cộng hơn <?= $total_bank ?> Chi nhánh/PGD đặt tại <?= $count_company ?> tỉnh, thành phố trong cả nước. Trong đó nhiều nhất phải kể đến <?= $data_province[0]['province_name'] ?> - <?= $data_province[0]['count'] ?> Chi nhánh/PGD, <?= $data_province[1]['province_name'] ?> - <?= $data_province[1]['count'] ?> Chi nhánh/PGD, <?= $data_province[2]['province_name'] ?> - <?= $data_province[2]['count'] ?> Chi nhánh/PGD, ... và nhiều tỉnh, thành phố khác.</h4>
                        <?php elseif ($count_company == 3) : ?>
                            <h4>Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có mạng lưới Chi nhánh/Phòng giao dịch rộng khắp trên cả nước. Hiện nay, Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có tổng cộng hơn <?= $total_bank ?> Chi nhánh/PGD đặt tại <?= $count_company ?> tỉnh, thành phố trong cả nước. Trong đó nhiều nhất phải kể đến <?= $data_province[0]['province_name'] ?> - <?= $data_province[0]['count'] ?> Chi nhánh/PGD, <?= $data_province[1]['province_name'] ?> - <?= $data_province[1]['count'] ?> Chi nhánh/PGD, <?= $data_province[2]['province_name'] ?> - <?= $data_province[2]['count'] ?> Chi nhánh/PGD.</h4>
                        <?php elseif ($count_company == 2) : ?>
                            <h4>Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có mạng lưới Chi nhánh/Phòng giao dịch rộng khắp trên cả nước. Hiện nay, Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có tổng cộng hơn <?= $total_bank ?> Chi nhánh/PGD đặt tại <?= $count_company ?> tỉnh, thành phố trong cả nước. Trong đó nhiều nhất phải kể đến <?= $data_province[0]['province_name'] ?> - <?= $data_province[0]['count'] ?> Chi nhánh/PGD, <?= $data_province[1]['province_name'] ?> - <?= $data_province[1]['count'] ?> Chi nhánh/PGD.</h4>
                        <?php elseif ($count_company == 1) : ?>
                            <h4>Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có mạng lưới Chi nhánh/Phòng giao dịch rộng khắp trên cả nước. Hiện nay, Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có tổng cộng hơn <?= $total_bank ?> Chi nhánh/PGD đặt tại <?= $count_company ?> tỉnh, thành phố trong cả nước. Trong đó nhiều nhất phải kể đến <?= $data_province[0]['province_name'] ?> - <?= $data_province[0]['count'] ?> Chi nhánh/PGD.</h4>
                        <?php else : ?>
                        <?php endif; ?>
                        <div class="province_hr">
                            <hr>
                        </div>
                        <div class="col_province">
                            <div id="template_data_company">
                                <?php foreach ($data_province as $item) : ?>
                                    <div class="col_province_style col-6 col-sm-3">
                                        <a href="<?= $item['url'] ?>" target="_blank"><?= $item['province_name'] ?> (<?= $item['count'] ?>)</a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php if ($count_company > 20) : ?>
                            <div class="see_more_company">
                                <button class="btn_see_more_company">
                                    <span class="span_see_more">Xem thêm</span>
                                    <i class="icon_see_more"></i>
                                </button>
                            </div>
                            <div class="hide_company hidden">
                                <button class="btn_hide_company">
                                    <span class="span_hide">Ẩn bớt</span>
                                    <i class="icon_hide"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php elseif (!empty($_GET['company']) & !empty($_GET['province']) & empty($_GET['district'])) : ?>
                    <div id="template_data_district">
                        <div class="title_province">CHI NHÁNH, PHÒNG GIAO DỊCH <?= mb_strtoupper($array_company[$_GET['company']], 'UTF-8') ?> TẠI <?= mb_strtoupper($array_province[$_GET['province']], 'UTF-8') ?></div>
                        <?php if ($count_province >= 4) : ?>
                            <h4>Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có mạng lưới Chi nhánh/Phòng giao dịch rộng khắp trên cả nước. Hiện nay, Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có tổng cộng hơn <?= $total_bank_by_company_province ?> Chi nhánh/PGD đặt tại <?= $array_province[$_GET['province']] ?>. Trong đó nhiều nhất phải kể đến <?= $data_district[0]['district_name'] ?> - <?= $data_district[0]['count'] ?> Chi nhánh/PGD, <?= $data_district[1]['district_name'] ?> - <?= $data_district[1]['count'] ?> Chi nhánh/PGD, <?= $data_district[2]['district_name'] ?> - <?= $data_district[2]['count'] ?> Chi nhánh/PGD, ... và nhiều quận, huyện khác.</h4>
                        <?php elseif ($count_province == 3) : ?>
                            <h4>Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có mạng lưới Chi nhánh/Phòng giao dịch rộng khắp trên cả nước. Hiện nay, Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có tổng cộng hơn <?= $total_bank_by_company_province ?> Chi nhánh/PGD đặt tại <?= $array_province[$_GET['province']] ?>. Trong đó nhiều nhất phải kể đến <?= $data_district[0]['district_name'] ?> - <?= $data_district[0]['count'] ?> Chi nhánh/PGD, <?= $data_district[1]['district_name'] ?> - <?= $data_district[1]['count'] ?> Chi nhánh/PGD, <?= $data_district[2]['district_name'] ?> - <?= $data_district[2]['count'] ?> Chi nhánh/PGD.</h4>
                        <?php elseif ($count_province == 2) : ?>
                            <h4>Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có mạng lưới Chi nhánh/Phòng giao dịch rộng khắp trên cả nước. Hiện nay, Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có tổng cộng hơn <?= $total_bank_by_company_province ?> Chi nhánh/PGD đặt tại <?= $array_province[$_GET['province']] ?>. Trong đó nhiều nhất phải kể đến <?= $data_district[0]['district_name'] ?> - <?= $data_district[0]['count'] ?> Chi nhánh/PGD, <?= $data_district[1]['district_name'] ?> - <?= $data_district[1]['count'] ?> Chi nhánh/PGD.</h4>
                        <?php elseif ($count_province == 1) : ?>
                            <h4>Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có mạng lưới Chi nhánh/Phòng giao dịch rộng khắp trên cả nước. Hiện nay, Ngân hàng <?= $array_company_long_name[$_GET['company']] ?> có tổng cộng hơn <?= $total_bank_by_company_province ?> Chi nhánh/PGD đặt tại <?= $array_province[$_GET['province']] ?>. Trong đó nhiều nhất phải kể đến <?= $data_district[0]['district_name'] ?> - <?= $data_district[0]['count'] ?> Chi nhánh/PGD.</h4>
                        <?php else : ?>
                        <?php endif; ?>
                        <div class="province_hr">
                            <hr>
                        </div>
                        <div class="col_province">
                            <div id="template_data_province_content">
                                <?php foreach ($data_district as $item) : ?>
                                    <div class="col_province_style col-6 col-sm-3">
                                        <a href="<?= $item['url'] ?>" target="_blank"><?= $item['district_name'] ?> (<?= $item['count'] ?>)</a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php if ($count_province > 20) : ?>
                            <div class="see_more_province">
                                <button class="btn_see_more_province">
                                    <span class="span_see_more">Xem thêm</span>
                                    <i class="icon_see_more"></i>
                                </button>
                            </div>
                            <div class="hide_province hidden">
                                <button class="btn_hide_province">
                                    <span class="span_hide">Ẩn bớt</span>
                                    <i class="icon_hide"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php elseif (!empty($_GET['company']) & !empty($_GET['province']) & !empty($_GET['district'])) : ?>
                    <div class="list_atm" <?php if ($count_record == 1) echo "style='padding-bottom:80px;'";
                                            elseif ($count_record == 2) echo "style='padding-bottom:20px;'"; ?>>
                        <table class="table">
                            <thead class="list_atm_thead">
                                <tr class="roboto">
                                    <th>#</th>
                                    <th>Chi nhánh/Phòng giao dịch</th>
                                    <th>Địa chỉ</th>
                                    <th>Điện thoại</th>
                                    <th>Fax</th>
                                    <th class="arrow_box">Chỉ đường</th>
                                </tr>
                            </thead>
                            <tbody class="content_branch roboto-light">
                                <?php foreach ($data_companies as $item) : ?>
                                    <tr>
                                        <td>
                                            <?= $item['so_thu_tu'] ?>
                                        </td>
                                        <td>
                                            <?= $item['branch_name'] ?>
                                            <p class="text_mobile">
                                                Đ/C: <?= $item['address'] ?><br>
                                                Tel: <?= $item['phone'] ?><br>
                                                Fax: <?= $item['fax'] ?>
                                            </p>
                                        </td>
                                        <td>
                                            <?= $item['address'] ?>
                                        </td>
                                        <td>
                                            <?= $item['phone'] ?>
                                        </td>
                                        <td>
                                            <?= $item['fax'] ?>
                                        </td>
                                        <td>
                                            <a href="<?= $item['url_map'] ?>" rel="nofollow" target="_blank">
                                                <img style="width:35px" src="/stores/images/insurance/icon-map.png" alt="map">
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($count_record == 0) : ?>
                        <div class="div_not_found">Không tìm thấy chi nhánh nào tại địa chỉ đã chọn</div>
                    <?php endif; ?>
                <?php else : ?>
                    <div id="template_data_insurance">
                        <?php foreach ($data_bank as $item) : ?>
                            <div class="left_content_detail">
                                <a href="<?= $item['url'] ?>" target="_blank"><?= $item['long_name'] ?></a>
                                <div class="div_position">
                                    <i class="left_content_position"></i>
                                    <p><?= $item['address'] ?></p>
                                </div>
                                <div class="div_phone">
                                    <i class="left_content_phone"></i>
                                    <p><?= $item['phone'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="see_more">
                        <button class="btn_see_more">
                            <span class="span_see_more">Xem thêm</span>
                            <i class="icon_see_more"></i>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($_GET['company']) & !empty($_GET['province']) & !empty($_GET['district'])) : ?>
            <?php else : ?>
                <div class="right_content col-12 col-lg-4">
                    <div class="right_btn">
                        <div class="btn_1">
                            <p>Có thể bạn quan tâm</p>
                        </div>
                        <?php if (!empty($_GET['company']) & empty($_GET['province'])) : ?>
                            <a href="https://thebank.vn/ngan-hang-<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= $_GET['company'] ?>.html" class="btn_2" target="_blank">Thông tin ngân hàng <?= $array_company[$_GET['company']] ?></a>
                            <a href="https://thebank.vn/gui-tiet-kiem/gui-tiet-kiem-ngan-hang-<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= isset($array_gtk[$_GET['company']]) ? $array_gtk[$_GET['company']] : '' ?>.html" class="btn_3" target="_blank">Lãi suất ngân hàng <?= $array_company[$_GET['company']] ?></a>
                            <a href="https://thebank.vn/cong-cu/tinh-ty-gia-ngoai-te/ty-gia-<?= $array_slug_company[$_GET['company']] ?>.html" class="btn_4" target="_blank">Tỷ giá ngân hàng <?= $array_company[$_GET['company']] ?></a>
                            <a href="../tim-atm/<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= $_GET['company'] ?>.html" class="btn_5" target="_blank">Cây ATM <?= $array_company[$_GET['company']] ?> gần nhất</a>
                        <?php elseif (!empty($_GET['company']) & !empty($_GET['province'])) : ?>
                            <a href="https://thebank.vn/ngan-hang-<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= $_GET['company'] ?>.html" class="btn_2" target="_blank">Thông tin ngân hàng <?= $array_company[$_GET['company']] ?></a>
                            <a href="https://thebank.vn/gui-tiet-kiem/gui-tiet-kiem-ngan-hang-<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= isset($array_gtk[$_GET['company']]) ? $array_gtk[$_GET['company']] : '' ?>.html" class="btn_3" target="_blank">Lãi suất ngân hàng <?= $array_company[$_GET['company']] ?></a>
                            <a href="https://thebank.vn/cong-cu/tinh-ty-gia-ngoai-te/ty-gia-<?= $array_slug_company[$_GET['company']] ?>.html" class="btn_4" target="_blank">Tỷ giá ngân hàng <?= $array_company[$_GET['company']] ?></a>
                            <a href="../tim-atm/<?= $this->context->actionSlug($array_company[$_GET['company']]) ?>-<?= $this->context->actionSlug($array_province[$_GET['province']]) ?>-<?= $_GET['company'] ?>-<?= $_GET['province'] ?>.html" class="btn_5" target="_blank">Cây ATM <?= $array_company[$_GET['company']] ?> gần nhất</a>
                        <?php else : ?>
                            <a href="../danh-ba-ngan-hang.html" class="btn_2" target="_blank">Thông tin ngân hàng</a>
                            <a href="https://thebank.vn/gui-tiet-kiem.html" class="btn_3" target="_blank">Lãi suất ngân hàng</a>
                            <a href="https://thebank.vn/cong-cu/tinh-ty-gia-ngoai-te.html" class="btn_4" target="_blank">Tỷ giá ngân hàng</a>
                            <a href="tim-atm.html" class="btn_5" target="_blank">Cây ATM</a>
                        <?php endif; ?>
                        <div class="banner">
                            <a href="https://thebank.vn/quyen-loi-tham-gia-bao-hiem-nhan-tho.html" target="_blank">
                                <img src="/stores/images/insurance/banner-congcu.gif" width="100%" alt="cong-cu">
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if (!empty($_GET['company']) & empty($_GET['province'])) : ?>
        <div class="row maybe_yk_row">
            <div class="maybe_yk_col col-12 col-lg-8">
                <div class="maybe_yk">
                    <div class="maybe_yk_head">
                        <i class="icon_maybe_yk"></i>
                        <p>có thể bạn cần tìm</p>
                    </div>
                    <div class="list_maybe_yk">
                        <?php foreach ($arr_most_view_company as $item) : ?>
                            <?php if ($item['id'] == $_GET['company']) : ?>
                            <?php else : ?>
                                <a href="/cong-cu/tim-chi-nhanh-ngan-hang/<?= $this->context->actionSlug($array_company[$item['id']]) ?>-<?= $item['id'] ?>.html" target="_blank">Chi nhánh <?= $item['short_name'] ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="maybe_yk_col col-12 col-lg-4"></div>
        </div>
    <?php endif; ?>
</div>

<script id="template_data_insurance_ex" type="x-tmpl-mustache">
    <div class="left_content_detail">
        <a href={{url}} target="_blank">{{long_name}}</a>
        <div class="div_position">
            <i class="left_content_position"></i>
            <p>{{address}}</p>
        </div>
        <div class="div_phone">
            <i class="left_content_phone"></i>
            <p>{{phone}}</p>
        </div>
    </div>
</script>

<script id="template_data_company_ex" type="x-tmpl-mustache">
    <div class="col_province_style col-6 col-sm-3">
        <a href={{url}} target="_blank">{{province_name}} ({{count}})</a>
    </div>
</script>

<script id="template_data_province_ex" type="x-tmpl-mustache">
    <div class="col_province_style col-6 col-sm-3">
        <a href={{url}} target="_blank">{{district_name}} ({{count}})</a>
    </div>
</script>

<script id="template_province_group_by_ex" type="x-tmpl-mustache">
    <div class="col-6 col-sm-3">
        <a>{{province_name}} ({{count}})</a>
    </div>
</script>