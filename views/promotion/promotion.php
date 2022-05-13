<!-- <script type='text/javascript' src='/themes/pcmembership/js/perfect-scrollbar.jquery.js'></script> -->

<!-- <script src="/stores/js/jquery.min.js"></script> -->
<link rel="stylesheet" href="/stores/css/promotion/promotion.css" type="text/css">
<link rel="stylesheet" href="/stores/css/promotion/u-i.css" type="text/css">
<link rel="stylesheet" href="/stores/css/promotion/multiselect.filter.css" type="text/css">
<link rel="stylesheet" href="/stores/css/chosen.css">

<script src="/stores/js/chosen.jquery.js"></script>
<script src="/stores/js/promotion/jquery-ui.js"></script>
<script src="/stores/js/promotion/jquery.multiselect.filter.js"></script>
<script src="/stores/js/promotion/jquery.multiselect.js"></script>

<script src="/stores/js/mustache.min.js"></script>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        $(".chosen_js").chosen({
            width: '100%'
        });
    });
</script>

<div class="container">
    <div class="breadcrumbs" id="breadcrumbs_promotion">
        <a target="_blank" href="https://thebank.vn">Trang chủ</a>
        <i></i>
        <a target="_blank" href="https://thebank.vn/cong-cu.html">Công cụ</a>
        <i></i>
        <span>Điểm ưu đãi thẻ tín dụng</span>
    </div>
    <div class="breadcrumbs_line ">
        <p></p>
    </div>
    <div class="main_promotion">
        <div class="form_filter_promotion">
            <h2>Tìm kiếm ưu đãi</h2>
            <!-- <form action="" method=""> -->


            <div class="row">
                <div class="col_style2 col-12 col-sm-6 col-lg-4 ">
                    <div class="company_insurance">
                        <i class="icon_company"></i>
                        <select name="company" class="select_company chosen_js" id="company">
                            <option value="">Chọn ngân hàng</option>
                            <?php foreach ($all_company as $item) :  ?>
                                <option value="<?= $item['id'] ?>" <?php if (isset($_GET['company'])) {
                                                                        if ($item['id'] == $_GET['company']) {
                                                                            echo "selected";
                                                                        }
                                                                    } ?>><?= $item['short_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col_style2 col-12 col-sm-6 col-lg-4">
                    <div class="card">
                        <i class="icon_cardbank"></i>
                        <select name="card[]" multiple="multiple" class="select_card multiple_select sl_multiple multiple_credit" id="card">

                            <?php
                            if (!empty($sl_card)) :
                                if (isset($_GET['card'])) {
                                    $arr_card = $_GET['card'];
                                } else {
                                    $arr_card = [];
                                }
                                foreach ($sl_card as $val) :
                                    $selected = '';
                                    if (in_array($val['id'], $arr_card)) {
                                        $selected = 'selected';
                                    }

                            ?>
                                    <option <?= $selected ?> value="<?= $val['id'] ?>"><?= $val['short_name'] ?></option>
                            <?php
                                endforeach;
                            endif;
                            ?>
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
                <div class="col_style2 col-6 col-sm-6 col-lg-4" id="btn_btn_btn">
                    <div class="button_submit">
                        <button type="submit" class="btn_submit" id="btn_submit">
                            <i></i>
                            <span class="span_button">Tìm kiếm</span>
                        </button>
                    </div>

                </div>
                <div class="btn_refresh_filter col_style col-6 col-sm-6 col-lg-4">
                    <span class="refresh_filter"><i class="icon-refresh_filter"></i>Chọn lại</span>
                </div>
            </div>
            <!-- </form> -->
        </div>
        <div class="content_promotion">
            <div class="content_header ">
                <h2>Dịch vụ ưu đãi</h2>
                <div class="row" style=" border-bottom: 1px solid #C4C4C4;">

                    <?php foreach ($arr_ser as $item) : ?>
                        <div class="endow_a col_style col-lg-3">
                            <i class="icon_for "></i><a target="_blank" href="<?= $item['url'] ?>"><?= $item['title'] ?> (<?= $item['count'] ?>)</a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="nav_endov">
                    <div class="w_list_endov">
                        <p>
                            <span>Các ưu đãi mới <span class="hiden_540">|</span> </span>
                            Tìm thấy <?= $count ?> điểm ưu đãi
                        </p>
                    </div>



                </div>
                <div class="list_endov" id="list_endov">
                    <?php foreach ($arr_all_pro as $key => $item) : ?>
                        <div class="child_promotion mb-5">
                            <div>
                                <span class="sprite_membership">
                                    <?= $item['hsd'] ?>
                                </span>
                            </div>
                            <div class="min_height">
                                <a target="_blank" href="<?= $item['url_detail'] ?>"><img class="img_endov" src="<?= $item['img'] ?>" alt="anh"></a>
                            </div>
                            <div class="info_child_providers ">
                                <a target="_blank" href="<?= $item['url_detail'] ?>" class="promotion_name">
                                    <h3><?= $item['provider_name'] ?></h3>
                                </a>
                                <p class="star">
                                    <?php if ($item['point_rating'] == 1) : ?>
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                    <?php elseif ($item['point_rating'] == 2) : ?>
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                    <?php elseif ($item['point_rating'] == 3) : ?>
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                    <?php elseif ($item['point_rating'] == 4) : ?>
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                    <?php elseif ($item['point_rating'] == 5) : ?>
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                        <img src="/stores/images/promotion/saoden.png" alt="anh">
                                    <?php else : ?>
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                        <img src="/stores/images/promotion/sao.png" alt="anh">
                                    <?php endif; ?>
                                </p>
                                <p class="promotion_view">
                                    <?= $item['viewed'] ?> lượt xem
                                </p>
                                <p class="reduction">
                                    <span><?= $item['excerpt'] ?></span>
                                    <span>Thời gian: Từ
                                        <?= $item['start_date'] ?>
                                        ...</span>
                                </p>
                                <p class="for_car"> Dành cho thẻ
                                    <a target="_blank" href="<?= $item['url'] ?>"><?= $arr_company[$item['company_id']] ?></a>
                            </div>
                        </div>


                    <?php endforeach; ?>
                </div>
                <?php if ($max_click >= 1) : ?>
                    <div class="see_more">
                        <button class="btn_see_more">
                            <span class="span_see_more">Xem thêm</span>
                            <i class="icon_see_more"></i>
                        </button>
                    </div>
                <?php endif; ?>

            </div>
        </div>


    </div>
    <div class="tag">

        <ul>
            <i></i>

            <?php foreach ($arr_company_3 as $item) : ?>
                <li><a target="_blank" href="<?= $item['url'] ?>">Ưu đãi thẻ <?= $item['name'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div style="display: none;">
        <h1> Danh sách điểm ưu đãi cho chủ thẻ tín dụng của các ngân hàng trên toàn quốc</h1>
    </div>
</div>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        $('body').click(function(evt) {
            if (!$(evt.target).is('.select_sort')) {
                $('.ul_dropdown').removeClass('dropdown_block');
                $('.ul_dropdown').addClass('dropdown_hidden');
            }
        });
        $('.select_sort').click(function() {
            if ($('.ul_dropdown').hasClass('dropdown_hidden')) {
                $('.ul_dropdown').removeClass('dropdown_hidden');
                $('.ul_dropdown').addClass('dropdown_block');
            } else if ($('.ul_dropdown').hasClass('dropdown_block')) {
                $('.ul_dropdown').removeClass('dropdown_block');
                $('.ul_dropdown').addClass('dropdown_hidden');
            }
        });

        $("#card").multiselect({
            noneSelectedText: "<span class='select_card'>Chọn thẻ ngân hàng</span>",
            selectedText: "<span class='select_card'> Đã chọn # thẻ </span>"
        }).multiselectfilter();

        $('#company').change(function() {
            if ($(this).val() != '') {

                $.ajax({
                    type: 'POST',
                    url: "/promotion/card-by-company-id",
                    data: {
                        company_id: [$(this).val()]
                    },
                    success: function(res) {
                        var arr_card = $.parseJSON(res);
                        var str_option = '';
                        if (Object.keys(arr_card).length > 0) {
                            $.each(arr_card, function(key, value) {
                                if (value != '')
                                    str_option += '<option value="' + key + '">' + value + '</option>';
                            });
                        }

                        $('#card').html(str_option).multiselect('refresh').multiselectfilter();
                    }
                });

            } else
                $('#card').html('').multiselect('refresh').multiselectfilter();;
        });


        $('.refresh_filter').click(function() {
            $('#company').val('').trigger('chosen:updated');
            $('#province').val('').trigger('chosen:updated');
            $('#service').val('').trigger('chosen:updated');
            $('#card').val('').multiselect('refresh').multiselectfilter();


        });
        $('#btn_submit').on('click', function(e) {
            var error = false;
            var company = $('#company').val();
            var company_name = removeUnicode($('#company option:selected').html());
            var card = $('#card').val();
            // var card_name = removeUnicode($('#card option:selected').html());
            var province = $('#province').val();
            var province_name = removeUnicode($('#province option:selected').html());
            var service = $('#service').val();
            var service_name = removeUnicode($('#service option:selected').html());
            console.log(company_name);
            var URL = '';
            if (company != '') {

                URL = encodeURI("diem-uu-dai/ngan-hang/" + company_name + '-' + company) + '.html';
                if (service != '' || province != '') {
                    URL = encodeURI("diem-uu-dai/ngan-hang/" + company_name + '-' + company) + '.html?province=' + province + '&service=' + service;

                }
                if (card != '') {

                    var list_car = '';
                  
                    $.each(card, function(key, val) {
                        console.log(val);
                        list_car +=  '&card%5B%5D=' + val

                    });
                    URL = encodeURI("diem-uu-dai/ngan-hang/" + company_name + '-' + company) + '.html?province=' + province + list_car + '&service=' + service;
                }
            } else if (service != '' && company == '') {
                
                if(province!= ''){
                    URL = encodeURI("diem-uu-dai/dich-vu/" + service_name + '-' + service) + '.html?province='+province;
                }else{
                    URL = encodeURI("diem-uu-dai/dich-vu/" + service_name + '-' + service) + '.html';
                }
            } else if (company != '' && service != '') {

                URL = encodeURI("diem-uu-dai/ngan-hang/" + company_name + '-' + company) + '.html?province=' + province + '&service=' + service;

            } else if (province != '') {
                URL = encodeURI("cong-cu/diem-uu-dai.html?province=" + province + '&service=' + service);
            }  else if (company == '' && service == '' && province == '') {
                var x = window.location.hostname;
                URL = encodeURI("cong-cu/diem-uu-dai.html?province=" + province + '&service=' + service

                );

            }

            window.location.href = window.location.protocol + '/' + URL;
        });


        var count_click = 1;
        var max_click = <?= $max_click ?>;

        $('.btn_see_more').click(function() {
            var page_size = ++count_click * 12;

            var company = $('#company').val();
            var company_name = removeUnicode($('#company option:selected').html());

            var count_card = <?= $count_card ?>;
            var card = $('#card').val();
            var url_card = '';
            for (i = 0; i < count_card; i++) {
                url_card += '&card%5B%5D=' + card[i];
            }

            var province = $('#province').val();
            var province_name = removeUnicode($('#province option:selected').html());

            var service = $('#service').val();
            var service_name = removeUnicode($('#service option:selected').html());
            if (service != '' && card != '') {
                var URL = service_name + '-' + service + '.html?company=' + company + url_card + '&province=' + province + '&service=' + service;
            }
            if (service != '' && card == '') {
                var URL = service_name + '-' + service + '.html?company=' + company + '&province=' + province + '&service=' + service;
            }


            $.ajax({
                url: URL,
                data: {
                    page_size: page_size
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_promotion').html();
                    var rendered = '';
                    $.each(jsonData['arr_all_pro'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#list_endov").html(rendered);

                    if (count_click == (max_click + 1)) {
                        $('.see_more').hide();
                    }
                }
            });
        });
    });
</script>

<script id="template_promotion" type="x-tmpl-mustache">
    <div class="child_promotion mb-5">
        <div>
            <span class="sprite_membership">
               {{{hsd}}}
            </span>
        </div>
        <div>
            <a target="_blank" href="{{url_detail}}"><img class="img_endov" src={{img}} alt="anh"></a>
        </div>
        <div class="info_child_providers ">
            <a target="_blank" href="{{url_detail}}" class="promotion_name">
                <h3>{{provider_name}}</h3>
            </a>
            <p class="star">
                {{{star}}}
            </p>
            <p class="promotion_view">
                {{viewed}} lượt xem
            </p>
            <p class="reduction">
                <span>{{excerpt}}</span> <span>Thời gian: Từ {{start_date}} ...</span>
            </p>
            <p class="for_car"> Dành cho thẻ
                <a target="_blank"  href={{url}}>{{company_name}}</a>
        </div>
    </div>
</script>