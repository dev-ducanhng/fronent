// check box
var elems = document.querySelectorAll('.check-box');
var btn = document.querySelector('.btn-elem');
[].forEach.call(elems, function (el) {
    el.addEventListener('change', function () {
        var checked = document.querySelectorAll('.check-box:checked');
        if (checked.length) {
            btn.style.color = '#fff';
            btn.style.backgroundColor = '#1F9AD6';
        } else {
            btn.style.color = '#555555';
            btn.style.backgroundColor = '#E5E5E5';
        }
    });
});

// require

$(document).ready(function () {

    $('.submit').on('click', function (e) {
        var error = false;
        var position_scroll = "";

        var name = $('#name').val();

        if ($.trim($('#name').val()) == '') {
            error = true;
            $('#name').addClass('input_error');
            $('.message_name').html('Vui lòng nhập họ và tên');
            if (position_scroll == "")
                position_scroll = "#name";
        } else {
            $('#name').removeClass('input_error', 'message_name');
            $('.message_name').html('');
        }
        // email
        var email = $('#email').val();
        var emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (email == '') {
            error = true;
            $('#email').addClass('input_error');
            $('.message_email').html('Vui lòng nhập email');
            if (position_scroll == "")
                position_scroll = "#email";
        } else if (!emailRegex.test(email)) {
            error = true;
            $('#email').addClass('input_error');
            $('.message_email').html('Email chưa đúng định dạng');
            if (position_scroll == "")
                position_scroll = "#email";
        } else {
            $('#email').removeClass('input_error');
            $('.message_email').html('');
        }

        // phone
        var regexPhone = /^(84|0)(9\d{8}|8\d{8}|3\d{8}|5\d{8}|7\d{8})$/;
        var phone = $('#phone').val();
        if (phone == '') {
            error = true;
            $('#phone').addClass('input_error');
            $('.message_phone').html('Vui lòng nhập số điện thoại');
            if (position_scroll == "")
                position_scroll = "#phone";
        } else if (!regexPhone.test(phone)) {
            error = true;
            $('#phone').addClass('input_error');
            $('.message_phone').html('Số điện thoại chưa đúng định dạng');
            if (position_scroll == "")
                position_scroll = "#phone";
        } else {
            $('#phone').removeClass('input_error');
            $('.message_phone').html('');
        }
        // title post
        var title_post = $('#title_post').val();

        if ($.trim($('#title_post').val()) == '') {
            error = true;
            $('#title_post').addClass('input_error');
            $('.message_title_post').html('Vui lòng không để trống');
            if (position_scroll == "")
                position_scroll = "#title_post";
        } else {
            // $('#title_post').replace(/\s+/g,' ').trim();
            $('#title_post').removeClass('input_error');
            $('.message_title_post').html('');
        }
        // description post
        var post_description = $('#post_description').val();
        if ($.trim($('#post_description').val()) == '') {
            error = true;
            $('#post_description').addClass('input_error');
            $('.message_post_description').html('Vui lòng không để trống');
            if (position_scroll == "")
                position_scroll = "#post_description";
        } else {
            $('#post_description').removeClass('input_error');
            $('.message_post_description').html('');
        }
        // Content post
        patt = /^<p>(&nbsp;\s)+(&nbsp;)+<\/p>$/g;
        var content_post = $('#content_post').val();
        var textmsg = $.trim($(content_post).text());
        if ($.trim(textmsg) == '') {
            error = true;
            $('#content_post').addClass('input_error');
            $('.message_content_post').html('Vui lòng không để trống');
            if (position_scroll == "")
                position_scroll = "#content_post";
        } else {
            $('#content_post').removeClass('input_error');
            $('.message_content_post').html('');
        }

        $("#name").focus(function () {
            $('#name').removeClass('input_error', 'message_name');
            $('.message_name').html('');
        });
        $("#email").focus(function () {
            $('#email').removeClass('input_error', 'message_email');
            $('.message_email').html('');
        });
        $("#phone").focus(function () {
            $('#phone').removeClass('input_error', 'message_phone');
            $('.message_phone').html('');
        });
        $("#introduce_author").focus(function () {
            $('#introduce_author').removeClass('input_error', 'message_introduce_author');
            $('.message_introduce_author').html('');
        });
        $("#title_post").focus(function () {
            $('#title_post').removeClass('input_error', 'message_title_post');
            $('.message_title_post').html('');
        });
        $("#post_description").focus(function () {
            $('#post_description').removeClass('input_error', 'message_post_description');
            $('.message_post_description').html('');
        });
        $("#content_post").focus(function () {
            $('#content_post').removeClass('input_error', 'message_content_post');
            $('.message_content_post').html('');
        });

        // check điều khoản
        var accept = $('#myCheck').is(':checked') ? 1 : 0;
        if (accept == 0) {
            $('.error_checkbox').show();
            error = true;
        }
        if (accept == 1) {
            $('.error_checkbox').hide();
        }

        var image_avatar = $('#image_avatar').val();

        var files = $('#image_avatar')[0].files[0];
        if (image_avatar != '' && error == false) {
            var fd = new FormData();
            fd.append('file', files);
            $.ajax({
                url: '/post/upload-file-author',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('image_avatar').show();
                },
                success: function (response) {
                    if (response != 0) {
                        image_avatar = response;
                    }
                },
                complete: function () {
                    $('#image-avatar').hide()
                }
            });
        }

        //upload image 1


        image_post1 = $('#image_post1').val();

        if (image_post1 != '' && error == false) {
            var fd = new FormData();
            var files = $('#image_post1')[0].files[0];

            fd.append('file', files);
            $.ajax({
                url: '/post/upload-file-author',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {

                },
            });
        }

        //upload image 2

        var image_post2 = $('#image_post2').val();

        if (image_post2 != '' && error == false) {
            var fd = new FormData();
            var files = $('#image_post2')[0].files[0];
            fd.append('file', files);
            $.ajax({
                url: '/post/upload-file-author',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) { },
            });

        }
        console.log(error);
        if (error == false) {
            $("#myModal").modal("hide");
            $.ajax({
                type: 'POST',
                url: '/post/create',
                data: {
                    email: email,
                    phone: phone,
                    name: name,
                    title_post: title_post,
                    post_description: post_description,
                    content_post: content_post,
                    image_avatar: image_avatar,
                    image_post1: image_post1,
                    image_post2: image_post2

                },
                success: function (data) {

                    $('#form_create_post')[0].reset();
                    if (data == 1) {
                        console.log('');
                    } else {
                        // add content from another url
                        $("#myModal2 .modal-body").load(data);

                        // open the other modal
                        $("#myModal2").modal("show");
                    }
                }

            });

        } else {
            $('html, body').animate({
                scrollTop: ($(position_scroll).parent().offset().top - 120)
            }, 500);
        }


    });
    // tiny config
    var process_save;
    var t;

    function auto_save() {
        if (typeof process_save != 'undefined')
            process_save.abort();

        $('#content_post').val(tinyMCE.get('content_post').getContent());

    }

    function auto_saves() {
        if (typeof process_save != 'undefined')
            process_save.abort();

        $('#introduce_author').val(tinyMCE.get('introduce_author').getContent());
    }
});

function readURLPost(input) {
    var max_size_image = 360;
    if (input.files && input.files[0]) {
        var test_value = $("#image_avatar").val();
        var extension = test_value.split('.').pop().toLowerCase();
        var size_image = Math.round(input.files[0].size / 1024);
        if (size_image > max_size_image) {
            input.value = null;
            alert('Dung lượng tối đa ảnh đại diện là ' + max_size_image + 'KB');
            return false;
        } else if ($.inArray(extension, ['png', 'jpeg', 'jpg']) == -1) {
            input.value = null;
            alert('File không đúng định dạng');
        } else {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.img-avatar').attr('src', e.target.result).css({height:"100%"});
                $('.set-avatar').css({height:"100%"});
                
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
}

function readURLPost1(input) {
    var max_size_image = 150;
    if (input.files && input.files[0]) {
        var test_value = $("#image_post1").val();
        var extension = test_value.split('.').pop().toLowerCase();
        var size_image = Math.round(input.files[0].size / 1024);

        if (size_image > max_size_image) {
            input.value = null;
            alert('Dung lượng tối đa ảnh bài viết là ' + max_size_image + 'KB');

            return false;
        } else if ($.inArray(extension, ['png', 'jpeg', 'jpg']) == -1) {
            input.value = null;
            alert('File không đúng định dạng');
        }

        else {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.im_post1').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
}

function readURLPost2(input) {
    var max_size_image = 150;
    if (input.files && input.files[0]) {
        var test_value = $("#image_post2").val();
        var extension = test_value.split('.').pop().toLowerCase();
        var size_image = Math.round(input.files[0].size / 1024);
        if (size_image > max_size_image) {
            input.value = null;
            alert('Dung lượng tối đa ảnh bài viết là ' + max_size_image + 'KB');
            return false;
        } else if ($.inArray(extension, ['png', 'jpeg', 'jpg']) == -1) {
            input.value = null;
            alert('File không đúng định dạng');
        }
        else {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.im_post2').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
}

// tiny

tinymce.init({

    selector: 'textarea.context-menu',
    height: 400,
    language: 'vi_VN',
    plugins: [
        'link image table lists code',
        'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellcheckercode code link',
    ],
    fontsize_formats: "10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 20pt 22pt 24pt 36pt 48pt 72pt",
    toolbar: 'undo redo | fontselect |fontsizeselect | bold styleselect| forecolor | bold italic | alignleft aligncenter alignright alignjustify |bullist numlist outdent indent| backcolor',
    contextmenu: 'link image imagetools table spellchecker lists',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    branding: false,
    init_instance_callback: function (editor) {
        var freeTiny = document.querySelector('.tox .tox-notification--in');
        freeTiny.style.display = 'none';
    },
    spellchecker_language: 'en',

    setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
            chkSubmit();
        });
    }
});
