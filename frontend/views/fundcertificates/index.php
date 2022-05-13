<?php 
    use yii\web\Controller;
    use frontend\controllers\ShareController;
    if(isset($_GET['order']) && $_GET['order'] == 'asc'){
        $order = 'desc';
    }else{
        $order = 'asc';
    }
?>
<link rel="stylesheet" href="/stores/css/fundcertificates.css" type="text/css" />
<link rel="stylesheet" href="/stores/css/jquery.multiselect.filter.css" type="text/css" />
<link rel="stylesheet" href="/stores/css/chosen.css" type="text/css" />
<link rel="stylesheet" href="/stores/css/slick.css" type="text/css" />

<script type='text/javascript' src="/stores/js/chosen.jquery.js"></script>
<script type='text/javascript' src="/stores/js/jquery-ui.min.js"></script>
<script type='text/javascript' src="/stores/js/chosen.jquery.js"></script>
<script type='text/javascript' src="/stores/js/jquery.multiselect.js"></script>
<script type='text/javascript' src="/stores/js/jquery.multiselect.filter.js"></script>
<script type='text/javascript' src="/stores/js/char.min.js"></script>
<script src="/stores/js/mustache.min.js"></script>
<script src="/stores/js/bootstrap.min.js"></script>
<script src="/stores/js/slick.js"></script>


<div class="container">
    <div class="breadcrumbs">
        <a href="https://thebank.vn">Trang chủ</a>
        <i></i>
        <a href="https://thebank.vn/san-pham.html">Sản phẩm</a>
        <i></i>
        <span>Chứng chỉ quỹ</span>
    </div>
    <div class="box_search">
        <h1 class="text-uppercase">So sánh quỹ đầu tư</h1>
        <form action="" method="GET" enctype="multipart/form-data" id="tuyen_form_search">
            <div class="row-fluid">
                <div class="form-group gr_company">
                    <i class="sl_1"></i>
                    <select multiple="multiple" class="" id="company_fund" name="company[]" style="display: none;">
                        <?php 
                            $arr_get_company = isset($_GET['company']) ? $_GET['company'] : [];
                            foreach($list_company_tag as $val) :
                                if(in_array($val['id'], $arr_get_company))
                                    $selected = 'selected';
                                else 
                                    $selected = '';
                        ?>
                            <option <?= $selected ?> value="<?= $val['id'] ?>"><?= $val['long_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group quydt">
                    <i class="sl_2"></i>
                    <select multiple="multiple" class="" id="fund_cert" name="fund[]" style="display: none;">
                        <?php 
                            $arr_get_fund = isset($_GET['fund']) ? $_GET['fund'] : [];
                            foreach($list_certificates_name as $key => $val) :
                                if(in_array($key, $arr_get_fund))
                                    $selected = 'selected';
                                else 
                                    $selected = '';
                        ?>
                            <option <?= $selected ?> value="<?= $key ?>"><?= $val ?></option>
                        <?php endforeach; ?>
                    </select> 
                </div>
                <div class="form-group position-relative">
                    <i class="sl_3"></i>
                    <select class="sl_chosen" id="type_fund" name="type_fund">
                        <option value="">Chọn loại hình quỹ</option> 
                        <?php 
                            foreach($type_fund as $k => $v) :
                                if(isset($_GET['type_fund']) && $_GET['type_fund'] == $k)
                                    $sled = 'selected';
                                else 
                                    $sled = '';
                        ?>
                            <option <?= $sled ?> value="<?= $k ?>"><?= $v ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="i_sl"></i>
                </div>
                <div class="form-group f_gr_mb">
                    <button type="submit" name="search" value="search" class="btn btnsearch"> <img src="/stores/images/icon/search.png" alt=""> Tìm kiếm</button> 
                </div>
                <div class="form-group f_gr_mb">
                    <button type="button" name="chonlai" value="reset" class="btn btnreset">Chọn lại</button>
                </div>
            </div>
            <div class="row-fluid count_fund">
                <div class="pull-left f16"><i class="fa fa-credit-card-alt i_cart"></i> Có <?= $count_result ?> sản phẩm</div>
            </div>
        </form>
    </div>
    <div class="sort_mb d-flex d-lg-none">
        <div class="orders"  data-toggle="modal" data-target="#myModaloders">
            Sắp xếp <i class="fa fa-filter pull-right"></i>
        </div>
    </div>
    <div class="list_data">
        <div class="title_data d-none d-lg-grid">
            <div class="child_row">
                <p>Quỹ đầu tư</p>
            </div>
            <div class="child_row">
                <p>Loại hình quỹ</p>
            </div>
            <div class="child_row">
                <p>Phí phát hành</p>
                <a href="/chung-chi-quy.html?orderby=released_fee_percent&order=<?= $order ?>" target="_blank" title=""><i class="fa fa-long-arrow-down"></i><i class="fa fa-long-arrow-up"></i></a>
            </div>
            <div class="child_row">
                <p>Phí mua lại</p>
                <a href="/chung-chi-quy.html?orderby=repurchare_fee_percent&order=<?= $order ?>" target="_blank" title=""><i class="fa fa-long-arrow-down"></i><i class="fa fa-long-arrow-up"></i></a>
            </div>
            <div class="child_row">
                <p>Phí chuyển đổi</p>
                <a href="/chung-chi-quy.html?orderby=convert_fee_percent&order=<?= $order ?>" target="_blank" title=""><i class="fa fa-long-arrow-down"></i><i class="fa fa-long-arrow-up"></i></a>
            </div>
            <div class="child_row">
                <p>Phí quản lý</p>
            </div>
            <div class="child_row">
                <p>NAV/CCQ (đồng)</p>
            </div>
            <div class="child_row">
                <p>Đăng ký</p>
            </div>
        </div>
        <div class="group_data">
            <?php 
            if(!empty($result)) :
            foreach($result as $item) : ?>
                <div class="list_data_fund">
                    <div class="child_data show_description" data_id="<?= $item['id'] ?>">
                        <div>
                            <a href="">
                                <img class="avatart_company" src="<?= 'http://thebank.vn/' . $list_short_name_and_logo[$item['company_id']][0]; ?>"  alt="">
                            </a>
                            <div class="click_company">
                                <?= $item['certificates_name_cut'] ?>
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>
                        <div class="show_detail hide_pc des_<?= $item['id'] ?>" id="des_<?= $item['id'] ?>">
                            <div class="show_detail_back">
                                <h2 class="title_certificates f18 color2 text-uppercase font-weight-bold"><?= $item['certificates_name'] ?></h2>
                                <div class="row-fluid">
                                    <div class="col-lg-6">
                                        <div class="f16 font-weight-bold">Mục tiêu đầu tư</div>
                                        <div class="text-justify">
                                            <p><?= $item['investment_objectives'] ?></p>							
                                        </div>
                                        <div class="mtop10 f16 font-weight-bold">Chiến lược đầu tư</div>
                                        <div class="text-justify">
                                            <p><?= $item['investment_strategy'] ?></p>							
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mtop20 bg_white">
                                            <?php 
                                                $arr_distribution = explode(',', $item['distribution_agent']); 
                                                $count = count($arr_distribution);
                                                $arr_run_foreach = [];
                                            ?>
                                            <table class="table table_child">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4" class="text-center">Đại lý phân phối</th>
                                                    </tr>
                                                </thead>
                                                <?php for($i = 0;$i < $count; $i++): ?>
                                                    <?php 
                                                        $arr_run_foreach[$i] = $arr_distribution[$i];
                                                    ?>
                                                    <?php if (count($arr_run_foreach) == 4): ?>
                                                        <tr>
                                                        <?php foreach ($arr_run_foreach as $key => $value): ?>
                                                            <td class="text-center"><?php echo $value; ?></td>
                                                            <?php unset($arr_distribution[$key]); ?>
                                                        <?php endforeach ?>
                                                        </tr>
                                                        <?php $arr_run_foreach = []; ?>
                                                    <?php endif ?>
                                                <?php endfor; ?>
                                                <?php if (!empty($arr_distribution)): ?>
                                                    <tr>
                                                    <?php foreach ($arr_distribution as $k => $v): ?>
                                                        <td class="text-center"><?php echo $v; ?></td>
                                                    <?php endforeach ?>
                                                    </tr>
                                                <?php endif ?>
                                            </table>
                                        </div>
                                        <div class="mtop20 bg_white">
                                            <table class="table table_child">
                                                <tbody><tr>
                                                    <td rowspan="2" class="text-center font-weight-bold">Loại hình đầu tư</td>
                                                    <td class="text-center">Trái phiếu</td>
                                                    <td class="text-center">Cổ phiếu</td>
                                                    <td class="text-center">Tiền tệ</td>
                                                </tr>
                                                <tr>
                                                <td class="text-center"><?php echo !empty($item['type_investment']['bonds'])?$item['type_investment']['bonds'].'%':'-'; ?></td>
                                                    <td class="text-center"><?php echo !empty($item['type_investment']['share'])?$item['type_investment']['share'].'%':'-'; ?></td>
                                                    <td class="text-center"><?php echo !empty($item['type_investment']['currency'])?$item['type_investment']['currency'].'%':'-'; ?></td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






                        








                    </div>
                    <div class="child_data">
                        <p class="d-block d-lg-none p_tit">Loại hình quỹ</p><p><?= $item['type_fund_name'] ?></p>
                    </div>
                    <div class="child_data">
                        <p class="d-block d-lg-none p_tit">Phí phát hành</p>
                        <div>
                            <p><?= !empty($item['released_fee_percent'])?$item['released_fee_percent'].'%':'-'; ?></p>
                            <p><?= !empty($item['released_fee_money'])?$item['released_fee_money'].' Triệu':''; ?></p>
                        </div>
                    </div>
                    <div class="child_data">
                        <p class="d-block d-lg-none p_tit">Phí mua lại</p>
                        <p><?= !empty($item['repurchare_fee_percent']) ? $item['repurchare_fee_percent'] . '%' : '-' ?></p>
                    </div>
                    <div class="child_data">
                        <p class="d-block d-lg-none p_tit">Phí chuyển đổi</p>
                        <p><?= !empty($item['convert_fee_percent']) ? $item['convert_fee_percent'] . '%' : '-' ?></p>
                    </div>
                    <div class="child_data">
                        <p class="d-block d-lg-none p_tit">Phí quản lý</p>
                        <p><?= $item['manage_fund_fee'] ?></p>
                    </div>
                    <div class="child_data show_charts" data_id="<?= $item['id'] ?>">
                        <div class="show_chart_mb" data_id="<?= $item['id'] ?>"> 
                            <p class="d-block d-lg-none p_tit">NAV/CCQ(đồng)</p>
                            <p><?= isset($item['nav_ccq'])  ? $item['nav_ccq'] : '' ?> <i class="fa fa-angle-down show_chart" data_id="<?= $item['id'] ?>"></i> </p> 
                        </div>             
                    </div>
                    <div class="child_data">
                        <a target="_blank" href="https://momi.onelink.me/qVwD/1304022" rel="nofollow" class="link_company">Đầu Tư Ngay</a>
                    </div>                                                                        
                </div>
                <div class="show_detail hide_mb des_<?= $item['id'] ?>" id="des_<?= $item['id'] ?>">
					<div class="show_detail_back">
                        <h2 class="title_certificates f18 color2 text-uppercase font-weight-bold"><?= $item['certificates_name'] ?></h2>
                        <div class="row-fluid">
                            <div class="col-lg-6">
                                <div class="f16 font-weight-bold">Mục tiêu đầu tư</div>
                                <div class="text-justify">
                                    <p><?= $item['investment_objectives'] ?></p>							
                                </div>
                                <div class="mtop10 f16 font-weight-bold">Chiến lược đầu tư</div>
                                <div class="text-justify">
                                    <p><?= $item['investment_strategy'] ?></p>							
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mtop20 bg_white">
                                    <?php 
                                        $arr_distribution = explode(',', $item['distribution_agent']); 
                                        $count = count($arr_distribution);
                                        $arr_run_foreach = [];
                                    ?>
                                    <table class="table table_child">
                                        <thead>
                                            <tr>
                                                <th colspan="4" class="text-center">Đại lý phân phối</th>
                                            </tr>
                                        </thead>
                                        <?php for($i = 0;$i < $count; $i++): ?>
                                            <?php 
                                                $arr_run_foreach[$i] = $arr_distribution[$i];
                                            ?>
                                            <?php if (count($arr_run_foreach) == 4): ?>
                                                <tr>
                                                <?php foreach ($arr_run_foreach as $key => $value): ?>
                                                    <td class="text-center"><?php echo $value; ?></td>
                                                    <?php unset($arr_distribution[$key]); ?>
                                                <?php endforeach ?>
                                                </tr>
                                                <?php $arr_run_foreach = []; ?>
                                            <?php endif ?>
                                        <?php endfor; ?>
                                        <?php if (!empty($arr_distribution)): ?>
                                            <tr>
                                            <?php foreach ($arr_distribution as $k => $v): ?>
                                                <td class="text-center"><?php echo $v; ?></td>
                                            <?php endforeach ?>
                                            </tr>
                                        <?php endif ?>
                                    </table>
                                </div>
                                <div class="mtop20 bg_white">
                                    <table class="table table_child">
                                        <tbody><tr>
                                            <td rowspan="2" class="text-center font-weight-bold">Loại hình đầu tư</td>
                                            <td class="text-center">Trái phiếu</td>
                                            <td class="text-center">Cổ phiếu</td>
                                            <td class="text-center">Tiền tệ</td>
                                        </tr>
                                        <tr>
                                        <td class="text-center"><?php echo !empty($item['type_investment']['bonds'])?$item['type_investment']['bonds'].'%':'-'; ?></td>
                                            <td class="text-center"><?php echo !empty($item['type_investment']['share'])?$item['type_investment']['share'].'%':'-'; ?></td>
                                            <td class="text-center"><?php echo !empty($item['type_investment']['currency'])?$item['type_investment']['currency'].'%':'-'; ?></td>
                                        </tr>
                                    </tbody></table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="chart_group chart_<?= $item['id'] ?>" id="chart_<?= $item['id'] ?>">
                    <div class="filter">
                        <div class="button_filter">
                            <button class="btnChart_<?= $item['id'] ?>" date="1">1 tháng</button>
                            <button class="btnChart_<?= $item['id'] ?> active" date="3">3 tháng</button>
                            <button class="btnChart_<?= $item['id'] ?>" date="6">6 tháng</button>
                            <button class="btnChart_<?= $item['id'] ?>" date="12">Năm</button>
                            <button class="btnChart_<?= $item['id'] ?>" date="all"class="btnChart">Tất cả</button>
                        </div>
                        <div class="filter_date">
                            <label for="">Từ</label>
                            <input onchange="filterData(<?=$item['id']?>,data_<?= $item['id'] ?>, myChart_<?= $item['id'] ?>)" type="date" id="startdate_<?=$item['id']?>">
                            <label for="">Đến</label>
                            <input onchange="filterData(<?=$item['id']?>, data_<?= $item['id'] ?>, myChart_<?= $item['id'] ?>)" type="date" id="enddate_<?=$item['id']?>">
                        </div>
                    </div>
                    <canvas id="<?php echo 'line-chart'.$item['id']; ?>" style=""></canvas >
                </div>

                <script type="text/javascript">
                    <?php
                        $chartjs_name = isset($item['chart_name']) ? $item['chart_name'] : [];
                        $chartjs_value = isset($item['chart_value']) ? $item['chart_value'] : [];
                        $data_sort = [23,13,12,11,8,7,6,4,22,10,5,15,9,31,30,14];
                        if (in_array($item['id'],$data_sort)) {
                            $chartjs_name = array_reverse($chartjs_name);
                            $chartjs_value = array_reverse($chartjs_value);
                        }
                        if(!empty($chartjs_name)): 
                    ?>
                            var data_<?= $item['id'] ?> = [
                                <?php foreach ($chartjs_name as $key => $value): ?>
                                    {'date':'<?php echo $value; ?>','value':'<?php echo (int)str_replace('.','', $chartjs_value[$key]); ?>'},
                                <?php endforeach ?>
                            ];  	
                            // console.log(JSON.stringify(data));

                            // console.log('date: ' + data); 
                            var myChart_<?= $item['id'] ?> = new Chart('<?php echo 'line-chart'.$item['id']; ?>', {
                                type: 'line',
                                data: {
                                    datasets: [{
                                    label: 'Giá',
                                    data:data_<?= $item['id'] ?>,
                                    borderColor: 'rgb(51, 102, 204)',
                                    backgroundColor: 'rgb(51, 102, 204)'
                                    }]
                                },
                                options: {
                                    parsing: {
                                        xAxisKey: 'date',
                                        yAxisKey: 'value'
                                    },
                            
                                    plugins: {
                                        tooltip: {
                                            mode: 'nearest',
                                            intersect: false
                                        }
                                    }					
                                },			
                            });		
                            $('.btnChart_<?= $item['id'] ?>').click(function(){
                                $('.btnChart_<?= $item['id'] ?>').removeClass('active');
                                $(this).addClass('active');

                                var month = $(this).attr('date');
                                if(month == 'all') {
                                    month = 100000;
                                }

                                var startDate = new Date();
                                var endDate = new Date();
                                startDate.setMonth(startDate.getMonth()-month);	 		
                                var data_new=   data_<?= $item['id'] ?>.filter(function (d, i) {
                                    var date_new = new Date(d.date);
                                    return date_new >= startDate && date_new <= endDate;
                                })	
                                // console.log(data_new);
                                if(data_new != '') {
                                    myChart_<?= $item['id'] ?>.data = {
                                        datasets: [{
                                        label: 'Giá',
                                        data:data_new,
                                        borderColor: 'rgb(51, 102, 204)',
                                        backgroundColor: 'rgb(51, 102, 204)'
                                        }]
                                    },
                                    myChart_<?= $item['id'] ?>.update();
                                }
                                // console.log('data_new: ' + JSON.stringify(data_new));
                            });		
                            
                            function filterData(id, data, myChart) {
                                var dateStart = new Date($('#startdate_' + id).val());
                                var dateEnd = new Date($('#enddate_' + id).val());
                                if(dateEnd == 'Invalid Date') {
                                    dateEnd = new Date();
                                }
                                var data_filter =   data.filter(function (d, i) {
                                    var date_new = new Date(d.date);
                                    return date_new >= dateStart && date_new <= dateEnd;
                                });
                                if(data_filter != '') {
                                    myChart.data = {
                                        datasets: [{
                                        label: 'Giá',
                                        data:data_filter,
                                        borderColor: 'rgb(51, 102, 204)',
                                        backgroundColor: 'rgb(51, 102, 204)'
                                        }]
                                    },
                                    myChart.update();
                                }				
                            }
                            $('.active').trigger('click');

                            
                    <?php endif ?>
                </script>                
            <?php 
                endforeach; 
                endif;
            ?>
        </div>
        <?php if($count_result > 10) : ?>
            <div class="view_data">
                <button class="see_more">Xem thêm <i class="fa fa-caret-down" aria-hidden="true"></i></button>
            </div>
        <?php endif; ?>
    </div>
    <div class="featured_products">
        <p><img src="/stores/images/icon/product-fea.png" alt="">Sản phẩm nổi bật</p>
        <div class="feat_child">
            <?php foreach($list_company_tag as $item) : ?>
                <a href="https://thebank.vn/chung-chi-quy/<?= $item['id'] . '-' . ShareController::slug($item['short_name']) .'.html' ?>"><?= $item['short_name'] ?></a>
            <?php endforeach; ?>
        </div>
    </div>
	<div class="faq_fund d-none d-lg-block">
		<?php if($arr_faq != null) { ?>
			<div class="faq_fund_title text-center">
					<p class="p_title_faq"><?= $arr_faq['tittle'] ?></p>
			</div>
			<div class="content_text_bottom">
				<?php
				foreach($arr_faq['list_faq'] as $value) {
					?>
					<h2><?= $value['question']?></h2>
					<p><?= $value['answer']?></p>
				<?php } ?>
			</div>
		<?php } ?>
	</div>    

    <?php if(!empty($arr_faq)) : ?>
        <div class="product_saving clear_border_bottom div_faq d-block d-lg-none">
                <h2 class="roboto title_faq"><?= $arr_faq['tittle'] ?></h2>
            <p class="roboto"></p>
            <ul class="ul_qa">
                <?php
                foreach($arr_faq['list_faq'] as $id => $arr):
                    ?>
                    <li>
                        <h3 class="roboto ct_question"><i class="fa fa-plus" aria-hidden="true"></i><span><?= $arr['question'] ?></span></h3>
                        <div class="roboto ct_answer_faq"><?= $arr['answer'] ?></div>
                    </li>
                <?php
                endforeach;
                ?>
            </ul>
        </div>
    <?php endif; ?>	    
</div>
<div class="overlay_chart"><i class="fa fa-times-circle" aria-hidden="true"></i></div>
<div class="modal" id="myModaloders">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">SẮP XẾP</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <ul>
                    <li>
                        <div class="row-fluid">
                            <div class="span6 color1">Phí phát hành </div>
                            <div class="span3">
                                <a class="color1" href="/chung-chi-quy.html?orderby=released_fee_percent&amp;order=asc"  title=""><i class="fa fa-arrow-up"></i></a>                            
                            </div>
                            <div class="span3">
                                <a class="color1" href="/chung-chi-quy.html?orderby=released_fee_percent&amp;order=desc"  title=""><i class="fa fa-arrow-down"></i></a>                            
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row-fluid">
                            <div class="span6 color1">Phí mua lại</div>
                            <div class="span3">
                                <a class="color1" href="/chung-chi-quy.html?orderby=repurchare_fee_percent&amp;order=asc"  title=""><i class="fa fa-arrow-up"></i></a>                            
                            </div>
                            <div class="span3">
                                <a class="color1" href="/chung-chi-quy.html?orderby=repurchare_fee_percent&amp;order=desc"  title=""><i class="fa fa-arrow-down"></i></a>                            
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row-fluid">
                            <div class="span6 color1">Phí chuyển đổi</div>
                            <div class="span3">
                                <a class="color1" href="/chung-chi-quy.html?orderby=convert_fee_percent&amp;order=asc"  title=""><i class="fa fa-arrow-up"></i></a>
                            </div>
                            <div class="span3">
                                <a class="color1" href="/chung-chi-quy.html?orderby=convert_fee_percent&amp;order=desc"  title=""><i class="fa fa-arrow-down"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.feat_child').slick({
            dots: false,
            rows: 2,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: false
                }
                },
                {
                breakpoint: 600, 
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
                },
                {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });        
        $('.btnreset').click(function(){
            $('.box_search select.sl_chosen').val('').trigger('chosen:updated');
            $('.box_search select[multiple="multiple"]').val('').multiselect('refresh');
        });
		$('#company_fund').on('change',function(){
	 		selected_company=[];
			$('#company_fund :selected').each(function(){
		     	selected_company.push($(this).val());
		    });
		    selected_fund = [];
		    $('#fund_cert :selected').each(function(){
		     	selected_fund.push($(this).val());
		    });
			if (selected_fund.length == 0) {
				$.ajax({
					url: '/fundcertificates/ajax_get_quydautu',
					type: 'POST',
					dataType: 'json',
					data: {arr_company_id:selected_company},
					success:function(response){
						$("#fund_cert").multiselect('destroy');
						$('#fund_cert').html(response.html);
						$("#fund_cert").multiselect({ noneSelectedText : "Quỹ đầu tư" ,  selectedText : "Đã chọn # Quỹ",classes: ''});
					}
				});
			}
		    
		});        
        $('.ct_question').on('click',function(){
			$(this).parent().find('.ct_answer_faq').toggle();
		});		
        $('.overlay_chart').click(function(){
            $('.chart_group').fadeOut();
            $(this).fadeOut();
        });
        $('body').on('click','.show_charts', function(){
            $('.show_detail').hide();
            var id_fund = $(this).attr('data_id');
            $('.chart_' + id_fund).toggle();
            $('.overlay_chart').toggle();

            $(this).toggleClass('active');
			if ($(this).hasClass('active')) {
                $(this).find('i').removeClass('fa-angle-down');
				$(this).find('i').addClass('fa-angle-up');
			}else{
				$(this).find('i').removeClass('fa-angle-up');
				$(this).find('i').addClass('fa-angle-down');
			}                 
        });
        
        $('body').on('click','.show_description', function(){
            $('.chart_group').hide();
            var id_fund = $(this).attr('data_id');
            $('.des_' + id_fund).toggle();
            $(this).toggleClass('active');
			if ($(this).hasClass('active')) {
                $(this).find('i').removeClass('fa-angle-down');
				$(this).find('i').addClass('fa-angle-up');
			}else{
				$(this).find('i').removeClass('fa-angle-up');
				$(this).find('i').addClass('fa-angle-down');
			}            
        });
        
        $('.sl_chosen').chosen();
		$("#company_fund").multiselect({ noneSelectedText : "Chọn công ty Quản lý quỹ" ,  selectedText : "Đã chọn # công ty",classes: ''}).multiselectfilter();
		$("#fund_cert").multiselect({ noneSelectedText : "Quỹ đầu tư" ,  selectedText : "Đã chọn # Quỹ",classes: ''}).multiselectfilter();

        $('#company_fund').on('change',function(){
	 		selected_company=[];
			$('#company_fund :selected').each(function(){
		     	selected_company.push($(this).val());
		    });
		    selected_fund = [];
		    $('#fund_cert :selected').each(function(){
		     	selected_fund.push($(this).val());
		    });
			if (selected_fund.length == 0) {
				$.ajax({
					url: '/pcmembership/fundcertificates/ajax_get_quydautu',
					type: 'POST',
					dataType: 'json',
					data: {arr_company_id:selected_company},
					success:function(response){
						$("#fund_cert").multiselect('destroy');
						$('#fund_cert').html(response.html);
						$("#fund_cert").multiselect({ noneSelectedText : "Quỹ đầu tư" ,  selectedText : "Đã chọn # Quỹ",classes: ''});
					}
				});
			}
		    
		});

		$('#fund_cert').on('change',function(){
			selected_company=[];
			$('#company_fund :selected').each(function(){
		     	selected_company.push($(this).val());
		    });
		    selected_fund = [];
		    $('#fund_cert :selected').each(function(){
		     	selected_fund.push($(this).val());
		    });
		    if (selected_company.length == 0) {
				$.ajax({
					url: '/pcmembership/fundcertificates/ajax_get_certificates_fund_company',
					type: 'POST',
					dataType: 'json',
					data: {arr_fund_id:selected_fund},
					success:function(response){
						$("#company_fund").multiselect('destroy');
						$('#company_fund').html(response.html);
						$("#company_fund").multiselect({ noneSelectedText : "Chọn công ty Quản lý quỹ" ,  selectedText : "Đã chọn # công ty",classes: ''}).multiselectfilter();
					}
				});
			}
		});
        var page = 0;
        $('body').on('click','.see_more',function(){
            page = page + 1;
            var company = '<?= isset($_GET['company']) ? implode(" ",$_GET['company']) : '' ?>';
            var fund = '<?= isset($_GET['fund']) ? implode(" ",$_GET['fund']) : '' ?>';
            var type_fund = '<?= isset($_GET['type_fund']) ? $_GET['type_fund'] : '' ?>';
          
            $.ajax({
                type: 'POST',
                url: '/fundcertificates/get-data-fund',
                data: {page:page,company:company,fund:fund,type_fund:type_fund},
                success: function(res) {
                    var data = $.parseJSON(res);
                    var count_data = data.length;
                    var render = '';
                    var tmpl = $('#template_fund').html();
                    $.each(data, function(key, val){
                        render += Mustache.render(tmpl,val);
                    });
                    $('.group_data').append(render);

                    if(count_data < 10) {
                        $('.view_data').remove();
                    }
                }
            });
        });
        // xu ly click an hien table
		$('.td_dad').on('click',function(){
			id_child_show = $(this).attr('data-id');
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				$('#'+id_child_show).addClass('hidden');
				$(this).find('i').removeClass('fa-angle-up');
				$(this).find('i').addClass('fa-angle-down');
			}else{
				$('.td_dad').removeClass('active');
				$('.show_after_click').addClass('hidden');
				$(this).addClass('active');
				$('#'+id_child_show).removeClass('hidden');
				$(this).find('i').removeClass('fa-angle-down');
				$(this).find('i').addClass('fa-angle-up');
			}
		});
    });
</script>

<script id="template_fund" type="x-tmpl-mustache">
    <div class="list_data_fund">
        <div class="child_data show_description" data_id="{{id}}">
            <div>
                <a href="">
                    <img class="avatart_company" src="{{{avatar}}}"  alt="">
                </a>
                <div class="click_company">
                    {{certificates_name_cut}}
                    <i class="fa fa-angle-down"></i>
                </div>
            </div>
            <div class="show_detail hide_pc des_{{id}}" id="des_{{id}}">
                <div class="show_detail_back">
                    <h2 class="title_certificates f18 color2 text-uppercase font-weight-bold">{{certificates_name}}</h2>
                    <div class="row-fluid">
                        <div class="col-lg-6">
                            <div class="f16 font-weight-bold">Mục tiêu đầu tư</div>
                            <div class="text-justify">
                                {{{investment_objectives}}}				
                            </div>
                            <div class="mtop10 f16 font-weight-bold">Chiến lược đầu tư</div>
                            <div class="text-justify">
                                {{{investment_strategy}}}						
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mtop20 bg_white">
                                <table class="table table_child">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="text-center">Đại lý phân phối</th>
                                        </tr>
                                    </thead>
                                    {{{html}}}
                                    {{{htmls}}}
                                </table>
                            </div>
                            <div class="mtop20 bg_white">
                                <table class="table table_child">
                                    <tbody><tr>
                                        <td rowspan="2" class="text-center font-weight-bold">Loại hình đầu tư</td>
                                        <td class="text-center">Trái phiếu</td>
                                        <td class="text-center">Cổ phiếu</td>
                                        <td class="text-center">Tiền tệ</td>
                                    </tr>
                                    <tr>
                                    <td class="text-center">{{bonds}}</td>
                                        <td class="text-center">{{share}}</td>
                                        <td class="text-center">{{currency}}</td>
                                    </tr>
                                </tbody></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="child_data">
            <p class="d-block d-lg-none p_tit">Loại hình quỹ</p>
            <p>{{type_fund_name}}</p>
        </div>
        <div class="child_data">
            <p class="d-block d-lg-none p_tit">Phí phát hành</p>
            <div>
                <p>{{released_fee_percent}}</p>
                <p>{{released_fee_money}}</p>
            </div>
        </div>
        <div class="child_data">
            <p class="d-block d-lg-none p_tit">Phí mua lại</p>
            <p>{{repurchare_fee_percent}}</p>
        </div>
        <div class="child_data">
            <p class="d-block d-lg-none p_tit">Phí chuyển đổi</p>
            <p>{{convert_fee_percent}}</p>
        </div>
        <div class="child_data">
            <p class="d-block d-lg-none p_tit">Phí quản lý</p>
            <p>{{manage_fund_fee}}</p>
        </div>
        <div class="child_data show_charts" data_id="{{id}}">
            <div class="show_chart_mb" data_id="<?= $item['id'] ?>"> 
                <p class="d-block d-lg-none p_tit">NAV/CCQ(đồng)</p>
                <p>{{nav_ccq}} <i class="fa fa-angle-down show_chart" data_id="{{id}}"></i> </p> 
            </div>            
        </div>
        <div class="child_data">
            <a target="_blank" href="https://momi.onelink.me/qVwD/1304022" rel="nofollow" class="link_company">Đầu Tư Ngay</a>
        </div>   
    </div>
    <div class="show_detail hide_mb des_{{id}}" id="des_{{id}}">
        <div class="show_detail_back">
            <h2 class="title_certificates f18 color2 text-uppercase font-weight-bold">{{certificates_name}}</h2>
            <div class="row-fluid">
                <div class="col-lg-6">
                    <div class="f16 font-weight-bold">Mục tiêu đầu tư</div>
                    <div class="text-justify">
                        {{{investment_objectives}}}				
                    </div>
                    <div class="mtop10 f16 font-weight-bold">Chiến lược đầu tư</div>
                    <div class="text-justify">
                        {{{investment_strategy}}}						
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mtop20 bg_white">
                        <table class="table table_child">
                            <thead>
                                <tr>
                                    <th colspan="4" class="text-center">Đại lý phân phối</th>
                                </tr>
                            </thead>
                            {{{html}}}
                            {{{htmls}}}
                        </table>
                    </div>
                    <div class="mtop20 bg_white">
                        <table class="table table_child">
                            <tbody><tr>
                                <td rowspan="2" class="text-center font-weight-bold">Loại hình đầu tư</td>
                                <td class="text-center">Trái phiếu</td>
                                <td class="text-center">Cổ phiếu</td>
                                <td class="text-center">Tiền tệ</td>
                            </tr>
                            <tr>
                            <td class="text-center">{{bonds}}</td>
                                <td class="text-center">{{share}}</td>
                                <td class="text-center">{{currency}}</td>
                            </tr>
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="chart_group chart_{{id}}" id="chart_{{id}}">
        <div class="filter">
            <div class="button_filter">
                <button class="btnChart_{{id}}" date="1">1 tháng</button>
                <button class="btnChart_{{id}} active" date="3">3 tháng</button>
                <button class="btnChart_{{id}}" date="6">6 tháng</button>
                <button class="btnChart_{{id}}" date="12">Năm</button>
                <button class="btnChart_{{id}}" date="all"class="btnChart">Tất cả</button>
            </div>
            <div class="filter_date">
                <label for="">Từ</label>
                <input onchange="filterData({{id}},{{data_char}}, myChart_{{id}})" type="date" id="startdate_{{id}}">
                <label for="">Đến</label>
                <input onchange="filterData({{id}},{{data_char}}, myChart_{{id}})" type="date" id="enddate_{{id}}">
            </div>
        </div>
        <canvas id="line-chart{{id}}" style=""></canvas >
    </div>
    {{{script_chart}}}
</script>