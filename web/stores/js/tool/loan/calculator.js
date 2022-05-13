/**
 * Calculator script
 */

 var TheBank = TheBank || {};

 $(function() {
     'use strict';
 
     var PMT = function(ir, np, pv, fv ) {
         if( ! fv ){ fv = 0; }
         var pmt = ( ir * ( pv * Math.pow ( (ir+1), np ) + fv ) ) / ( ( Math.pow ( (ir+1), np) -1 ) );
         return pmt;
     };
 
 
     var calculatorInterest = function(borrow, interestRate, day) {
         var interest = borrow*interestRate*day/30;
         return interest;
     };
 
     var dateOfMonth = function(day, month, year) {
         var monthDay;
         var leapYear = false;
         //check leap year
         year = parseInt(year);
         if(year/100) {
             if (year%4===0 || year%400===0) {
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
         } else{
             monthDay = 31;
         }//1,3,5,7,8,10,12
         return monthDay;
     };
 
     var calculatorFixed = function(borrow, term, interestRate) {
         var interestRateMonth = interestRate/12;
         var ending;
         //get current day, month, year for calculator
         var today = new Date();
         var day = today.getDate();
         var month = today.getMonth() + 1;
         var year = today.getFullYear();
         ///
         var principal, meta = [], data = {}, dateMonth, interest;
         ///calculator monthly payment
         var monthlyPayment = PMT(interestRateMonth, term, borrow);//PMT( 0.071/12, 36, 1000000000);
 
         var totalInterest = 0;
         var totalPayment = monthlyPayment * (term-1);
         var firstPayment = monthlyPayment;
 
         if(term) {
             for (var i=0; i<term; i++) {
                 var obj = {};
                 //calculator date of month
                 if(i) {
                     month = month===12?1:month+1;
                 }
                 if (i&&month===1) {
                     year += 1;
                 }
                 dateMonth = dateOfMonth(day, month, year);
                 //calculator interest
                 interest = calculatorInterest(borrow, interestRateMonth, dateMonth);
                 if(i) {
                     interest = calculatorInterest(ending, interestRateMonth, dateMonth);
                 }
                 // interest =  Math.ceil(interest.toFixed(8));
                 totalInterest += interest;
                 // principal
                 principal = monthlyPayment - interest;
                 ///Beginning Balance
                 if(i) {
                     borrow = ending;
                     ending = ending - principal;
                 } else {
                     ending = borrow - principal;
                 }
 
 
                 if (i===term-1) {
                     monthlyPayment = interest + borrow;
                     principal = monthlyPayment - interest;
                     totalPayment += monthlyPayment;
                     ending = 0;
                 }
                 // create an object for result
                 obj.monthlyPayment =  parseInt(monthlyPayment.toFixed(0));
                 obj.ending =  parseInt(ending.toFixed(0));
                 obj.principal =  parseInt(principal.toFixed(0));
                 obj.interest =  parseInt(interest.toFixed(0));
                 obj.borrow =  parseInt(borrow.toFixed(0));
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
 
     var calculatorRegressive = function(borrow, term, interestRate, currency) {
         var interestRateMonth = interestRate/12;
         var ending;
         //get current day, month, year for calculator
         var today = new Date();
         var day = today.getDate();
         var month = today.getMonth() + 1;
         var year = today.getFullYear();
         ///
         var principal, meta = [], data = {}, dateMonth, interest, monthlyPayment;
 
 
         var totalInterest = 0;
         var totalPayment = 0;
         var firstPayment ;//= monthlyPayment;
 
         principal = borrow/term;
         currency = currency || '';
         if (term) {
             principal = Math.ceil(principal/10000) * 10000;
 
             if (currency.toLowerCase() === 'usd') {
                 principal = Math.min(principal, 1);
             }
 
             for (var i=0; i<term; i++) {
                 var obj = {};
                 //calculator date of month
                 if(i) {
                     month = month===12?1:month+1;
                 }
                 if (i&&month===1) {
                     year += 1;
                 }
                 dateMonth = dateOfMonth(day, month, year);
                 //calculator interest
                 interest = calculatorInterest(borrow, interestRateMonth, dateMonth);
                 if(i) {
                     interest = calculatorInterest(ending, interestRateMonth, dateMonth);
                 }
                 monthlyPayment = interest + principal;
 
                 if(i===0) {
                     firstPayment = monthlyPayment;
                 }
 
                 ///Beginning Balance
                 if(i) {
                     borrow = ending;
                     ending = ending - principal;
                 } else {
                     ending = borrow - principal;
                 }
 
                 if (i===term-1) {
                     principal = borrow>principal?principal:borrow;
                     monthlyPayment = interest + principal;
                     ending = 0;
                 }
 
 
                 if (ending < 0) {
                     monthlyPayment = 0;
                 }
 
                 totalPayment += monthlyPayment;
                 totalInterest += interest;
 
                 // remove sub number
                 monthlyPayment = Math.max(monthlyPayment, 0);
                 ending         = Math.max(ending, 0);
                 principal      = Math.max(principal, 0);
                 interest       = Math.max(interest, 0);
                 // create an object for result
                 obj.monthlyPayment = parseInt(monthlyPayment.toFixed(0));
                 obj.ending         = parseInt(ending.toFixed(0));
                 obj.principal      = parseInt(principal.toFixed(0));
                 obj.interest       = parseInt(interest.toFixed(0));
                 obj.borrow         = parseInt(borrow.toFixed(0));
 
                 meta.push(obj);
             }
 
             data.meta = meta;
             data.totalPayment = parseInt(totalPayment.toFixed(0));
             data.totalInterest = parseInt(totalInterest.toFixed(0));
             data.firstPayment = parseInt(firstPayment.toFixed(0));
 
         } else {
             data.meta = 0;
             data.totalPayment = 0;
             data.totalInterest = 0;
             data.firstPayment = 0;
         }
 
         return data;
 
     };
 
     
     TheBank.calculatorFixed = calculatorFixed;
     TheBank.calculatorRegressive = calculatorRegressive;
 });
 
 
 
 
 
 
 
 
 