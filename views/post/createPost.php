<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = 'Trở Thành Người Đóng Góp';
// $this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="/stores/css/post.css" type="text/css">
<script src="/stores/js/tinymce/tiny.min.js"></script>
<script src="/stores/js/tinymce/langs/vi_VN.js"></script>
<script src="/stores/js/post/post.js"></script>
<script src="/stores/js/bootstrap.min.js"></script>

<div class="content ">
    <!-- banner -->
    <div class="banner mt-0">
        <div class="container">
            <div class="breadcrumb_post">
                <a href="https://thebank.vn">Trang chủ</a>
                <i></i>
                <span>Trang bài viết</span>
            </div>
            <h1 class="title-banner">Trở thành người đóng góp</h1>
            <p class="title-content">TheBank hoan nghênh những bài viết chia sẻ thông điệp hoặc truyền cảm hứng của bạn
            </p>
        </div>
    </div>
    <!-- content -->
    <div class=" container">
        <div class=" box-item">
            <div class="info-author">
                <h2>Thông tin tác giả</h1>
            </div>
            <!-- Thông tin tác giả -->
            <form action="" method="POST" enctype="multipart/form-data" id="form_create_post">
                <div class="border-box row">
                    <div class=" col-lg-3 col-12 p-0">
                        <div class="box-avatar">
                            <div class="avatar ">
                                <div class="set-avatar">
                                    <img    src="/stores/images/post/avartar_author.png" class="img-avatar"
                                        id="image_avatar2" alt="" name="image_avatar2" />
                                </div>

                            </div>
                            <div class="upload-image">
                                <div class="py-2">
                                    <p>Tải ảnh</p>
                                    <input type="file" onchange="readURLPost(this)" id="image_avatar" data-type="image"
                                        accept="image/jpg,image/png,image/jpeg" name="image_avatar">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-form col-lg-8 col-12">
                        <div class="form-group">
                            <label for="">Họ và tên
                                <span style="color:#FF0000"> *
                                </span>
                            </label>
                            <input type="text" class="input-control" id="name">
                            <span class="message_name"></span>
                        </div>
                        <div class="groups">
                            <div class="group-input ">
                                <label for="">Email
                                    <span style="color:#FF0000"> *
                                    </span>
                                </label>
                                <input type="text" id="email">
                                <span class="message_email"></span>
                            </div>
                            <div class="group-input">
                                <label for="">Số điện thoại
                                    <span style="color:#FF0000"> *
                                    </span>
                                </label>
                                <input type="number" id="phone">
                                <span class="message_phone"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Giới thiệu tác giả -->
                <div class="info-author">
                    <div style="padding-bottom: 12px;">
                        <h2>Giới thiệu về tác giả</h2>
                    </div>
                    <div class="word-author">
                        <textarea class="context-menu" name="introduce_author"></textarea>
                    </div>
                    <div class="text-account">
                        <p style="margin-top: 26px">Bạn đã có tài khoản?
                            <a href="https://thebank.vn/dang-nhap.html" class="login_link" target="_blank" style="margin-left: 10px;">
                                Đăng nhập ngay!
                            </a>
                        </p>
                    </div>
                </div>
                <!-- Thông tin bài viết -->
                <div class="form-infomation">
                    <div class="info-author">
                        <h2>Thông tin bài viết</h2>
                    </div>
                    <div class="form-group-info">
                        <label for="">Tiêu đề bài viết
                            <span style="color:#FF0000"> *
                            </span>
                        </label>
                        <input type="text" id="title_post" name="title_post">
                        <span class="message_title_post"></span>
                    </div>
                    <div class="form-group-info">
                        <label for="">Mô tả bài viết
                            <span style="color:#FF0000"> *
                            </span>
                        </label>
                        <textarea name="post_description" id="post_description" cols="30" rows="10"></textarea>
                        <span class="message_post_description"></span>

                    </div>
                    <div class="form-group-info">
                        <label for="" style="margin-bottom:27px">Nội dung bài viết
                            <span style="color:#FF0000"> *
                            </span></label>
                        <textarea class="context-menu" id="content_post"></textarea>
                        <span class="message_content_post" onfocus="myFunction(this)"></span>
                    </div>
                </div>

                <div class="group-image ">
                    <div class="row">
                        <div class=" col-lg-12 col-12 flex ">
                            <div class="col-lg-4 col-6 float-right box-1 p-0">
                                <div class="box b-1">
                                    <div class="js--image-preview">
                                        <img    alt="" id="files" class="im_post1" width="100%" height="100%">
                                    </div>
                                    <div class="upload-options">
                                        <label>
                                            <span>
                                                <img    src="/stores/images/post/Vector.png" alt="" width="22px"
                                                    height="21px">
                                            </span>
                                            <span> Ảnh </span>
                                            <input type="file" accept="image/jpg,image/png,image/jpeg" id="image_post1" 
                                                onchange="readURLPost1(this)" class="image-upload">
                                        </label>

                                    </div>
                                    <span class="message_image"> </span>

                                </div>

                            </div>
                            <div class="col-lg-4 col-6 float-right box-1 p-0">
                                <div class="box b-2">
                                    <div class="js--image-preview">
                                        <img    id="" class="im_post2" width="100%" height="100%">
                                    </div>
                                    <div class="upload-options">
                                        <label>
                                            <span>
                                                <img    src="/stores/images/post/Vector.png" alt="" width="22px"
                                                    height="21px" name="fileUpload">
                                            </span>
                                            <span>
                                                Ảnh
                                            </span>
                                            <input type="file" accept="image/jpg,image/png,image/jpeg" id="image_post2" data-type='image' 
                                                onchange="readURLPost2(this)" class="image-upload" name="fileUpload">
                                        </label>
                                        <span>

                                        </span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-9 col-12 float-right rq-image">
                                <span>* Ảnh định dạng JPG, PNG, JPEG < 150kb</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- checkbox -->

                <div class="gr-send-form row ml-0">
                    <div class="col-lg-6 col-12 py-2 px-0">
                        <div class="d-flex div_question">
                            <input type="checkbox" id="myCheck" style="width: 25px; height:22px" class="check-box">
                            <p>Tôi đồng ý với
                                <a href="https://thebank.vn/tro-giup/chinh-sach-bao-mat.html">Điều khoản dịch vụ</a>
                                và
                                <a href="https://thebank.vn/quy-dinh-thanh-vien.html">Quy định thành viên</a>
                            </p>
                        </div>
                        <span class="error_checkbox">
                            Bạn chưa đồng ý với điều khoản của chúng tôi
                        </span>
                    </div>
                    <div class="gr-submit col-lg-4 col-12">
                        <button type="button" id="myModal" class="btn-elem submit">
                            <p>
                                Gửi bài viết
                            </p>
                        </button>
                    </div>
                </div>
            </form>
            <!-- title tutorial -->
            <div class="tutorial">
                <div class="bor-h1">
                    <h2 class="tutorial-h1">
                        <strong>
                            Hướng dẫn gửi bài viết
                        </strong>
                    </h2>
                </div>
                <!-- text tutorial -->

                <div class="text-tutorial">
                    <ul>
                        <li><strong>- Chủ đề nội dung:</strong> Chúng tôi hoan nghênh các bài viết liên quan đến chủ đề
                            bảo
                            hiểm, tài chính
                            ngân
                            hàng, đầu tư, chứng khoán, kinh doanh, tiết kiệm, vàng, tỷ giá, con người, sức khỏe...
                        </li>
                        <li><strong>- Nội dung gốc:</strong> Bài viết bao gồm tiêu đề, mô tả, nội dung được gửi cho
                            chúng
                            tôi là duy nhất.
                            Chúng
                            tôi không chấp thuận bài viết đã được đăng tải ở bất kỳ đâu hoặc bạn có ý định phân phối đến
                            nơi
                            khác.</li>
                        <li>
                            <strong>- Số lượng từ trong bài viết:</strong> Tối thiểu 700 từ
                        </li>
                        <li><strong>- Giọng điệu và ngôn ngữ:</strong> Giọng điệu tích cực, ngôn ngữ đơn giản</li>
                        <li><strong>- Ảnh trong bài viết:</strong> Kích thước tối thiểu: chiều dài 800pixel x chiều cao
                            500
                            pixel. Kích thước
                            tối
                            đa: Chiều dài 1200pixel x chiều cao 800 pixel. Dung lượng ảnh tối đa 150KB</li>
                        <li>
                            <strong>- Thời gian phản hồi:</strong> Nếu bài viết được duyệt, chúng tôi sẽ trả lời cho bạn
                            qua
                            email trong vòng
                            7
                            ngày làm việc. Nếu bạn không nhận được phản hồi của chúng tôi trong vòng 7 ngày làm việc,
                            bạn có
                            thể
                            đăng ở nơi khác.
                        </li>
                        <li><strong>- Bài viết theo hướng quảng cáo:</strong> Chúng tôi không chấp thuận các bài viết có
                            chèn liên kết với
                            mục
                            đích quảng cáo.</li>
                        <li>

                            <strong>- Hình thức cộng tác:</strong> Hai bên hợp tác cùng có lợi. Chúng tôi không trả tiền
                            cho
                            những người gửi
                            bài
                            viết, nhưng chúng tôi cung cấp trang thông tin tác giả với nội dung giới thiệu về tác giả
                            kèm
                            theo
                            tất cả các bài viết mà tác giả đã đóng góp.
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- modal -->
<div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="myModalLabel" style="margin:0 auto">Thông báo</h3>
            </div>
            <div class="modal-body">
                Bài viết của bạn đã gửi thành công !
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Đóng</button>
            </div>
        </div>
    </div>
</div>
