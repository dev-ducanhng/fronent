<link rel="stylesheet" href="/stores/css/consultant.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

<script src="/stores/js/jquery.min.js"></script>
<script src="/stores/js/mustache.min.js"></script>
<script src="/stores/js/chosen.jquery.js"></script>
<script src="/stores/js/buyer/buyer.js"></script>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        // $('#province').change(function() {
        //     var province_id = $(this).val();
        //     $.ajax({
        //         url: '/consultant/get-district',
        //         data: {
        //             province_id: province_id
        //         },
        //         type: 'POST',
        //         success: function(res) {
        //             var jsonData = JSON.parse(res);

        //             var option = '<option value="">Chọn Quận/Huyện</option>';
        //             $.each(jsonData, function(key, val) {
        //                 option += '<option value="' + key + '">' + val + '</option>'
        //             });
        //             $('#district').html(option).trigger('chosen:updated');
        //         }
        //     });
        // });

        $('#button_plus').click(function() {
            $('.btn_respon').removeClass('responsive_md_hidden');
            $('.btn_respon').addClass('responsive_md_block');

            $('.plus').removeClass('button_responsive_block');
            $('.plus').addClass('button_responsive_hidden');

            $('.minus').removeClass('button_responsive_hidden');
            $('.minus').addClass('button_responsive_block');
        });

        $('#button_minus').click(function() {
            $('.btn_respon').removeClass('responsive_md_block');
            $('.btn_respon').addClass('responsive_md_hidden');

            $('.minus').removeClass('button_responsive_block');
            $('.minus').addClass('button_responsive_hidden');

            $('.plus').removeClass('button_responsive_hidden');
            $('.plus').addClass('button_responsive_block');
        });

        $('body').on('click','.icon_heart',function() {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active')
            } else {
                $(this).addClass('active');
            }
        });

        $(".chosen_js").chosen({
            width: '100%'
        });
    });
</script>

<div class="container">
    <div class="breadcrumbs">
        <a href="https://thebank.vn">Trang chủ</a>
        <i></i>
        <span>Chuyên gia tư vấn</span>
    </div>
    <div class="title">
        <h1 class="title_consultant"><?= $title ?></h1>
        <div class="title_description">Sử dụng bộ lọc để tìm kiếm tư vấn nhanh chóng</div>
    </div>
    <div class="filter">
        <div class="row">
            <div class="col_style col-12 col-sm-6 col-lg-4">
                <div class="div_service">
                    <i class="icon_service"></i>
                    <select class="rows_service chosen_js" name="service" id="service">
                        <option value="">Chọn dịch vụ</option>
                        <?php 
                            foreach($list_service as $item) : 
                                if(isset($data_supplier['selectedOptionsService'][$item['id']]))
                                    $active = 'selected';
                                else 
                                    $active = '';
                            ?>
                                <option <?= $active ?> value="<?= $item['id'] ?>"><?= $item['service_name'] ?></option>
                            <?php endforeach; ?>
                    </select>                    
                </div>
            </div>
            <div class="col_style col-12 col-sm-6 col-lg-4">
                <div class="div_company">
                    <i class="icon_company"></i>
                    <select name="" class="rows_company chosen_js" id="company">
                        <option value="">Chọn tổ chức</option>
                        <?php 
                            foreach ($list_company as $item) : 
                                if(isset($data_supplier['selectedOptionsCompany'][$item['id']]))
                                    $active = 'selected';
                                else 
                                    $active = '';
                            ?>
                            <option <?= $active ?> value="<?= $item['id'] ?>"><?= $item['short_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col_style col-12 col-sm-6 col-lg-4">
                <div class="div_province">
                    <i class="icon_province"></i>
                    <select name="" class="rows_province chosen_js" id="province">
                        <option value="">Chọn Tỉnh/Thành phố</option>
                        <?php 
                            foreach ($list_province as $item) : 
                                if(isset($data_supplier['selectedOptionsProvince'][$item['id']]))
                            $active = 'selected';
                                else 
                                $active = '';                            
                            ?>
                            <option <?= $active ?> value="<?= $item['id'] ?>"><?= $item['province_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col_style col-12 col-sm-6 col-lg-4">
                <div class="div_district">
                    <i class="icon_district"></i>
                    <select name="" class="rows_district chosen_js" id="district">
                        <option value="">Chọn Quận/Huyện</option>
                    </select>
                </div>
            </div>
            <div class="col_style btn_respon responsive_md_hidden col-12 col-sm-6 col-lg-4">
                <div class="div_name">
                    <i class="icon_name"></i>
                    <select name="" class="rows_name chosen_js" id="type">
                        <option value="1">Chuyên viên tư vấn</option>
                        <option value="2">Tổ chức tài chính</option>
                    </select>
                </div>
            </div>
            <div class="col_style btn_respon responsive_md_hidden col-12 col-sm-6 col-lg-4">
                <div class="div_year_experience">
                    <i class="icon_year_experience"></i>
                    <select name="" class="rows_year_experience chosen_js" id="year_experience">
                        <option value="">Kinh nghiệm</option>
                        <option value="0;1">Dưới 1 năm</option>
                        <option value="1;3">Từ 1 đến 3 năm</option>
                        <option value="3;5">Từ 3 đến 5 năm</option>
                        <option value="5;99">Trên 5 năm</option>
                    </select>
                </div>
            </div>
            <div class="col_style btn_respon responsive_md_hidden col-12 col-sm-6 col-lg-4">
                <div class="div_level">
                    <i class="icon_level"></i>
                    <select name="" class="rows_level chosen_js" id="level">
                        <option value="">Chọn hạng tư vấn</option>
                        <option value="1">Tư vấn viên</option>
                        <option value="2">Chuyên viên</option>
                        <option value="3">Chuyên gia</option>
                    </select>
                </div>
            </div>
            <div class="col_style btn_respon responsive_md_hidden col-12 col-sm-6 col-lg-4">
                <div class="div_status">
                    <i class="icon_status"></i>
                    <select name="" class="rows_status chosen_js" id="status">
                        <option value="">Tư vấn đang Online?</option>
                        <option value="1">Online</option>
                        <option value="0">Offline</option>
                    </select>
                </div>
            </div>
            <div class="col_style col-12 col-sm-6 col-lg-4">
                <div class="div_search_name">
                    <i class="icon_search_name"></i>
                    <input type="text" class="search_name" id="input_search" placeholder="Tìm theo tên">
                    <button type="button" class="button_search_name">
                        <i></i>
                        <span class="span_button">Tìm kiếm</span>
                    </button>
                </div>
            </div>
            <div class="col_style button_responsive">
                <div class="plus button_responsive_block">
                    <button class="button_plus" id="button_plus">Nâng cao</button>
                    <i class="icon-plus"></i>
                </div>
                <div class="minus button_responsive_hidden">
                    <button class="button_minus" id="button_minus">Thu gọn</button>
                    <i class="icon-minus"></i>
                </div>

            </div>
        </div>
    </div>
    <div class="sort">
        <div class="description_sort">
            <i class="tutorial_sort"></i>
            <p>Danh sách chuyên gia tư vấn trên TheBank có thể tư vấn cho bạn</p>
        </div>
        <div class="hr_sort">
            <hr>
        </div>
        <div class="div_sort">
            <i class="icon_sort"></i>
            <span class="select_sort" id="select_sort">Tốt nhất</span>
            <i class="icon_arrow"></i>
            <ul class="sort_data ul_dropdown dropdown_hidden">
                <li id="top_sp" class="li_btn li_selected">Tốt nhất</li>
                <li id="rated" class="li_btn">Đánh giá cao</li>
                <li id="exp" class="li_btn">Nhiều kinh nghiệm</li>
                <li id="news" class="li_btn">Mới nhất</li>
            </ul>
        </div>        
    </div>
    <div class="list">
        <?php foreach($data_supplier['results_ob'] as $item) : ?>
            <div class="rows_supplier">
                <div class="row">
                    <div class="col-12 col-md-3 col-left">
                        <div>
                            <a href="<?= $item['url_profile'] ?>" target="_blank" class="avatar">
                                <img src="<?= $item['avatar'] ?>" class="avatar_supplier" alt="<?= $item['display_name'] ?>">
                                <i class="status_chat <?php echo(($item['status_online'] == 1) ? 'active' : '')?>"></i>
                            </a>
                        </div>
                        <div>
                            <div class="name_supplier">
                                <a href="<?= $item['url_profile'] ?>" target="_blank" class="detail_name"><?= $item['display_name'] ?></a>
                                <i class="verify_tick"></i>
                            </div>
                            <div class="review_supplier">
                                <?php  
                                        $html_star 	= $this->context->generateStarSupplier($item['level_rank_star'], $item['level_name']);
                                ?>
                                <div class="star_supplier">
                                    <?= $html_star ?>
                                </div>
                                <div class="comment_supplier">
                                    <a href="<?= $item['url_profile_cm'] ?>" target="_blank" class="cmt_supplier">
                                        <i class="icon_comment"></i>
                                        <p class="total_comment"><?= $item['count_comment'] ?></p>
                                    </a>
                                </div>
                            </div>
                            <p class="type_supplier"><?= $item['level_name'] ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col_info">
                        <img src="../stores/images/consultant/example-company.png" class="info_company_mobile" width="81px" height="41px" alt="company">
                        <div class="info_company_pc">
                            <div class="rows_info">
                                <span class="info_label">Tổ chức: </span>
                                <span class="info_value"><?= $item['company_name'] ?></span>
                            </div>
                            <div class="rows_info">
                                <span class="info_label">Dịch vụ tư vấn: </span>
                                <span class="info_value"><?= $item['service_name'] ?></span>
                            </div>
                            <div class="rows_info">
                                <span class="info_label">Kinh nghiệm: </span>
                                <span class="info_value"><?= $item['year_experience'] ?> Năm</span>
                            </div>
                            <div class="rows_info">
                                <span class="info_label">Vị trí: </span>
                                <span class="info_value"><?= $item['working_position'] ?></span>
                            </div>
                            <div class="rows_info">
                                <span class="info_label">Ngày mở tài khoản: </span>
                                <span class="info_value"><?= $item['user_registered'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row_hr">
                        <hr>
                    </div>
                    <div class="col-12 col-md-4 col_button">
                        <div class="button_supplier">
                            <div class="button_up">
                                <button class="button_chat">
                                    <a class="text-white" href="<?= $item['chat'] ?>">Chat ngay</a>
                                </button>
                                <i class="icon_heart" dtid="<?= $item['id'] ?>" id=""></i>
                            </div>
                            <div class="button_down">
                                <button class="button_advise" dtname="<?= $item['display_name'] ?>" dtid="<?= $item['id'] ?>">Tư vấn miễn phí</button>
                                <div class="total_view">
                                    <p class="p_view"><?= $item['viewed'] ?> lượt xem</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>     
    </div>
    <?php 
        if(!empty($data_supplier['result_data_ofset']))
            $set_see_more = 'display: block;';
        else    
            $set_see_more = 'display: none;';
    ?>
    <div class="see_more_page" style="<?= $set_see_more ?>">
        <span class="see_more_button">Xem thêm <img src="/stores/images/icon/arrow-bot.png" alt="arrow-bot"> </span>
    </div>    
</div>
<div class="modal">
    <div class="total_modal">
        <div class="modal_header">
            <div class="header_left">
                <i class="icon_modal_header"></i>
                <p>Tư vấn miễn phí</p>
            </div>
            <div class="header_right">
                <span class="close">
                    <i class="icon_close"></i>
                </span>
            </div>
        </div>
        <div class="modal_content">
            <p class="content_opening">Gửi email đến chuyên gia tư vấn <strong>Nguyễn Gia Thế</strong></p>
            <p class="content_opening_2">Chào bạn, TheBank rất vui khi kết nối bạn với khách hàng. Ngay sau khi yêu cầu của bạn được gửi đi, TheBank sẽ kết nối & phản hồi cho bạn sớm nhất.</p>
            <p class="content_request">Nội dung yêu cầu <span>*</span></p>
            <div>
                <textarea name="" id="" class="content_textarea" rows="5"></textarea>
                <span class="error_content"></span>
            </div>
            <div>
                <input type="checkbox" class="content_checkbox">
                <span class="checkbox_span">Tôi đã đọc, hiểu và đồng ý về <a href="https://thebank.vn/tro-giup/chinh-sach-bao-mat.html">chính sách bảo mật </a> , <a href="https://thebank.vn/tro-giup/quy-che-hoat-dong.html">quy chế hoạt động</a> của công ty.</span>
            </div>
            <span class="error_checkbox"></span>
            <button type="button" class="content_button" id="content_button">
                <i class="icon_content_button"></i>
                <p class="content_make_request">Gửi yêu cầu tư vấn</p>
            </button>
            <p class="content_note">Tư vấn sẽ nhận được email của bạn ngay lập tức.</p>
        </div>
    </div>
</div>
<div class="alert alert-success">
    <strong> Gửi yêu cầu tư vấn thành công! </strong>
  </div>
<div class="loading_data">
    <img src="/stores/images/icon/loading.gif" alt="loading">
</div>
<style>
    .alert-success{
        position: fixed;
        top: 140px;
        right: 50px;
        z-index: 11111;
        display: none;
    }
</style>
<script id="template_supplier" type="x-tmpl-mustache">
    <div class="rows_supplier">
        <div class="row">
            <div class="col-12 col-md-3 col-left">
                <div>
                    <a href="{{url_profile}}" target="_blank" class="avatar">
                        <img src="{{avatar}}" class="avatar_supplier" alt="{{display_name}}">
                        <i class="status_chat {{status_online}}"></i>
                    </a>
                </div>
                <div>
                    <div class="name_supplier">
                        <a href="{{url_profile}}" target="_blank" class="detail_name">{{display_name}}</a>
                        <i class="verify_tick"></i>
                    </div>
                    <div class="review_supplier">
                        <div class="star_supplier">
                            {{{html_star}}}
                        </div>
                        <div class="comment_supplier">
                            <a href="{{url_profile_cm}}" target="_blank" class="cmt_supplier">
                                <i class="icon_comment"></i>
                                <p class="total_comment">{{count_comment}}</p>
                            </a>
                        </div>
                    </div>
                    <p class="type_supplier">{{level_name}}</p>
                </div>
            </div>
            <div class="col-12 col-md-5 col_info">
                <img src="../stores/images/consultant/example-company.png" class="info_company_mobile" width="81px" height="41px" alt="company">
                <div class="info_company_pc">
                    <div class="rows_info">
                        <span class="info_label">Tổ chức: </span>
                        <span class="info_value">{{company_name}}</span>
                    </div>
                    <div class="rows_info">
                        <span class="info_label">Dịch vụ tư vấn: </span>
                        <span class="info_value">{{service_name}}</span>
                    </div>
                    <div class="rows_info">
                        <span class="info_label">Kinh nghiệm: </span>
                        <span class="info_value">{{year_experience}} Năm</span>
                    </div>
                    <div class="rows_info">
                        <span class="info_label">Vị trí: </span>
                        <span class="info_value">{{working_position}}</span>
                    </div>
                    <div class="rows_info">
                        <span class="info_label">Ngày mở tài khoản: </span>
                        <span class="info_value">{{user_registered}}</span>
                    </div>
                </div>
            </div>
            <div class="row_hr">
                <hr>
            </div>
            <div class="col-12 col-md-4 col_button">
                <div class="button_supplier">
                    <div class="button_up">
                        <button class="button_chat">
                            <a class="text-white" href="{{chat}}">Chat ngay</a>
                        </button>
                        <i class="icon_heart" dtid="{{id}}" id=""></i>
                    </div>
                    <div class="button_down">
                        <button class="button_advise" dtname="{{display_name}}" dtid="{{id}}">Tư vấn miễn phí</button>
                        <div class="total_view">
                            <p class="p_view">{{viewed}} lượt xem</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</script>