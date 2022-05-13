<?php 
use Yii;
Yii::$app->controller->enableCsrfValidation = false;

?>
<link rel="stylesheet" href="/stores/css/tool.css" type="text/css" />
<script>
    var SAVING_ACCOUNT_CAL_DATA = {
        config: {
            lang: 'vi',
            depositAmount1: 500000000,	// 500,000,000
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
                max: 10000000000
            }
            
        }]
    }

</script> 
<div class="main_tb">
        <div class="breadcrumbs">
            <a href="https://thebank.vn">Trang chủ</a>
            <i></i>
            <a href="https://thebank.vn/cong-cu.html">Công cụ</a>
            <i></i>
            <span>Tính lãi tiết kiệm cá nhân</span>
        </div>
        <div class="box-heading">
			<div class="header_caculator">
				<h1 class="title-main">Công cụ tính lãi tiết kiệm cá nhân</h1>
				<p class="roboto-light descript_page">Tính ngay được số tiền lãi nhận được khi gửi tiết kiệm có kỳ hạn tại ngân hàng với số tiền gốc, kỳ hạn gửi và lãi suất tại thời điểm gửi.</p>
				<div class="bottom_content_page animated">
					<section class="accordion-main alive  saving-account-landing saving-personal-calculator">
                        <div class="saving-cal" data-name="saving-cal" data-type="personal">
                            <div class=" range-calculotor">
                                <div class="div_left">
                                    <div class="value-label roboto-light">Số tiền gốc</div>
                                    <input type="tel" class="value-current amount_input" pattern="amount" data-toggle="tooltip" data-placement="top" title="Nhập giá trị" data-single="true"/>
                                </div>
                                <div class="div_right calculator-container calculator-container-saving">
                                    <div class="calculator-wraper">
                                        <div class="range-container" data-name="input-deposit-amount-wrapper">
                                            <input type="range" value="1" min="10" max="100000000000" unit="VND" million='true' data-name="input-deposit-amount" data-placement="top" title="Chọn giá trị" data-single="true" data-have-tooltip="true" data-mt-max="true"/>
                                            <div class="min-max-value">
                                                <span class="min-value"></span>
                                                <span class="max-value"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="range-calculotor">
                                <div class="div_left">
                                    <div class="value-label roboto-light">Kỳ hạn gửi</div>
                                    <input type="tel" class="value-current term" pattern="integer"/>
                                </div>
                                <div class="div_right calculator-container">
                                    <div class="calculator-wraper">
                                        <div class="range-container range-loan-termh">
                                            <input class="range-car-loan" type="range" value="1" min="1" data-name="input-deposit-term" data-value="0" max="60" unit="tháng" name='loan_term' data-mt-max="true">
                                            <div class="min-max-value">
                                                <span class="min-value"></span>
                                                <span class="max-value"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="range-interest">
                                <div class="div_left">
                                    <div class="value-label roboto-light">Lãi suất</div>
                                    <input type="tel" id="interest" class="interest value-current number-input" value="0%/năm" data-value="" data-suffix="%/năm" pattern="amount"/>
                                </div>
                                <p class="note_rate d-block d-lg-none">(*) Công cụ tính toán trên website chỉ mang tính chất tham khảo.</p>
                                <div class="div_right result_final info-block">
                                    <div class="calculator-info-result centered">
                                        <div>
                                            <span class="roboto-light">Tổng số tiền cuối kỳ</span> <b class="d-none d-lg-block">:</b> 
                                            <span class="value-info" data-name="total-balance">0 VND</span>
                                        </div>
                                        <div>
                                            <span class="roboto-light">Số tiền lãi</span> <b class="d-none d-lg-block">:</b> 
                                            <span class="value-info" data-name="interest-earned">0</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="note_rate d-none d-lg-block">(*) Công cụ tính toán trên website chỉ mang tính chất tham khảo.</p>
                            </div>
                        </div>
					</section>
				</div>
			</div>
		</div>
</div>


<!-- <script src="/stores/js/tool/rangeslider.min.js"></script> -->
<script src="/stores/js/tool/polyfills.js"></script>
<script src="/stores/js/tool/jquery.rangeslider.js"></script>
<script src="/stores/js/tool/rangeslider.js"></script>
<script src="/stores/js/tool/global-config.js"></script>
<script src="/stores/js/tool/saving-cal-personal.js"></script>  

<script>
    $(document).ready(function(){
        var url      = window.location.href;   
        $('.value-info').click(function(){
            var data = $(this).html();
            $.ajax({
                type: "POST",
                url: url,
                data: {data:data},
                async: false,
                success: function(res) {

                }

            });
        });
        // $('.amount_input').focusout(function(){
        //     var value = $('.amount_input').attr('data-value');
        //     if(value < 1000) {
        //         $('.amount_input').attr("data-value","1000")
        //     }
        //     console.log(value);
        // });
            (function($) {
                $.fn.inputFilters = function(inputFilters) {
                    return this.on("input keydown", function() {
                    if (inputFilters(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                    });
                };
            }(jQuery));
            // Install input filters.
            $(".amount_input").inputFilters(function(value) {
            return /^[0-9]*\.?[0-9]*$/.test(value); });        

            (function($) {
                $.fn.inputFilter2 = function(inputFilter2) {
                    return this.on("input keydown", function() {
                    if (inputFilter2(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                    });
                };
            }(jQuery));
            // Install input filters.
            $(".term").inputFilter2(function(value) {
            return /^[0-9]*?[0-9]*$/.test(value); });   

            
            (function($) {
                $.fn.inputFilter = function(inputFilter) {
                    return this.on("input keydown", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                    });
                };
            }(jQuery));
            // Install input filters.
            $(".number-input").inputFilter(function(value) {
            return /^(?!\,)-?\d*[,]?\d*$/.test(value); });        

            $('.value-current').focus(function(){
                if($(this).val() == 0) {
                    $(this).val("");     
                }
            });
    });
</script>