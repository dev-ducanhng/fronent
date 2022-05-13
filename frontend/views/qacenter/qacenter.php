<link rel="stylesheet" href="/stores/css/qacenter.css" type="text/css" />

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>

<script language="JavaScript" type="text/javascript">
    document.addEventListener('invalid', (function() {
        return function(e) {
            e.preventDefault();
            document.getElementById("search-qa").focus();
        };
    })(), true);

    $(document).ready(function() {
        $(".chosen_js").chosen();

        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();

        $("#search-qa").keyup(function() {
            delay(function() {
                var keyword = $('#search-qa').val();
                var URL = encodeURI("/qacenter/qacenter?q=" + keyword.trim());
                $.ajax({
                    url: URL,
                    cache: false,
                    type: "GET",
                    success: function(response) {
                        if (response != '') {
                            var par_result = JSON.parse(response);
                            var html_result = '';
                            $.each(par_result, function(key, val) {
                                html_result += '<li>';
                                html_result += '<a href="' + val['url'] + '" target="_blank">' + val['label'];
                                html_result += '</a>';
                                html_result += '</li>';
                            });
                            $('#result_search_qa').html(html_result);
                            $('#result_search_qa').show();
                        } else {
                            $('#result_search_qa').hide();
                        }
                    }
                });
            }, 500);
        });

        $("#search-qa").focusout(function() {
            delay(function() {
                $('#result_search_qa').hide();
            }, 100);
        });

        $('#category_id_submit_chosen').on('click', function(e) {
            var category_id = $('#category_id_submit').val();
            if (category_id != '') {
                $('#category_id_submit_chosen').removeClass('border_error');
                $('#error_category_id').html('');
            }
        });

        $('body').on('focus', '#question', function() {
            $('#question').removeClass('border_error');
            $('#error_question').html('');
        });

        $('body').on('change', '#question', function() {
            var question = $('#question').val().trim();
            if (question != '' && question.length >= 10) {
                $('#question').removeClass('border_error');
                $('#error_question').html('');
            }
        });

        $('#button-submit').on('click', function(e) {
            var error = false;
            var category_id = $('#category_id_submit').val();
            if (category_id == '') {
                $('#category_id_submit_chosen').addClass('border_error');
                $('#error_category_id').html('Vui lòng chọn chủ đề!');
                error = true;
            } else {
                $('#category_id_submit_chosen').removeClass('border_error');
                $('#error_category_id').html('');
            }
            var question = $('#question').val().trim();
            if (question == '') {
                $('#question').addClass('border_error');
                $('#error_question').html('Vui lòng nhập nội dung câu hỏi!');
                error = true;
            } else if (question.length < 10) {
                $('#question').addClass('border_error');
                $('#error_question').html('Vui lòng nhập trên 10 ký tự');
                error = true;
            } else {
                $('#question').removeClass('border_error');
                $('#error_question').html('');
            }
            if (error == false) {
                $.ajax({
                    type: 'POST',
                    url: '/qacenter/qacenter',
                    data: {
                        category_id: category_id,
                        question: question
                    },
                    success: function(response) {
                        $('#form_create_post')[0].reset();
                        $('#category_id_submit').prop('selectedIndex', 0);
                        $('#category_id_submit').trigger('chosen:updated');
                        alert('Câu hỏi của bạn đã được gửi thành công và đang chờ phê duyệt');
                    }
                });
            }
        });

        $('.li-tab').click(function() {
            var data_link = $(this).attr('data-link');
            $('.li-tab').removeClass('active');
            $(this).addClass('active');
            var type_tab = $('.li-tab.active').attr('data-link');
            var last_page = <?= $total_page ?>;
            var last_page_popular = <?= $total_page_popular ?>;
            var last_page_not_answer = <?= $total_page_not_answer ?>;
            var page = $(this).attr('rel');
            if ($(this).attr('rel') == '>') {
                page = 2;
            } else if ($(this).attr('rel') == '>>') {
                if (type_tab == 'tab-newest') {
                    page = last_page;
                } else if (type_tab == 'tab-popular') {
                    page = last_page_popular;
                } else if (type_tab == 'tab-not-answer') {
                    page == last_page_not_answer;
                }
            }
            $('.total_tab').removeClass('active');
            $('#' + data_link).addClass('active');
            $('#' + data_link + '-2').addClass('active');
            $('.paginate-tab').removeClass('active');
            $('#' + data_link + '-3').addClass('active');

            $('#' + data_link).fadeIn(0);
            $('#' + data_link + '-2').fadeIn(0);
            $('#' + data_link + '-3').fadeIn(0);
        });

        $('.btn-mobile').click(function() {
            var data_link = $(this).attr('data-link');
            $('.btn-mobile').removeClass('active');
            $(this).addClass('active');
            $('.content_tab ').removeClass('active');
            $('#' + data_link).addClass('active');
        });

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };

        $('body').on('change', '#category_id', function() {
            if (getUrlParameter('search-qa') == false) {
                var search_key = '';
            } else {
                var search_key = getUrlParameter('search-qa');
            }
            var page_size = $('#page_size').val();
            var category_id = $(this).val();
            var x = $(this).attr('rel');
            $.ajax({
                url: '/qacenter/qacenter',
                data: {
                    category_id: category_id,
                    search_key: search_key,
                    page_size: page_size,
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_qa').html();

                    var rendered = '';
                    $.each(jsonData['lq_newest'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#tab-newest-2").html(rendered);

                    var rendered_popular = '';
                    $.each(jsonData['lq_popular'], function(key, val) {
                        rendered_popular += Mustache.render(tmpl, val);
                    });
                    $("#tab-popular-2").html(rendered_popular);

                    var rendered_not_answer = '';
                    $.each(jsonData['lq_not_answer'], function(key, val) {
                        rendered_not_answer += Mustache.render(tmpl, val);
                    });
                    $("#tab-not-answer-2").html(rendered_not_answer);

                    $('.sp_total_qa_newest').html(jsonData['total_question']);
                    $('.sp_total_qa_popular').html(jsonData['total_question_popular']);
                    $('.sp_total_qa_not_answer').html(jsonData['total_question_not_answer']);

                    $('#tab-newest-3').html(jsonData['cacul_page']);
                    $('#tab-popular-3').html(jsonData['cacul_page_popular']);
                    $('#tab-not-answer-3').html(jsonData['cacul_page_not_answer']);

                    $('html, body').animate({
                        scrollTop: $(".main-faq-top").offset().top
                    }, 1000);
                }
            });
        });

        $('body').on('change', '#page_size', function() {
            if (getUrlParameter('search-qa') == false) {
                var search_key = '';
            } else {
                var search_key = getUrlParameter('search-qa');
            }
            var category_id = $('#category_id').val();
            var page_size = $(this).val();
            var x = $(this).attr('rel');
            console.log(page_size);
            $.ajax({
                url: '/qacenter/qacenter',
                data: {
                    page_size: page_size,
                    search_key: search_key,
                    category_id: category_id,
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_qa').html();

                    var rendered = '';
                    $.each(jsonData['lq_newest'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#tab-newest-2").html(rendered);

                    var rendered_popular = '';
                    $.each(jsonData['lq_popular'], function(key, val) {
                        rendered_popular += Mustache.render(tmpl, val);
                    });
                    $("#tab-popular-2").html(rendered_popular);

                    var rendered_not_answer = '';
                    $.each(jsonData['lq_not_answer'], function(key, val) {
                        rendered_not_answer += Mustache.render(tmpl, val);
                    });
                    $("#tab-not-answer-2").html(rendered_not_answer);

                    $('.sp_total_qa_newest').html(jsonData['total_question']);
                    $('.sp_total_qa_popular').html(jsonData['total_question_popular']);
                    $('.sp_total_qa_not_answer').html(jsonData['total_question_not_answer']);

                    $('#tab-newest-3').html(jsonData['cacul_page']);
                    $('#tab-popular-3').html(jsonData['cacul_page_popular']);
                    $('#tab-not-answer-3').html(jsonData['cacul_page_not_answer']);

                    $('html, body').animate({
                        scrollTop: $(".main-faq-top").offset().top
                    }, 1000);
                }
            });
        });

        $('body').on('click', '.pager', function() {
            if (getUrlParameter('search-qa') == false) {
                var search_key = '';
            } else {
                var search_key = getUrlParameter('search-qa');
            }
            var category_id = $('#category_id').val();
            var page_size = $('#page_size').val();
            var type_tab = $('.li-tab.active').attr('data-link');

            var last_page = <?= $total_page ?>;
            var last_page_popular = <?= $total_page_popular ?>;
            var last_page_not_answer = <?= $total_page_not_answer ?>;
            var page = $(this).attr('rel');

            $('.img-loading').addClass('loading');

            if ($(this).attr('rel') == '>') {
                page = 2;
            } else if ($(this).attr('rel') == '>>' && type_tab == 'tab-newest') {
                page = last_page;
            } else if ($(this).attr('rel') == '>>' && type_tab == 'tab-popular') {
                page = last_page_popular;
            } else if ($(this).attr('rel') == '>>' && type_tab == 'tab-not-answer') {
                page = last_page_not_answer;
            }

            $.ajax({
                url: '/qacenter/qacenter',
                data: {
                    page: page,
                    category_id: category_id,
                    page_size: page_size,
                    search_key: search_key
                },
                type: 'POST',
                success: function(res) {
                    var jsonData = JSON.parse(res);
                    let tmpl = $('#template_qa').html();

                    var rendered = '';
                    $.each(jsonData['lq_newest'], function(key, val) {
                        rendered += Mustache.render(tmpl, val);
                    });
                    $("#tab-newest-2").html(rendered);

                    var rendered_popular = '';
                    $.each(jsonData['lq_popular'], function(key, val) {
                        rendered_popular += Mustache.render(tmpl, val);
                    });
                    $("#tab-popular-2").html(rendered_popular);

                    var rendered_not_answer = '';
                    $.each(jsonData['lq_not_answer'], function(key, val) {
                        rendered_not_answer += Mustache.render(tmpl, val);
                    });
                    $("#tab-not-answer-2").html(rendered_not_answer);

                    $('#tab-newest-3').html(jsonData['cacul_page']);
                    $('#tab-popular-3').html(jsonData['cacul_page_popular']);
                    $('#tab-not-answer-3').html(jsonData['cacul_page_not_answer']);

                    $('.img-loading').removeClass('loading');

                    $('html, body').animate({
                        scrollTop: $(".main-faq-top").offset().top
                    }, 1000);
                }
            });
        });
        $('.li-tab a').click(function() {
            var url = $(this).attr('dthref');
            if (typeof(history.pushState) != "undefined") {
                var obj = {
                    Title: '',
                    Url: url
                };
                history.pushState(obj, obj.Title, obj.Url);
                $('html, body').animate({
                    scrollTop: $(".main-faq-top").offset().top
                }, 1000);

                // $.ajax({
                //     url: '/qacenter/qacenter',
                //     data: {
                //         page: 1,
                //     },
                //     type: 'POST',
                //     success: function(res) {
                //         var jsonData = JSON.parse(res);
                //         let tmpl = $('#template_qa').html();

                //         var rendered = '';
                //         $.each(jsonData['lq_newest'], function(key, val) {
                //             rendered += Mustache.render(tmpl, val);
                //         });
                //         $("#tab-newest-2").html(rendered);

                //         var rendered_popular = '';
                //         $.each(jsonData['lq_popular'], function(key, val) {
                //             rendered_popular += Mustache.render(tmpl, val);
                //         });
                //         $("#tab-popular-2").html(rendered_popular);

                //         var rendered_not_answer = '';
                //         $.each(jsonData['lq_not_answer'], function(key, val) {
                //             rendered_not_answer += Mustache.render(tmpl, val);
                //         });
                //         $("#tab-not-answer-2").html(rendered_not_answer);

                //         $('#tab-newest-3').html(jsonData['cacul_page']);
                //         $('#tab-popular-3').html(jsonData['cacul_page_popular']);
                //         $('#tab-not-answer-3').html(jsonData['cacul_page_not_answer']);

                //         $('.img-loading').removeClass('loading');

                //         $('html, body').animate({
                //             scrollTop: $(".main-faq-top").offset().top
                //         }, 1000);
                //     }
                // });
            }
        });
    });
</script>

<?php

use frontend\models\QaCategory;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

?>

<div class="container">
    <div class="breadcrumbs">
        <a href="https://thebank.vn">Trang chủ</a>
        <i></i>
        <span>Hỏi đáp</span>
    </div>
    <div class="container-faq">
        <div class="tab-mobile">
            <div class="tab-left btn-mobile active" data-link="tab-list-qa">
                <i></i>
                <div class="list-qa-distance"></div>
                <span>Câu hỏi thường gặp</span>
            </div>
            <div class="tab-right btn-mobile" data-link="tab-question-qa">
                <i></i>
                <div class="question-qa-distance"></div>
                <span>Đặt câu hỏi</span>
            </div>
        </div>
        <div class="faq-center-left content_tab active" id="tab-list-qa">
            <div class="search-faq position-relative">
                <form action="" method="GET">
                    <input type="text" name="search-qa" class="search-qa" id="search-qa" placeholder="Hãy tìm câu trả lời trước khi đặt câu hỏi..." autocomplete="off" value="<?php if (isset($_GET['search-qa'])) echo $_GET['search-qa'] ?>" required pattern=".*\S+.*">
                    <button type="submit" class="button-search-qa"><i></i></button>
                </form>
                <ul id="result_search_qa">
                </ul>
            </div>
            <div class="title-faq">
                <h1 style="display: none;">Hỏi đáp thảo luận về các sản phẩm tài chính</h1>
                <h2 style="display: none;">Hỏi đáp thảo luận về các sản phẩm tài chính</h2>
                <h3 style="display: none;">Hỏi đáp thảo luận về các sản phẩm tài chính</h3>
                <h4>Hỏi đáp thảo luận về các sản phẩm tài chính</h4>
            </div>
            <div class="hr-faq">
                <hr>
            </div>
            <div class="list-faq">
                <ul class="row">
                    <?php foreach ($qa_category_2 as $item) :
                        $params = Url::to(['qacenter/qacenter', 'category_id' => $item['id'], 'slug' => $this->context->actionSlug($item['name'])]);

                    ?>
                        <li class="col-12 col-md-6">
                            <i></i>
                            <div class="li-faq-distance"></div>
                            <a href="<?= $params ?>" <?php
                                                        if (isset($category_id)) {
                                                            if ($category_id == $item['id']) {
                                                                echo "style='color: #436eb3;'";
                                                            };
                                                        };
                                                        ?> target="_blank">
                                <?php if (strtolower(substr($item['name'], 0, 1)) != substr($item['name'], 0, 1)) echo "Hỏi đáp " ?>
                                <?= strtolower(substr($item['name'], 0, 1)) ?><?php if (strpos(substr($item['name'], 1), '-')) {
                                                                                    echo substr(substr($item['name'], 1), 0, strpos(substr($item['name'], 1), '-'));
                                                                                } else {
                                                                                    echo substr($item['name'], 1);
                                                                                } ?>
                                (<?= $item['count_question'] ?>)
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="make-request-faq content_tab" id="tab-question-qa">
            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
                'class' => 'question-box',
                'id' => 'form_create_post'
            ]) ?>
            <div class="question-qa">
                <i></i>
                <div class="question-qa-distance"></div>
                <span>Đặt câu hỏi</span>
            </div>
            <div class="tips-qa">
                <span>Mẹo: Chọn đúng chủ đề sẽ giúp người khác tìm hỏi được câu hỏi của bạn.</span>
            </div>
            <div class="select-topic-qa">
                <select name="category_id" class="chosen_js" id="category_id_submit">
                    <option value="">Chọn chủ đề</option>
                    <option value="2">Thẻ tín dụng</option>
                    <option value="12">Bảo hiểm nhân thọ</option>
                    <option value="9">Vay tín chấp</option>
                    <option value="10">Vay thế chấp</option>
                    <option value="21">Vay tiêu dùng cá nhân</option>
                    <option value="24">Vay trả góp</option>
                    <option value="26">Vay mua xe ô tô</option>
                    <option value="22">Vay mua nhà</option>
                    <option value="3">Vay vốn ngân hàng</option>
                    <option value="23">Vay kinh doanh</option>
                    <option value="25">Vay du học</option>
                    <option value="13">Bảo hiểm sức khỏe</option>
                    <option value="16">Bảo hiểm thai sản</option>
                    <option value="15">Bảo hiểm ô tô</option>
                    <option value="11">Bảo hiểm</option>
                    <option value="18">Bảo hiểm y tế</option>
                    <option value="41">Bảo hiểm bệnh hiểm nghèo</option>
                    <option value="19">Bảo hiểm phi nhân thọ khác</option>
                    <option value="38">Ngân hàng điện tử</option>
                    <option value="27">Thẻ ghi nợ nội địa</option>
                    <option value="28">Thẻ ghi nợ quốc tế</option>
                    <option value="30">Thẻ hội viên</option>
                    <option value="29">Thẻ đồng thương hiệu</option>
                    <option value="4">Siêu thị & TT thương mại</option>
                    <option value="5">Điện máy và nội thất</option>
                    <option value="34">Ẩm thực</option>
                    <option value="37">Dịch vụ khác</option>
                </select>
                <span id="error_category_id" class="error_category_id"></span>
            </div>
            <div class="textarea-qa">
                <textarea name="question" id="question" placeholder="Nhập nội dung tại đây ..."></textarea>
                <span id="error_question" class="error_question"></span>
            </div>
            <div class="button-qa">
                <button type="button" id="button-submit">Gửi câu hỏi</button>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
    <div class="main-faq">
        <div class="main-faq-top">
            <div class="select-box-left">
                <select name="category_id" id="category_id" class="chosen_js">
                    <option value="">Lọc bởi danh mục</option>
                    <?php foreach ($qa_category as $item) {
                    ?>
                        <option value="<?= $item->id ?>" rel="<?= $item->id ?>" <?php if (isset($category_id)) {
                                                                                    if ($category_id == $item['id']) {
                                                                                        echo "selected";
                                                                                    };
                                                                                }; ?>><?= $item->name ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="select-box-right">
                <span>Câu hỏi mỗi trang</span>
                <select name="page_size" id="page_size" class="chosen_js">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </div>
        </div>
        <div class="main-faq-content">
            <div class="total">
                <div class="total_tab <?= $active_default ?>" id="tab-newest">
                    <div class="total_question">
                        <span>Câu hỏi</span>
                        <span class="sp_total_qa_newest"><?= $total_question ?></span>
                    </div>
                    <div class="total_member">
                        <span>Thành viên</span>
                        <span>2.833.878</span>
                    </div>
                </div>
                <div class="total_tab <?= $active_pb ?>" id="tab-popular">
                    <div class="total_question">
                        <span>Câu hỏi</span>
                        <span class="sp_total_qa_popular"><?= $total_question_popular ?></span>
                    </div>
                    <div class="total_member">
                        <span>Thành viên</span>
                        <span>2.833.878</span>
                    </div>
                </div>
                <div class="total_tab <?= $active_notans ?>" id="tab-not-answer">
                    <div class="total_question">
                        <span>Câu hỏi</span>
                        <span class="sp_total_qa_not_answer"><?= $total_question_not_answer ?></span>
                    </div>
                    <div class="total_member">
                        <span>Thành viên</span>
                        <span>2.833.878</span>
                    </div>
                </div>
            </div>

            <ul class="nav-tabs" id="nav-tabs">
                <li class="tab-newest li-tab <?= $active_default ?>" data-link="tab-newest">
                    <a href="javascript:;" dthref="<?= $current_url ?>.html">Mới nhất</a>
                </li>
                <li class="tab-popular li-tab <?= $active_pb ?>" data-link="tab-popular">
                    <a href="javascript:;" dthref="<?= $current_url ?>/pho-bien.html">Phổ biến</a>
                </li>
                <li class="tab-not-answer li-tab <?= $active_notans ?>" data-link="tab-not-answer">
                    <a href="javascript:;" dthref="<?= $current_url ?>/chua-co-tra-loi.html">Chưa có trả lời</a>
                </li>
            </ul>
            <div class="list-question">
                <ul class="ul_question total_tab <?= $active_default ?>" id="tab-newest-2">
                    <?php foreach ($lq_newest as $item) :
                        $url = Url::to(['qacenter/qacenter', 'category_id' => $item['category_id'], 'slug' => $this->context->actionSlug(isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '')]);
                    ?>
                        <li class="row li_question">
                            <div class="col-md-8 d-block d-md-flex">
                                <img src="/stores/images/qacenter/avatar.png" alt="avatar" class="img-circle">
                                <img src="/stores/images/qacenter/avatar-mobile.png" alt="avatar_mobile" class="img-circle-mobile">
                                <div class="question_from_member_left">
                                    <p>
                                        <a href="javascript:;"><?= $item['user_name'] ?></a> hỏi:
                                    </p>
                                    <a href="https://thebank.vn/hoi-dap-faq/<?= $item['category_id'] ?>-<?= isset($arr_cate[$item['category_id']]) ? $this->context->actionSlug($arr_cate[$item['category_id']]) : '' ?>/<?= $item['id'] ?>-<?= $this->context->actionSlug($item['question']); ?>.html" target="_blank">
                                        <span><?= $item['question'] ?></span>
                                    </a>
                                    <hr>
                                    <div class="li-statistics">
                                        <p>Được hỏi vào <?= $item['date_create'] ?> mục
                                            <a href="<?= $url ?>" target="_blank"><?= isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '' ?></a>
                                        </p>
                                        <div class="statistics-mobile d-flex d-md-none">
                                            <div class="statistics-views-mobile">
                                                <i></i>
                                                <span><?= $item['viewed'] ?></span>
                                            </div>
                                            <div class="statistics-replies-mobile">
                                                <i></i>
                                                <span><?= $item['nums_user_answer'] ?></span>
                                            </div>
                                            <div class="statistics-likes-mobile">
                                                <i></i>
                                                <span>0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="question_from_member_right d-none d-md-flex">
                                    <div class="statistics-views">
                                        <p><?= $item['viewed'] ?></p>
                                        <span class="roboto-light">Lượt xem</span>
                                    </div>
                                    <div class="statistics-replies">
                                        <p><?= $item['nums_user_answer'] ?></p>
                                        <span class="roboto-light">Trả lời</span>
                                    </div>
                                    <div class="statistics-likes">
                                        <p>0</p>
                                        <span class="roboto-light">Lượt thích</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="ul_question total_tab <?= $active_pb ?>" id="tab-popular-2">
                    <?php foreach ($lq_popular as $item) :
                        $url = Url::to(['qacenter/qacenter', 'category_id' => $item['category_id'], 'slug' => $this->context->actionSlug(isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '')]);
                    ?>
                        <li class="row li_question">
                            <div class="col-md-8 d-block d-md-flex">
                                <img src="/stores/images/qacenter/avatar.png" alt="avatar" class="img-circle">
                                <img src="/stores/images/qacenter/avatar-mobile.png" alt="avatar_mobile" class="img-circle-mobile">
                                <div class="question_from_member_left">
                                    <p>
                                        <a href="javascript:;" target="_blank"><?= $item['user_name'] ?></a> hỏi:
                                    </p>
                                    <a href="https://thebank.vn/hoi-dap-faq/<?= $item['category_id'] ?>-<?= isset($arr_cate[$item['category_id']]) ? $this->context->actionSlug($arr_cate[$item['category_id']]) : '' ?>/<?= $item['id'] ?>-<?= $this->context->actionSlug($item['question']);  ?>.html" target="_blank">
                                        <span><?= $item['question'] ?></span>
                                    </a>
                                    <hr>
                                    <div class="li-statistics">
                                        <p>Được hỏi vào <?= $item['date_create'] ?> mục
                                            <a href="<?= $url ?>" target="_blank"><?= isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '' ?></a>
                                        </p>
                                        <div class="statistics-mobile d-flex d-md-none">
                                            <div class="statistics-views-mobile">
                                                <i></i>
                                                <span><?= $item['viewed'] ?></span>
                                            </div>
                                            <div class="statistics-replies-mobile">
                                                <i></i>
                                                <span><?= $item['nums_user_answer'] ?></span>
                                            </div>
                                            <div class="statistics-likes-mobile">
                                                <i></i>
                                                <span>0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="question_from_member_right d-none d-md-flex">
                                    <div class="statistics-views">
                                        <p><?= $item['viewed'] ?></p>
                                        <span class="roboto-light">Lượt xem</span>
                                    </div>
                                    <div class="statistics-replies">
                                        <p><?= $item['nums_user_answer'] ?></p>
                                        <span class="roboto-light">Trả lời</span>
                                    </div>
                                    <div class="statistics-likes">
                                        <p>0</p>
                                        <span class="roboto-light">Lượt thích</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="ul_question total_tab <?= $active_notans ?>" id="tab-not-answer-2">
                    <?php foreach ($lq_not_answer as $item) :
                        $url = Url::to(['qacenter/qacenter', 'category_id' => $item['category_id'], 'slug' => $this->context->actionSlug(isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '')]);
                    ?>
                        <li class="row li_question">
                            <div class="col-md-8 d-block d-md-flex">
                                <img src="/stores/images/qacenter/avatar.png" alt="avatar" class="img-circle">
                                <img src="/stores/images/qacenter/avatar-mobile.png" alt="avatar_mobile" class="img-circle-mobile">
                                <div class="question_from_member_left">
                                    <p>
                                        <a href="javascript:;" target="_blank"><?= $item['user_name'] ?></a> hỏi:
                                    </p>
                                    <a href="https://thebank.vn/hoi-dap-faq/<?= $item['category_id'] ?>-<?= isset($arr_cate[$item['category_id']]) ? $this->context->actionSlug($arr_cate[$item['category_id']]) : '' ?>/<?= $item['id'] ?>-<?= $this->context->actionSlug($item['question']);  ?>.html" target="_blank">
                                        <span><?= $item['question'] ?></span>
                                    </a>
                                    <hr>
                                    <div class="li-statistics">
                                        <p>Được hỏi vào <?= $item['date_create'] ?> mục
                                            <a href="<?= $url ?>" target="_blank"><?= isset($arr_cate[$item['category_id']]) ? $arr_cate[$item['category_id']] : '' ?></a>
                                        </p>
                                        <div class="statistics-mobile d-flex d-md-none">
                                            <div class="statistics-views-mobile">
                                                <i></i>
                                                <span><?= $item['viewed'] ?></span>
                                            </div>
                                            <div class="statistics-replies-mobile">
                                                <i></i>
                                                <span><?= $item['nums_user_answer'] ?></span>
                                            </div>
                                            <div class="statistics-likes-mobile">
                                                <i></i>
                                                <span>0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="question_from_member_right d-none d-md-flex">
                                    <div class="statistics-views">
                                        <p><?= $item['viewed'] ?></p>
                                        <span class="roboto-light">Lượt xem</span>
                                    </div>
                                    <div class="statistics-replies">
                                        <p><?= $item['nums_user_answer'] ?></p>
                                        <span class="roboto-light">Trả lời</span>
                                    </div>
                                    <div class="statistics-likes">
                                        <p>0</p>
                                        <span class="roboto-light">Lượt thích</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="paginate">
                <img src="/stores/images/qacenter/loading-page.gif" class="img-loading" alt="img_loading">
                <div class="paginate-faq paginate-tab active" id="tab-newest-3">
                    <?php foreach ($list_li as $item) : ?>
                        <a href="javascript:void(0)" class="pager" rel="<?= $item['page'] ?>"><?= $item['page'] ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="paginate-faq paginate-tab" id="tab-popular-3">
                    <?php foreach ($list_li_popular as $item) : ?>
                        <a href="javascript:void(0)" class="pager" rel="<?= $item['page'] ?>"><?= $item['page'] ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="paginate-faq paginate-tab" id="tab-not-answer-3">
                    <?php foreach ($list_li_not_answer as $item) : ?>
                        <a href="javascript:void(0)" class="pager" rel="<?= $item['page'] ?>"><?= $item['page'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script id="template_pager" type="x-tmpl-mustache">
    <a href="javascript:void(0)" class="pager" rel={{page}}>{{page}}</a>
</script>

<script id="template_qa" type="x-tmpl-mustache">
    <li class="row li_question">
        <div class="col-md-8 d-block d-md-flex">
            <img src="/stores/images/qacenter/avatar.png" alt="avatar" class="img-circle">
            <img src="/stores/images/qacenter/avatar-mobile.png" alt="avatar_mobile" class="img-circle-mobile">
            <div class="question_from_member_left">
                <p>
                    <a href="javascript:;">{{user_name}}</a> hỏi:
                </p>
                <a href={{url_question}} target="_blank">
                    <span>{{question}}</span>
                </a>
                <hr>
                <div class="li-statistics">
                    <p>Được hỏi vào {{date_create}} mục
                        <a href="{{href}}" target="_blank">{{category_name}}</a>
                    </p>
                    <div class="statistics-mobile d-flex d-md-none">
                        <div class="statistics-views-mobile">
                            <i></i>
                            <span>{{viewed}}</span>
                        </div>
                        <div class="statistics-replies-mobile">
                            <i></i>
                            <span>{{nums_user_answer}}</span>
                        </div>
                        <div class="statistics-likes-mobile">
                            <i></i>
                            <span>0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="question_from_member_right d-none d-md-flex">
                <div class="statistics-views">
                    <p>{{viewed}}</p>
                    <span class="roboto-light">Lượt xem</span>
                </div>
                <div class="statistics-replies">
                    <p>{{nums_user_answer}}</p>
                    <span class="roboto-light">Trả lời</span>
                </div>
                <div class="statistics-likes">
                    <p>0</p>
                    <span class="roboto-light">Lượt thích</span>
                </div>
            </div>
        </div>
    </li>
</script>