/**
 * Global config
 */

 var TheBank = TheBank || {};

 (function() {
     'use strict';
 
     var GLOBAL_CONFIG = {
         vi: {
             pluralWeeks: 'tuần',
             singularWeek: 'tuần',
             pluralMonths: 'tháng',
             singularMonth: 'tháng',
             pluralYears: '',
             singularYear: 'năm',
             rateUnit: '%/năm',
             thousandsSeparator: '.',
             decimalSeparator: ',',
             ordinalSeparator: 'thứ',
             ordinalFirst: '',
             ordinalSecond: '',
             ordinalThird: '',
             ordinalMore: '',
             maxInterestRate: 'Giá trị lớn nhất là 20',
             maxTerm: 'Số năm lớn nhất là 25'
         },
         en: {
             pluralWeeks: 'weeks',
             singularWeek: 'week',
             pluralMonths: 'months',
             singularMonth: 'month',
             pluralYears: 'years',
             singularYear: 'year',
             rateUnit: '%p.a',
             thousandsSeparator: ',',
             decimalSeparator: '.',
             ordinalSeparator: '',
             ordinalFirst: 'st',
             ordinalSecond: 'nd',
             ordinalThird: 'rd',
             ordinalMore: 'th',
             maxInterestRate: 'Maximum value is 20'
         }
     };
 
     // export
     TheBank.GLOBAL_CONFIG = GLOBAL_CONFIG;
 })();