<link rel="stylesheet" href="/stores/css/estimate.css" type="text/css">

<script src="/stores/js/tool/estimate/polyfills.js"></script>
<script src="/stores/js/tool/estimate/jquery.rangeslider.js"></script>
<script src="/stores/js/tool/estimate/rangeslider.js"></script>
<script src="/stores/js/tool/estimate/global-config.js"></script>
<script src="/stores/js/tool/estimate/estimate.js"></script>
<script src="/stores/js/tool/estimate/saving-cal-personal.js"></script>
<script src="/stores/js/tool/estimate/caculator.js"></script>
<script type='text/javascript' src="/stores/js/tool/estimate/loan-calculator.js"></script>
<script type='text/javascript' src="/stores/js/tool/input.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>



<style type="text/css">
.btn-show-breakdown {
    color: #27aae1;
    float: left;
    font-family: roboto;
    font-size: 14px;
    font-weight: 400;
    margin: 10px 0 20px;
}
</style>
<div class="total">
    <div class="container">
        <div class="main_loan ">
            <div class="breadcrumbs" id="breadcrumbs_loan">
                <a href="https://thebank.vn">Trang chủ</a>
                <i></i>
                <a href="https://thebank.vn/cong-cu.html">Công cụ</a>
                <i></i>
                <span class="bread">Ước tính số tiền vay phải trả hàng tháng</span>
            </div>
            <div class="box-heading ">
                <div class="header_caculator">
                    <h1 class="title-main">CÔNG CỤ ƯỚC TÍNH SỐ TIỀN VAY PHẢI TRẢ HÀNG THÁNG</h1>
                    <p class="roboto-light descript_page">Công cụ tính toán lịch trả nợ vay cho cả 2 phương thức trả nợ
                        phổ
                        biến là trả theo dư nợ ban đầu và trả theo dư nợ giảm dần. Theo đó dựa vào số tiền vay, kỳ hạn
                        vay,
                        lãi suất bạn có thể xem ngay bảng tính số tiền phải trả hàng tháng cố định hoặc bảng tính số
                        tiền
                        trả hàng tháng giảm dần.</p>
                    <div class="bottom_content_page animated">
                        <section class="accordion-main alive  saving-account-landing saving-personal-calculator"
                            id="personal-loan-repayment">
                            <div class="saving-cal" data-name="saving-cal" data-type="personal">
                                <div class=" range-calculotor">
                                    <div class="div_left">
                                        <div class="value-label roboto-light">Số tiền vay</div>
                                        <input type="tel" class="value-current borrow-amount income"
                                            data-toggle="tooltip" data-placement="top" data-single="true" />
                                    </div>
                                    <div class="div_right calculator-container calculator-container-saving">
                                        <div class="calculator-wraper">
                                            <div class="range-container" data-name="input-deposit-amount-wrapper">
                                                <input type="range" value="1" min="10" max="5000000000" unit="VND"
                                                    million='true' data-name="input-deposit-amount" name="loan_amount"
                                                    data-placement="top" data-single="true"
                                                    data-have-tooltip="true" data-mt-max="true" />
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
                                        <div class="value-label roboto-light">Kỳ hạn vay</div>
                                        <input type="tel" class="value-current term"  />
                                    </div>
                                    <div class="div_right calculator-container">
                                        <div class="calculator-wraper">
                                            <div class="range-container range-loan-termh">
                                                <input class=" term" type="range" value="0" min="0"
                                                    data-name="input-deposit-term" data-value="0" max="25" unit="năm"
                                                    name='loan_term' data-mt-max="true">
                                                <div class="min-max-value">
                                                    <span class="min-value"></span>
                                                    <span class="max-value"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Lãi xuất -->
                                <div class="range-interest range-calculotor">
                                    <div class="div_left " id="lx">
                                        <div class="value-label roboto-light">Lãi suất</div>

                                        <input type="tel" id="interest" class="interest value-current number-input" data-value="0" autocomplete="off"
                                             data-suffix="%/năm" />
                                    </div>
                                    <p class=" d-none ">(*) Công cụ tính toán trên website chỉ mang tính chất tham khảo.
                                    </p>
                                </div>

                                <!-- phương thức trả nợ -->
                                <div class="range-interest range-calculotor">
                                    <div class="div_left " id="lx">
                                        <div class="value-label roboto-light">Phương thức trả nợ khoản vay</div>
                                    </div>
                                    <div class="div_right radio-wraper float-left">

                                        <label class="calculator-radio cd checked">
                                            <input style="display:none" type="radio" name="repaymentMethod"
                                                value="fixed" checked="true">
                                            <i class="sprite"></i>
                                            <span class="radio"></span>
                                            Số tiền trả hàng tháng cố định
                                        </label>
                                        <label class="calculator-radio gd">
                                            <input style="display:none" type="radio" name="repaymentMethod"
                                                value="regressive">
                                            <i class="sprite"></i>
                                            <span class="radio"></span>
                                            Số tiền trả hàng tháng giảm dần
                                        </label>
                                    </div>
                                </div>



                                <div class=" result_final info-block">
                                    <div class="calculator-info-result centered">
                                        <div class="info">
                                            Số tiền trả tháng đầu tiên tại lãi suất
                                            <span class="interest-first-pay"></span>
                                            <b class="d-none d-lg-block">:</b>
                                            <span class="value-info first-payment">0 VND</span>
                                        </div>
                                        <div class="info">
                                            <span class="roboto-light ">Tổng số tiền lãi phải trả</span>
                                            <b class="d-none d-lg-block">:</b>
                                            <span class="value-info total-interest">0 VND</span>
                                        </div>
                                        <div class="info">
                                            <span class="roboto-light ">Tổng số tiền phải trả</span>
                                            <b class="d-none d-lg-block">:</b>
                                            <span class="value-info total-payment">0 </span>
                                        </div>
                                        <div class="info ">
                                            <span class="btn-show-breakdown" data-toggle="modal"
                                                data-target="#modalCarLoanRepayment" style="cursor:pointer; ">Xem lịch
                                                trả
                                                nợ
                                                khoản vay</span>
                                        </div>
                                        <!-- modal -->
                                        <div id="modalCarLoanRepayment" class="modal fade" role="dialog">
                                            <div class="modal-dialog modal-xl">
                                                <!-- Modal content-->
                                                <div class="modal-content range-calculotor">
                                                    <div class="modal-header">
                                                        <button type="button" style="position: static;margin-right:0"
                                                            class="close" data-dismiss="modal">×</button>
                                                        <h4 id="modal-title" class="modal-title align_center"></h4>
                                                        <h4 id="modal-titles" class="modal-title align_center"></h4>

                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr class="d-none d-lg-flex">
                                                                    <th>Năm</th>
                                                                    <th>Dư nợ còn lại</th>
                                                                    <th>Số tiền gốc <br />trả hàng tháng</th>
                                                                    <th>Tiền lãi <br /> trả hàng tháng</th>
                                                                    <th>Tổng tiền <br /> trả hàng tháng</th>
                                                                </tr>

                                                                <tr class="d-flex d-lg-none">
                                                                    <th>Năm</th>
                                                                    <th>Dư nợ còn lại</th>
                                                                    <th>Số tiền gốc trả hàng tháng</th>
                                                                    <th>Tiền lãi trả hàng tháng</th>
                                                                    <th>Tổng tiền trả hàng tháng</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <div class="modal-accordion">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <h3 class="d-none">Đăng nhập</h3>
                                    </div>
                                    <p class="note_rate d-none d-lg-block">(*) Công cụ tính toán trên website chỉ mang
                                        tính chất tham khảo.</p>
                                </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
$(document).ready(function() {

    // $('.value-current').focus(function(){
    //     // console.log(12121);
    // 	$(this).attr('data-value','');
    // 	$(this).attr('value','12');
    // });

    $('body').on('click', '.accordion-title', function() {
        if (onclick) {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }

    });
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
    $(".interest").inputFilter(function(value) {
        return /^(?!,)[0-9]{0,2}[,]?[0]{0,1}[1-9]{0,2}$/.test(value);
    });
    $(".number-input").inputFilter(function(value) {
        return /^(?!\,)\d*[,]?\d*$/.test(value);
    });

});
</script>