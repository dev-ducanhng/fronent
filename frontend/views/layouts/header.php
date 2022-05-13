<?php 
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

$url = 'https://thebank.vn';
?>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/stores/css/main.css" type="text/css" />

<script src="/stores/js/jquery.min.js"></script>
<script src="/stores/js/main.js"></script>

<div class="box_top_page d-none d-lg-block">
    <div class="header">
        <div class="container header_child">
            <div class="row">
				<div class="col-lg-2">
					<a href="<?= $url ?>" class="logo_thebank"><img alt="TheBank" src="/stores/images/logo_thebank.png" /></a>
				</div>
				<div class="col-lg-5 search_head">
					<form method="get" autocomplete="on" style="margin: 0" action="" id="search-form">
						<div class="input-group">
							<i class="icon_search"></i>
							<input type="text" name="q" class="form-control" id="search" placeholder="Tìm kiếm các dịch vụ" value="<?=isset($_GET['q']) ? strip_tags($_GET['q']) : ''?>">
							<span class="input-group-btn">
								<button id="search-btn" class="btn btn-default btn-search" type="button">Tìm kiếm</button>
							</span>
						</div>
					</form>
				</div>
				<div class="col-lg-3">
					<ul class="notification">
						<li class="notifi_child inbox load check_login">
							<a href="https://thebank.vn/hom-thu.html">
								<i class="thu_head"></i>
								<i style="display:none" class="notifi_count count_letter"></i>
								<p>Hòm thư</p>
							</a>
							<div>
								<div class="arrow_box_main">
									<div class="show_inbox">
										<span class="left">Hòm thư</span>
										<span class="roboto-light right check_all_inbox">Đánh dấu tất cả là đã đọc</span>
									</div>
									<ul class="tmpl_result_inbox">
										<li class="li_loading"><div class="loadding"><img  alt="loader" src="/stores/images/ajax-loader.gif"/></div></li>
									</ul>
									<div class="view_all_inb">
										<a href="">Xem tất cả Hòm thư</a>
									</div>
								</div>
							</div>
						</li>
						<li class="notifi_child sms check_login">
							<a href="https://thebank.vn/chat.html">
								<i class="chat_head"></i>
								<i style="display:none" class="notifi_count count_sms" data-count="0">0</i>
								<p>Chat</p>
							</a>
							<div>
								<div class="arrow_box_main">
									<div class="show_inbox">
										<span class="left">Chat</span>
									</div>
									<ul class="list_user_chated continute list_chat_menu" data-p="-1">
										<li class="loading_more_chated align_center left max_width"><i class="fa fa-spinner fa-pulse fa-fw"></i></li>
									</ul>
									<div class="view_all_inb">
										<a href="">Xem tất cả trong Chat</a>
									</div>
								</div>
							</div>
						</li>
						<li class="notifi_child noti load check_login">
							<a href="https://thebank.vn/thong-bao.html">
								<i class="noti_head"></i>
								<i style="display:none" class="notifi_count count_noti">0</i>
								<p>Thông báo</p>
							</a>							
							<div>
								<div class="arrow_box_main">
									<div class="show_inbox">
										<span class="left">Thông báo</span>
										<span class="roboto-light right check_all_noti">Đánh dấu tất cả là đã đọc</span>
									</div>
									<ul class="tmpl_result_noti">
										<li class="li_loading"><div class="loadding"><img alt="loader" src="/stores/images/ajax-loader.gif"/></div></li>
									</ul>

									<div class="view_all_inb">
										<a href="">Xem tất cả Thông báo</a>
									</div>
								</div>
							</div>
						</li>
					</ul>					
				</div>

				<div class="col-lg-2 pl-0 register_head">
					<?php
						if(isset($is_supplier)) {
					?>
						<div class="btn_meet_supplier" style="width:166px">
							<a href="https://thebank.vn/danh-sach-khach-hang.html">
								<span class="icon_meet_supplier" style="right:155px"><img src="/themes/pcmembership/stores/images/icon_meet_supplier.png" /></span>
								<span class="sp_btn">Gặp khách hàng</span>
							</a>
						</div>
					<?php
						} else {
					?>
						<a rel="nofollow" data-id="" class="roboto index_send_request ripple-effect" href="https://thebank.vn/dang-ky-tu-van-mien-phi.html">Gửi yêu cầu tư vấn<img alt="register" src="/stores/images/icon/free.svg" /></a>
						<?php /*
						<div class="btn_meet_supplier">
							<a href="<?= Yii::app()->createUrl('pcmembership/buyer/meetingsupplier') ?>">
								<span class="icon_meet_supplier"><img src="/themes/pcmembership/stores/images/icon_meet_supplier.png" /></span>
								<span class="sp_btn">Gặp chuyên gia tư vấn</span>
							</a>
						</div>
						*/ ?>
					<?php
						}
					?>		
				</div>		
			</div>
        </div>
        <div class="menu menu_header_page">
            <?php
                if(!isset($is_supplier)) {
            ?>
            <nav class="index_nav_menu nav">
                    <?php /*<?= $this->render('menu_supplier') ?> */ ?><!--  default  -->
                    <?= $this->render('menu') ?> <!--  supplier  -->
            </nav>
            <?php
                }else{
            ?>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="overflow:visible">
                        <ul class="nav navbar-nav">
                            <li class="li_main"><a href="<?= $url ?>">Trang chủ</a></li>
                            <li class="li_main dropdown">
                                <a rel="nofollow" href="" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false">Giới thiệu<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="dropdown-menu ul_child">
                                    <li><a href="">Về chúng tôi</a></li>
                                    <li><a href="">Bảng giá dịch vụ</a></li>
                                    <li><a href="">Cơ hội hợp tác kinh doanh</a></li>
                                    <li><a href="">Báo chí và truyền thông</a></li>
                                    <li><a href="">Cơ hội việc làm</a></li>
                                    <li><a href="">Quy chế hoạt động</a></li>
                                    <li><a href="">Chính sách bảo mật</a></li>
                                    <li><a href="">Thỏa thuận sử dụng</a></li>
                                    <li><a href="">Sứ mệnh và tầm nhìn</a></li>
                                </ul>
                            </li>
                            <li class="li_main dropdown">
                                <a href="" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false">Hòm thư<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="dropdown-menu ul_child">
                                    <li><a href="">Hộp thư đến</a></li>
                                    <li><a href="">Thư đã gửi</a></li>
                                    <li><a href="">Thư nháp</a></li>
                                    <li><a href="">Thùng rác</a></li>
                                </ul>
                            </li>
							<?php
								if(isset($is_supplier)) {
							?>
								<li class="li_main dropdown">
									<a href="javascript:;" class="check_login" dthref="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Khách hàng<i class="fa fa-angle-down" aria-hidden="true"></i></a>
									<ul class="dropdown-menu ul_child">
										<li><a href="javascript:;" class="check_login" dthref="">Danh sách khách hàng</a></li>
										<li><a href="javascript:;" class="check_login" dthref="">Khách hàng hệ thống phân phối</a></li>
										<li><a href="javascript:;" class="check_login" dthref="">Khách hàng xem số điện thoại</a></li>
										<li><a href="javascript:;" class="check_login" dthref="">Khách hàng từ nguồn khác</a></li>
										<li><a href="javascript:;" class="check_login" dthref="<">Khách hàng xem hồ sơ</a></li>
									</ul>
								</li>
								<li class="li_main"><a href="">Bảng giá</a></li>
								<?php
									if( isset(Yii::app()->user->service) && count(Yii::app()->user->service) > 0 )
									{
										$service_supplier = 0;
										$results_service  = 0;
										if(count($results_service) > 0):
								?>
											<li class="li_main dropdown">
												<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dịch vụ<i class="fa fa-angle-down" aria-hidden="true"></i></a>
												<ul class="dropdown-menu ul_child">
												<?php
													foreach($results_service as $model_service):
												?>
														<li><a href="<?= Yii::app()->createUrl('pcmembership/supplier/productByService',array('service_id'=>$model_service->id,'alias'=>ShareController::niceUrl($model_service->service_name))) ?>">Dịch vụ <?= strtolower( $model_service->service_name ) ?></a></li>
												<?php
													endforeach;
												?>
												</ul>
											</li>
								<?php
										endif;
									}
								?>
							<?php
								}
							?>
							<li class="li_main"><a rel="nofollow" href="<?= Yii::app()->createUrl('pcmembership/guide/guide') ?>">Hướng dẫn</a></li>
                        </ul>
						<ul class="nav navbar-nav right" style="margin-right:0">
							<?php
							if( !Yii::app()->user->isGuest ):
							?>
							<li class="dropdown li_account">
								<i class="sprite icon_acount"></i>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Tài Khoản của bạn <i class="fa fa-caret-down" id="arrow_account" aria-hidden="true"></i></a>
								<?php
									if(isset($is_supplier)) {
								?>
									<ul class="dropdown-menu arrow_box_account" id="menu_account_supplier">
										<li class="my-info"><a href="<?= Yii::app()->createUrl('pcmembership/supplier/profile') ?>" class="roboto-light"><i class="sprite_membership"></i>Thông tin tài khoản</a></li>
										<li class="edit-profile"><a href="<?= Yii::app()->createUrl('pcmembership/supplier/editprofile') ?>" class="roboto-light"><i class="sprite_membership"></i>Cập nhật thông tin</a></li>
										<li class="up-level"><a href="<?= Yii::app()->createUrl('pcmembership/supplier/upgradeAccount') ?>" class="roboto-light"><i class="sprite_membership"></i>Nâng cấp tài khoản</a></li>
										<?php /*<li class="up-level"><a href="<?= Yii::app()->createUrl('pcmembership/supplier/package_credit') ?>" class="roboto-light"><i class="sprite_membership"></i>Lịch sử mua credit</a></li> */ ?>
										<li class="history-transaction"><a href="<?= Yii::app()->createUrl('pcmembership/supplier/history_transaction') ?>" class="roboto-light"><i class="sprite_membership"></i>Quản lý giao dịch</a></li>
										<li class="edit-pass"><a href="<?= Yii::app()->createUrl('pcmembership/supplier/changePassword') ?>" class="roboto-light"><i class="sprite_membership"></i>Thay đổi mật khẩu</a></li>
										<li class="logout-account"><a href="<?= Yii::app()->createUrl('pcmembership/site/logout') ?>" class="roboto-light"><i class="sprite_membership"></i>Đăng xuất</a></li>
									</ul>
								<?php
									}
									else
									{
								?>
									<ul class="dropdown-menu arrow_box_account">
										<li class="my-profile"><a href="<?= Yii::app()->createUrl('pcmembership/userprofile/index') ?>" class="roboto-light"><i class="sprite_membership"></i>Hồ sơ của tôi</a></li>
										<li class="change-profile"><a href="<?= Yii::app()->createUrl('pcmembership/userprofile/editprofile') ?>" class="roboto-light"><i class="sprite_membership"></i>Sửa hồ sơ</a></li>
										<li class="change-password"><a href="<?= Yii::app()->createUrl('pcmembership/userprofile/changepassword') ?>" class="roboto-light"><i class="sprite_membership"></i>Thay đổi mật khẩu</a></li>
										<li class="logout-account"><a href="<?= Yii::app()->createUrl('pcmembership/site/logout') ?>" class="roboto-light"><i class="sprite_membership"></i>Đăng xuất</a></li>
									</ul>
								<?php } ?>
							</li>
							<?php
								endif;
							?>
						</ul>
                    </div>

                </div>
            </nav>
            <?php } ?>
        </div>
    </div>
</div>

<!-- mobi  -->
<div class="header d-block d-lg-none">
	<div class="child_header">
		<div class="child_headers header_fixed" id="top_header">
			<i onclick="openNav()" class="btn_menu_left sprite_2"></i>
			<i onclick="openNavright()" class="btn_menu_right sprite_2"></i>
			<div class="menu_logo">
				<a class="logo_thebanks" href="https://thebank.vn" rel="nofollow"><img alt="logo" src="/stores/images/logo_thebank.png"></a>
								<div class="wellcome">
					<a href="/dang-nhap.html"><p class="hello roboto-light">Chào Khách</p>
					<img class="avt_user" src="/stores/images/user_no_avatar.png">
					</a>
				</div>
			</div>
		</div>
		<div class="child_header head_scroll" style="margin-top: 55px;">
			<!-- <a href="/dang-nhap.html">
				<img class="avt_user_scroll" src="/stores/images/user_no_avatar.png">
			</a> -->
			<div class="search_head_mb">
				<form method="get" autocomplete="on" class="m-0 float-left" action="/tim-kiem.html" id="search-form">
					<i class="sprite_2 icon_search_all"></i>
					<input style="margin-bottom: 6px;" id="search" class="find_all ui-autocomplete-input" type="text" name="q" placeholder="Tìm kiếm các dịch vụ ..." autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
				</form>
				<a class="download_now" href="https://momi.onelink.me/qVwD/100122" rel="nofollow"> <i></i> Tải app</a>
			</div>
		</div>
	</div>
	<div class="header_child">
		<ul class="ul_menu">
			<li class="li_menu li_registration">
				<a class="a_registration" href="https://thebank.vn/dang-ky-tu-van-mien-phi.html">
					<p><i class="icon_regism"></i> <span>FREE</span></p>
					<span>Gửi yêu cầu tư vấn</span>
				</a>
			</li>
			<li class="li_menu li_meeting">
				<a href="https://thebank.vn/dang-ky-tai-khoan-vip.html">
					<i class="icon_vip"></i>
					<span>VIP</span>
				</a>
			</li>
            <li class="li_menu li_newfeed ">
				<a rel="nofollow" href="https://thebank.vn/buyer.html" class="check_login">
					<i class="icon_bangtin"></i>
					<span>Bảng tin</span>
				</a>
			</li>
            <li class="li_menu li_notification ">
				<a rel="nofollow" href="/thong-bao.html" class="check_login">
					<i class="icon_infom"></i>
					<span class="counter count_noti"></span>
					<span>Thông báo</span>
				</a>
			</li>
			<li class="li_menu li_message">
				<a rel="nofollow" href="https://thebank.vn/chat.html" class="check_login">
					<i class="icon_chatm"></i>
					<i class="counter count_sms not_read_0" data-count="0">0</i>
					<span>Chat</span>
				</a>
			</li>			
		</ul>
	</div>
	
</div>