/**
 * Calculator script
 */

var TheBank = TheBank || {};

$(function () {
    'use strict';

    var PMT = function (ir, np, pv, fv) {
        if (!fv) { fv = 0; }
        var pmt = (ir * (pv * Math.pow((ir + 1), np) + fv)) / ((Math.pow((ir + 1), np) - 1));
        return pmt;
    };

    //Tiền lãi kì 1 = Số tiền vay * lãi suất/12
    var calculatorInterest = function (borrow, interestRate, day) {
        // var interest = borrow * interestRate * day / 30;
        var interest = borrow * interestRate / 12;
        // console.log('borrow : ' + borrow);
        // console.log('interestRate : ' + interestRate);
        // console.log('thasng1 : ' + interest);
        return interest;
    };

    var dateOfMonth = function (day, month, year) {
        var monthDay;
        var leapYear = false;
        //check leap year
        year = parseInt(year);
        if (year / 100) {
            if (year % 4 === 0 || year % 400 === 0) {
                leapYear = true;
            }
        }
        ///return date in month
        if (month === 2) {
            if (leapYear) {
                monthDay = 29;
            } else {
                monthDay = 28;
            }
        } else if (month === 4 || month === 6 || month === 9 || month === 11) {
            monthDay = 30;
        } else {
            monthDay = 31;
        }//1,3,5,7,8,10,12
        return monthDay;
    };

    //co dinh
    var calculatorFixed = function (borrow, term, interestRate, currency) {
        var interestRateMonth = interestRate / 12;
        var ending;
        //get current day, month, year for calculator
        var today = new Date();
        var day = today.getDate();
        var month = today.getMonth() + 1;
        var year = today.getFullYear();
        ///
        var principal, meta = [], data = {}, dateMonth, interest;
        // Tiền gốc hàng tháng
        // Tiền gốc trả kỳ 1 =  Tổng tiền trả kỳ 1 - Tiền lãi trả kỳ 1
        var monthlyPayment = PMT(interestRateMonth, term, borrow);//PMT( 0.071/12, 36, 1000000000);

        var total_money = borrow;

        //[Số tiền vay * lãi suất/12 * (1+lãi suất/12)^(kỳ hạn vay * 12)] / [(1+lãi suất/12)^(n * 12) – 1]
        var totalInterest = 0;
        var totalPayment = monthlyPayment * (term - 1);
        var firstPayment;
        var totals = monthlyPayment;

        if (term && term<=300 ) {

            
            for (var i = 0; i < term; i++) {
                var obj = {};
                //calculator date of month
                if (i) {
                    month = month === 12 ? 1 : month + 1;
                }
                if (i && month === 1) {
                    year += 1;
                }
                dateMonth = dateOfMonth(day, month, year);

                if (i === 0) {
                    firstPayment = totals;
                }
                ///Beginning Balance
                if (i) {
                    borrow = ending; //du no con lai
                    ending = ending - monthlyPayment;

                } else {
                    ending = borrow;
                }
                // interest =  Math.ceil(interest.toFixed(8));

                // Tiền lãi kì 1
                interest = calculatorInterest(borrow, interestRate, dateMonth);
                // Tiền lãi kì tiếp theo
                if (i) {
                    interest = calculatorInterest(ending, interestRate, dateMonth);
                }
                totalInterest += interest;

                monthlyPayment = totals - interest;
                

                // principal
                principal = monthlyPayment - interest;//tien goc tra hang thang - tien lai tra hang thang

                // Số tiền gốc
                if (i === term - 1) {
                    // monthlyPayment = interest + borrow;
                    principal = monthlyPayment - interest;
                    totalPayment = totalInterest + total_money;
                    // ending = 0;
                }
                
                // create an object for result
                obj.monthlyPayment = parseInt(monthlyPayment.toFixed(0));
                obj.ending = parseInt(ending.toFixed(0));
                obj.principal = parseInt(principal.toFixed(0));
                obj.interest = parseInt(interest.toFixed(0));
                obj.borrow = parseInt(borrow.toFixed(0));
                obj.totals = parseInt(totals.toFixed(0));
                meta.push(obj);
            }

            data.totalPayment = parseInt(totalPayment.toFixed(0));
            data.totalInterest = parseInt(totalInterest.toFixed(0));
            data.firstPayment = parseInt(firstPayment.toFixed(0));
            data.meta = meta;
        } else {
            data.totalPayment = 0;
            data.totalInterest = 0;
            data.firstPayment = 0;
            data.meta = 0;
        }

        return data;
    };
    //giam dan
    var calculatorRegressive = function (borrow, term, interestRate, currency) {
        // console.log(borrow, term, interestRate, currency);
        var interestRateMonth = interestRate / 12;

        //get current day, month, year for calculator
        var today = new Date();
        var day = today.getDate();
        var month = today.getMonth() + 1;
        var year = today.getFullYear();
        //
        var principal, meta = [], data = {}, dateMonth, interest;

        var ending;

        var totalInterest = 0;
        var totalPayment = 0;

        //Số tiền gốc trả hàng tháng
        var monthlyPayment = borrow / (term);
        var firstPayment;//=  tháng đầu tiên;
        var totals;

        principal = borrow / term; //Tiền gốc trả hàng tháng
        currency = currency || '';
        if (term && term<=300 ) {
            // principal = Math.ceil(principal / 10000) * 10000;
            if (currency.toLowerCase() === 'usd') {
                principal = Math.min(principal, 1);
            }
            for (var i = 0; i < term; i++) {
                var obj = {};
                //calculator date of month
                if (i) {
                    month = month === 12 ? 1 : month + 1;
                }
                if (i && month === 1) {
                    year += 1;
                }
                dateMonth = dateOfMonth(day, month, year);

                ///Beginning Balance
                if (i) {
                    //dư nợ
                    borrow = ending;
                    ending = ending - principal;
                } else {
                    ending = borrow;
                }

                //Tiền lãi trả kỳ 2 = Dư nợ còn lại kỳ 2 * lãi suất/12 = [Số tiền vay - Số tiền vay/(thời hạn vay * 12) *1]*lãi suất/12
                interest = calculatorInterest(borrow, interestRate, dateMonth);
                if (i) {
                    interest = calculatorInterest(ending, interestRate, dateMonth);
                }

                // if (i === term - 1) {
                //     principal = borrow > principal ? principal : borrow;
                //     monthlyPayment = interest + principal;
                //     ending = 0;
                // }

                if (ending < 0) {
                    monthlyPayment = 0;
                }

                totalInterest += interest;
                // Tong tiền trả hàng tháng
                totals = monthlyPayment + interest;

                // Số tiền trả hàng tháng
                if (i === 0) {
                    firstPayment = totals;
                }

                totalPayment += totals;
                // remove sub number
                monthlyPayment = Math.max(monthlyPayment, 0);
                firstPayment = Math.max(firstPayment, 0);
                ending = Math.max(ending, 0);
                principal = Math.max(principal, 0);
                interest = Math.max(interest, 0);
                totals = Math.max(totals, 0);
                // console.log('interest: ' + interest);

                // create an object for result
                obj.monthlyPayment = parseInt(monthlyPayment.toFixed(0));
                obj.ending = parseInt(ending.toFixed(0));
                obj.principal = parseInt(principal.toFixed(0));
                obj.interest = parseInt(interest.toFixed(0));
                obj.borrow = parseInt(borrow.toFixed(0));
                obj.firstPayment = parseInt(firstPayment.toFixed(0 ));
                obj.totals = parseInt(totals.toFixed(0));
                // console.log( obj.totals);

                meta.push(obj);
            }

            data.totalPayment = parseInt(totalPayment.toFixed(0));
            data.totalInterest = parseInt(totalInterest.toFixed(0));
            data.firstPayment = parseInt(firstPayment.toFixed(0));
            data.meta = meta;

        } else {
            data.totalPayment = 0;
            data.totalInterest = 0;
            data.firstPayment = 0 ;
            data.meta = 0;
        }
        return data;
    };
    TheBank.calculatorFixed = calculatorFixed;
    TheBank.calculatorRegressive = calculatorRegressive;
});








