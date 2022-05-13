$(document).ready(function () {
    
    $(".number-input").filter(function(value) {
        return /^(?!\,)\d*[,]?\d*$/.test(value); });

    var position = $(window).scrollTop();
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll > position) {
            $('.left-push').addClass('fixed-sb');
        }
        position = scroll;
        if (position == 0) {
            $('.left-push').removeClass('fixed-sb');
        }
    });

    $('.clickshow').on('click', function () {
        $(this).parents('.item').find('ul').slideToggle();
        let _i = $(this).find('i');
        if ($(this).find('i').hasClass('fa-minus')) {
            _i.removeClass('fa-minus');
            _i.addClass('fa-plus');
        } else {
            _i.removeClass('fa-plus');
            _i.addClass('fa-minus');
        }
    });

    var tab = '#personal-loan-borrow';
    var url = window.location.hash; //get url
    if (url != '') {
        var arr = url.split('#');
        if (arr.length == 2) {
            if (typeof arr[1] != 'undefined' && arr[1] != '') {
                tab = '#' + arr[1];
            }
        }
    }
    $('.list_tool_menu .sprite.child_tool_7').parent().parent().addClass('tool_active');
    //gửi ajax check url và lưu vào sitemap
    var url = window.location.href;
    $.ajax({
        type: 'POST',
        url: "/ajax/saveSitemapThebank",
        data: { url: url, type: 3 },
        success: function (res) {

        }
    });
});
var PERSONAL_LOAN_CAL_DATA = {
    config: {
        single: true,
        business: false,
        sign: 'VND',
        lang: 'vi'
    },
    data: [{
        id: 'prod_personal1_1m',
        name: 'Loan secured by valuable paper (term < 12 month)',
        borrow: {
            monthly_income: {
                min: 0,
                max: 300000000,
                unit: 'VND',
                step: 1000,
                value: 0
            },
            monthly_expenses: {
                min: 0,
                max: 300000000,
                unit: 'VND',
                step: 1000,
                value: 0
            },
            loan_term: { // months
                min: 0,
                max: 25,
                step: 1,
                value: 0
            }
        },
        repayment: {
            borrow_amount: {
                min: 0,
                max: 5000000000,
                unit: 'VND',
                step: 1,
                value: 0
            },
            loan_term: {
                min: 0,
                max: 25,
                step: 1,
                value: 0
            }
        }
    }]
}

var SAVING_ACCOUNT_CAL_DATA = {
    config: {
        lang: 'vi',
        depositAmount1: 500000000, // 500,000,000
        depositAmount2: 2000000000, // 2,000,000,000
    },
    data: [{
        type: 'VND',
        sign: 'VND',
        offsetValue: 1,
        offsetName: '',
        step: 1,
        depositRule: {
            min: 0,
            max: 5000000000
        }

    }]
}




