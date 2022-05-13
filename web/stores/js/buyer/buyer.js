$(document).ready(function(){
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
	sort            = 'top_sp';
	$('.li_btn').click(function() {
		if(sort != $(this).attr('id')){
			sort = $(this).attr('id');
			ajax_filter(getDataInput(),1);
		}

		$('.li_btn').removeClass('li_selected');
		$(this).addClass('li_selected');

		var value_li = $(this).html();
		$('.select_sort').html(value_li);

		$('.ul_dropdown').removeClass('dropdown_block');
		$('.ul_dropdown').addClass('dropdown_hidden');
	});	
    $('#province').change(function(){
        var province = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/share/getdistrict',
            data: {province: province},
            success: function(res){
                var data = JSON.parse(res);
                var district = '<option value="">Chọn Quận/Huyện</option>';
                $.each(data,function(key,val){
                    district += '<option value="'+ val['id'] +'">'+ val['district_name'] +'</option>'
                });
                $('#district').html(district);
				$('#district').html(district).trigger('chosen:updated');
            }
        });
    });
	var page = 1;
	$('.see_more_page').click(function(){
		page	= page + 1;
		ajax_filter(getDataInput(),page);
	});
    $('.filter select').change(function(){
        ajax_filter(getDataInput(),1);
    });

	sort            = 'top_sp';
	$('.sort_data li').click(function(){
		if(sort != $(this).attr('id')){
			$('.sp_sort .order span').html($(this).html());
			sort = $(this).attr('id');
			ajax_filter(getDataInput(),1);
		}
	});   
	$('.button_search_name').click(function(e)
	{
		var input_search = $.trim($("#input_search").val());
		if( input_search.length >= 2 )
			ajax_filter(getDataInput(),1);
	});	
	$('#input_search').on('keyup',function(e)
	{
		if (event.key === "Enter") {
			var input_search = $.trim($("#input_search").val());
			if( input_search.length >= 2 )
				ajax_filter(getDataInput(),1);
		}
	});	
	var modal = $('.modal');
	var span = $('.close');
	$('body').on('click','.button_advise',function() {
		var name_user = $(this).attr('dtname');
		$('.content_opening strong').html(name_user);
		modal.show();
	});
	span.click(function() {
		modal.hide();
	});
	$(window).on('click', function(e) {
		if ($(e.target).is('.modal')) {
			modal.hide();
		}
	});

	$('#content_button').on('click', function(e) {
		var error = false;
		var content = $('.content_textarea').val().trim();
		if (content == '') {
			$('.error_content').html('Vui lòng nhập nội dung câu hỏi!')
			error = true;
		} else if (content.length < 10) {
			$('.error_content').html('Nội dụng câu hỏi phải nhiều hơn 10 ký tự');
			error = true;
		} else {
			$('.error_content').html('');
		}

		var checked = $('.content_checkbox').is(':checked') ? 1 : 0;
		if (checked == 0) {
			$('.error_checkbox').html('Bạn chưa đồng ý với chúng tôi!');
			error = true;
		}
		if (checked == 1) {
			$('.error_checkbox').html('');
		}

		if (error == false) {
			modal.hide();
			var name_supp = $(this).parent().find('strong').text();
			$('.content_textarea').val('');
			$('.alert-success').html('Yêu cầu tư vấn của bạn đã được gửi đến chuyên gia tư vấn ' + name_supp).fadeIn();
			setTimeout(function(){
				$('.alert-success').fadeOut();
			},2000);
		}
	});	
});

function getDataInput(){
	var url = '/chuyen-gia-tai-chinh.html';
	var title = '';
	var input_search= $.trim($("#input_search").val());
	var service     = $("#service").val();
	var province 	= $('#province').val();
	var district 	= $('#district').val();
	var year 		= $('#year_experience').val();
	var company 	= $('#company').val();
	var level 		= $('#level').val();
	var action		= $('#action').val();
	var status		= $('#status').val();
	var type 		= 0;

	var title_province = '';
	if(province == 32 ||province == 36 ||province == 35 ||province == 33 ||province == 34 )
	{
		title_province = '-thanh-pho-';
	}else{
		title_province = '-tinh-';
	}

	var sl_service = $('#service option:selected').attr('value');
	var sl_province = $('#province option:selected').attr('value');
	var sl_company = $('#company option:selected').attr('value');
	var sl_district = $('#district option:selected').attr('value');

	var name_service= $('#service option:selected').text();
	var name_province = $('#province option:selected').text();
	var name_company= $('#company option:selected').text();
	var name_district= $('#district option:selected').text();

	if(sl_service != '')
	{
		url					= '/chuyen-gia-tai-chinh/tu-van-' + removeUnicode(name_service) + '-' + service   + '.html';

	}
	if(sl_company != '')
	{
		url					= '/chuyen-gia-tai-chinh/to-chuc-' + removeUnicode(name_company) + '-' + company   + '.html';
	}
	if(sl_service != '' && sl_province != '')
	{
		url					= '/chuyen-gia-tai-chinh/tu-van-' + removeUnicode(name_service) + '-' + service   + title_province + removeUnicode(name_province) + '-' + province + '.html';
	}
	if(sl_service != '' && sl_company != '')
	{
		url					= '/chuyen-gia-tai-chinh/tu-van-' + removeUnicode(name_service) + '-' + service   + '/to-chuc-' + removeUnicode(name_company) + '-' + company + '.html';
	}
	if(sl_company != '' && sl_province != '')
	{
		url					= '/chuyen-gia-tai-chinh/to-chuc-' + removeUnicode(name_company) + '-' + company   + title_province + removeUnicode(name_province) + '-' + province + '.html';
	}
	if(sl_service != '' && sl_company != '' &&  sl_province != '')
	{
		url					= '/chuyen-gia-tai-chinh/tu-van-' + removeUnicode(name_service) + '-' + service   + '/to-chuc-' + removeUnicode(name_company) + '-' + company +  title_province + removeUnicode(name_province) + '-' + province + '.html';
	}
	if(sl_service != '' && sl_company != '' &&  sl_province != '' && sl_district != '')
	{
		url					= '/chuyen-gia-tai-chinh/tu-van-' + removeUnicode(name_service) + '-' + service   + '/to-chuc-' + removeUnicode(name_company) + '-' + company + '-tai-' + removeUnicode(name_district) + '-' + district + title_province + removeUnicode(name_province) + '-' + province + '.html';
	}

	if( $('select#type').length > 0 ){
		type		= $('#type').val();
	}
	if (typeof (history.pushState) != "undefined") {

		var obj = { Title: title, Url: url };
		history.pushState(obj, obj.Title, obj.Url);
	}

	return {input : input_search , service: service , province : province , district : district, year : year , company : company , level : level , status : status , sort : sort, action : action, type : type, name_service : name_service, name_province : name_province, name_company : name_company};
};
function ajax_filter(data, page)
{
	$('.loading_data').show();
	if( page == '' || page == 0 )
		page = 1;
	data['page'] = page;
	$.ajax({
		type : 'POST',
		url  : '/ajax/filter-supplier',
		data : data,
		success :function(respone){
			$('.loading_data').hide();
			var arr   = $.parseJSON(respone);
			var rendered = '';
			if(arr['data'] != undefined) {
				let tmpl = $('#template_supplier').html();

				var see_more = false;
				$.each(arr['data'], function(key, val) {
					if(val['see_more'] == true)
						see_more = true;

					rendered += Mustache.render(tmpl, val);
				});
				if(!see_more)
					$(".list").html(rendered);
				else 
					$(".list").append(rendered);

				$('.title_consultant').html(arr['title']);
				if(arr['ofset'] == ''){
					$('.see_more_page,.see_more').hide();
				}else{
					$('.see_more_page,.see_more').show();
				}
			}else {
				$('.see_more_page,.see_more').hide();
				if(page == 1)
					$(".list").html('<p class="empty_supp">Không tìm thấy chuyên gia nào.</p>');
			}
		}
	});
};