var TheBank = TheBank || {};

/*global LOAN_CAL_DATA:true, CAR_LOAN_CAL_DATA, PERSONAL_LOAN_CAL_DATA:true*/

$(function () {
	/*jshint multistr:true*/
	'use strict';

	if ($('input[type="range"]').length === 0) {
		return;
	}

	$('body').on('click', '.calculator-info-result .accordion-title', function () {
		if ($(this).parent().hasClass('active'))
			$(this).parent().removeClass('active');
		else
			$(this).parent().addClass('active');
	});
	setTimeout(function () {
		var tab = '#personal-loan-borrow';
		var url = window.location.hash; //get url
		if (url != '') {
			var arr = url.split('#');
			if (arr.length == 2) {
				if (typeof arr[1] != 'undefined' && arr[1] != '') {
					tab = '#' + arr[1];
					$('a[role="tab"][href="#' + arr[1] + '"]').trigger('click');
				}
			}
		}

		initSingleTooltip($(tab));
		$('a[role="tab"][href="#' + tab + '"]').attr('data-init-tooltip', 'true');
	}, 1000);
	/////function -loan-calculator
	var $typeLoan, currency, meta,
		lang, thousandsSeparator, decimalSeparator;
	var globalConfig = TheBank.GLOBAL_CONFIG || {};
	var saveTimeout,
		localPersonalBorrowName = 'personal borrow',
		localPersonalRepaymentName = 'personal repayment',
		localBusinessRepaymentName = 'business repayment';

	var getCurrentData = function ($wraper, interestList) {
		var listData = interestList.data;
		var $currency;
		if ($wraper.find('select[name="currency"]').length) {
			$currency = $wraper.find('select[name="currency"]');
		} else {
			$currency = $wraper.parent().parent().find('select[name="currency"]');
		}

		var currentData;
		if (listData.length > 1) {
			for (var i = 0; i < listData.length; i++) {
				if (listData[i].id === $currency.val()) {
					currentData = listData[i];
					break;
				}
			}
		} else {
			currentData = listData[0];
		}

		return currentData;
	};

	var updateInputRange = function ($wraper, interestList, methodBorrow) {
		var $currency;

		lang = interestList.config.lang || 'vi';
		thousandsSeparator = globalConfig[lang].thousandsSeparator || '.'; // Vietnamese is default
		decimalSeparator = globalConfig[lang].decimalSeparator || ',';

		// update separator for interest rate input
		var interestInput = $wraper.find('input.interest');
		interestInput.attr('data-decimal-separator', decimalSeparator);
		interestInput.attr('data-thousands-separator', thousandsSeparator);

		if ($wraper.find('select[name="currency"]').length) {
			$currency = $wraper.find('select[name="currency"]');
		} else {
			$currency = $wraper.parent().parent().find('select[name="currency"]');
		}
		$wraper.find('input[type="radio"]').click(function () {
			$wraper.find('.calculator-radio').removeClass('checked');
			$(this).parent().addClass('checked');
		});

		$wraper.find('.range-calculotor').each(function () {
			var name = $(this).find('input[type="range"]').attr('name');
			var $input = $('input[name="' + name + '"]');
			var inputType;

			if (methodBorrow) {
				currency = getCurrentData($wraper, interestList).borrow;
				if (name === 'monthly_income') {
					inputType = currency.monthly_income;
				} else if (name === 'monthly_expenses') {
					inputType = currency.monthly_expenses;
				} else if (name === 'term') {
					inputType = currency.loan_term;
					if (inputType.min > 1) {
						$input.attr('min-label', globalConfig[lang].pluralYears);
					} else {
						$input.attr('min-label', globalConfig[lang].singularYear);
					}
					if (inputType.max > 1) {
						$input.attr('max-label', globalConfig[lang].pluralYears);
					} else {
						$input.attr('max-label', globalConfig[lang].singularYear);
					}
				}

			} else {
				currency = getCurrentData($wraper, interestList).repayment;
				if (name === 'loan_term') {
					inputType = currency.loan_term;

					// $input.attr('label-term', globalConfig[lang].pluralMonths);
					if (inputType.min > 1) {
						$input.attr('min-label', globalConfig[lang].pluralYears);
					} else {
						$input.attr('min-label', globalConfig[lang].singularYear);
					}
					if (inputType.max > 1) {
						$input.attr('max-label', globalConfig[lang].pluralYears);
					} else {
						$input.attr('max-label', globalConfig[lang].singularYear);
					}
				} else {
					inputType = currency.borrow_amount;
					$input.attr('unit', inputType.unit);
				}
			}

			// var config = interestList.config;
			if (inputType) {
				$input.attr('max', inputType.max);
				$input.attr('min', inputType.min);
				$input.attr('value', inputType.value);
				$input.attr('step-value', inputType.step);
				// $input.attr('lang', lang);
				$input.attr('thousands-separator', thousandsSeparator);
				$input.attr('decimal-separator', decimalSeparator);
			}

		});



		$wraper.find('.range-calculotor').each(function () {
			// var r = new TheBank.rangeslider();
			$(this).rangeslider('destroy');
			// r.implementRangeslider(this);
		});
		$wraper.find('.range-calculotor').each(function () {
			var r = new TheBank.rangeslider();
			// $(this).rangeslider('destroy');
			r.implementRangeslider(this, true);
		});

		$wraper.find('.range-interest').each(function () {
			var r = new TheBank.rangeslider();
			// $(this).rangeslider('destroy');
			r.implementInterest(this, true);
		});
	};

	var renderOption = function ($wraper, interestList) {
		var $currency;
		if ($wraper.find('select[name="currency"]').length) {
			$currency = $wraper.find('select[name="currency"]');
		} else {
			$currency = $wraper.parent().parent().find('select[name="currency"]');
		}
		$typeLoan = $wraper.find('.select-type-loan');

		// var options = [];
		currency = getCurrentData($wraper, interestList);
		meta = currency.repayment.meta;


		if ($currency.length) {
			dynamic($wraper, interestList);
			implementFixedMonthlyPayment($wraper, interestList);
		}
	};

	var dynamic = function ($wraper, interestList) {
		var lang = interestList.config.lang;
		var interestForLoan = 0;
		var interestName = globalConfig[lang].rateUnit;
		var preData = interestList.config.preData;
		var id = $wraper.attr('id');
		var decimalSeparator = globalConfig[lang].decimalSeparator;

		if (preData) {
			if (id === 'personal-loan-repayment' || id === 'business-loan') {
				interestForLoan = preData.repaymentInterestRate;
			} else {
				interestForLoan = preData.borrowInterestRate;
			}
		}

		var interestRate = Math.round(interestForLoan * 100) / 100;
		interestRate = interestRate.toString();
		interestRate = interestRate.replace('.', decimalSeparator);

		$wraper.find('.interest').val(interestRate + interestName);

		$wraper.find('.interest').attr('data-suffix', interestName);
		$wraper.find('.interest').attr('data-value', interestForLoan);
	};

	var renderTableAcordion = function (data, $modal, interest) {
		var meta = data.meta;
		var length = meta.length;
		var numberTable = Math.ceil(length / 12);

		var $modalAccordion = $modal.find('.modal-accordion');
		var list = [];
		var year, monthLabel;

		if (interest) {
			for (var i = 0; i < numberTable; i++) {

				year = getYearLabel(i, true);

				var row = '';
				var start = i * 12;
				var end = (i + 1) * 12;

				for (var j = start; j < end; j++) {
					if (j > meta.length - 1) {
						break;
					}

					monthLabel = getYearLabel(j, false);

					row += '\
						<tr class="content-table">\
							<td class="month-label">' + monthLabel + '</td>\
							<td>' + meta[j].ending.formatNumber(thousandsSeparator) + ' VND</td>\
							<td>' + meta[j].monthlyPayment.formatNumber(thousandsSeparator) + ' VND</td>\
							<td>' + meta[j].interest.formatNumber(thousandsSeparator) + ' VND</td>\
							<td>' + meta[j].totals.formatNumber(thousandsSeparator) + ' VND</td>\
						</tr>\
					';
				}

				list.push('\
					<div class="accordion-mini accordion-block" data-modal="modal" data-target="modal">\
						<div class="accordion-title show-accordion-content ">\
							<h4 >\
								' + year + '\
								<i class="fa fa-chevron-down"></i>\
							</h4>\
						</div>\
						<div class="accordion-content">\
							<table class="table table-striped">\
								<tbody>\
								' + row + '\
								</tbody>\
							</table>\
						</div>\
					</div>\
				');
			}
		}

		$modalAccordion.html(list);

	};

	var fillValueLoan = function ($wraper, data, interest, data_cal) {
		var $firstPayment = $wraper.find('.first-payment');
		var $totalPayment = $wraper.find('.total-payment');
		var $totalInterest = $wraper.find('.total-interest');
		var $interestFirstPay = $wraper.find('.interest-first-pay');
		interest = interest * 100;
		var firstMonthlyPayment = Math.round(interest * 100) / 100;

		var $currency;
		if ($wraper.find('select[name="currency"]').length) {
			$currency = $wraper.find('select[name="currency"]');
		} else {
			$currency = $wraper.parent().parent().find('select[name="currency"]');
		}

		var unit = getCurrentData($wraper, data_cal);
		unit = unit.repayment.borrow_amount.unit;
		unit = unit ? unit : data_cal.config.sign;
		if (interest) {
			$firstPayment.text(data.firstPayment.formatNumber(thousandsSeparator) + ' ' + unit);
			$totalPayment.text(data.totalPayment.formatNumber(thousandsSeparator) + ' ' + unit);
			$totalInterest.text(data.totalInterest.formatNumber(thousandsSeparator) + ' ' + unit);
			$interestFirstPay.text(firstMonthlyPayment.formatNumber(thousandsSeparator) + '%');
		} else {
			$firstPayment.text(0 + ' VND');
			$totalPayment.text(0 + ' VND');
			$totalInterest.text(0 + ' VND');
			$interestFirstPay.text(0 + '%');
		}
	};

	var startCount = function (name, savingData) {
		clearTimeout(saveTimeout);

		// saveTimeout = setTimeout(function () {
		// 	saveDataToLocal(name, savingData);
		// }, 3000);
	};

	// var saveDataToLocal = function (name, savingData) {
	// 	savingData = JSON.stringify(savingData);
	// 	localStorage.setItem(name, savingData);
	// };

	var implementFixedMonthlyPayment = function ($wraper, data_cal) {

		var fixed = true;
		dynamic($wraper, data_cal);

		var term = parseFloat($wraper.find('.term').attr('data-value'));
		var borrowAmount = ($wraper.find('.borrow-amount').attr('data-value'));
		var $inputLoan = $wraper.find('input[name="loan_amount"]');
		var $outputLoan = $inputLoan.closest('.range-calculotor').find('input.value-current');
		var $inputTerm = $wraper.find('input[name="loan_term"]');
		var $outputTerm = $inputTerm.closest('.range-calculotor').find('input.value-current');
		var $repaymentMethod = $wraper.find('input[name="repaymentMethod"]');
		var $interest = $wraper.find('.interest');
		var $remainder = $wraper.find('.remainder');

		var preData = data_cal.config.preData;
		// reset method repayment
		if (preData) {
			if (preData.repaymentMethod === 'fixed') {
				fixed = true;
			} else {
				fixed = false;
			}
		}

		var calculatorFixedMonthlyPayment = function () {
			var data;
			var $breakDownLink = $wraper.find('.btn-show-breakdown');
			var interest = $interest.val();
			interest = interest.replace(',', '.');
			//calculator car loan
			interest = parseFloat(interest) / 100;
			term = parseFloat($wraper.find('.term').attr('data-value'));
			//
			term = term * 12;
			// remainder = parseFloat(borrowAmount - borrowAmount/(term*12));

			borrowAmount = parseFloat($wraper.find('.borrow-amount').attr('data-value'));
			var monthlyPayment = interest / term;
			var paid_monthly = interest + monthlyPayment;

			// get pricipal	
			var $currency = $wraper.find('select[name="currency"]');
			var currCurrency = '';
			if ($currency.length) {
				currCurrency = $currency.val();
			}
			// console.log('TheBank: ' + TheBank)
			if (fixed) {
				data = TheBank.calculatorFixed(borrowAmount, term, interest);
			} else {
				data = TheBank.calculatorRegressive(borrowAmount, term, interest, currCurrency);
				// console.log(data);
			}

			fillValueLoan($wraper, data, interest, data_cal);
			var $modal = $('#modalCarLoanRepayment');

			$breakDownLink.off('click');
			$breakDownLink.on('click', function () {
				renderTableAcordion(data, $modal, interest
				);
				//implement accordion
				// TheBank.implementAccordionModal();
			});

			// personal loan repayment
			var repaymentMethod;
			$repaymentMethod.each(function (index, radio) {

				var $radio = $(radio);
				if ($radio.is(':checked')) {
					repaymentMethod = $radio.val();

					$("#modal-title").fadeOut(function () {
						$("#modal-title").text(($("#modal-title").text() == 'Phương thức trả nợ khoản vay: Số tiền trả hàng tháng giảm dần') ? 'Phương thức trả nợ khoản vay: Số tiền trả hàng tháng giảm dần' : 'Phương thức trả nợ khoản vay: Số tiền trả hàng tháng giảm dần').fadeIn();
					})
				}else{
					$("#modal-title").fadeOut(function () {
						$("#modal-title").text(($("#modal-title").text() == 'Phương thức trả nợ khoản vay: Số tiền trả hàng tháng giảm dần') ? 'Phương thức trả nợ khoản vay: Số tiền trả hàng tháng cố định' : 'Phương thức trả nợ khoản vay: ố tiền trả hàng tháng giảm dần').fadeIn();
					})
				}


			});




			var savingData = {};
			savingData = {
				repaymentLoanAmount: borrowAmount,
				repaymentLoanTerm: term / 12,
				repaymentInterestRate: Math.round(interest * 100 * 100) / 100,
				repaymentMethod: repaymentMethod
			};

			// currency

			if ($currency.length) {
				savingData.currency = currCurrency;
			}

			if ($wraper.attr('id') === 'business-loan') {
				startCount(localBusinessRepaymentName, savingData);
			} else {
				startCount(localPersonalRepaymentName, savingData);
			}
		};

		$repaymentMethod.on('change', function (e) {
			var target = e.target.value;
			if (target === 'fixed') {
				fixed = true;
			} else {
				fixed = false;
			}
			calculatorFixedMonthlyPayment();
		});

		$outputLoan.on('keyup', function () {
			calculatorFixedMonthlyPayment();
		});

		$outputTerm.on('keyup', function () {
			calculatorFixedMonthlyPayment();
		});

		calculatorFixedMonthlyPayment();

		///editable "rate", maximum value is 20%
		// var $interest = $wraper.find('.interest');
		$wraper.find('.add-rate').on('click', function () {
			$interest
				.removeClass('disabled')
				.removeAttr('readonly')
				.removeAttr('disabled');
		});

		$interest.on('keyup', function (e) {
			// if(parseFloat(e.target.value)>20) {
			// 	e.target.value = '';
			// 	$(this).attr('placeholder', globalConfig[lang].maxInterestRate);
			// }

			// interest = parseFloat($wraper.find('.interest').val())/100;

			var interest;
			var el = e.currentTarget;
			var val = el.value;
			var value = el.getAttribute('data-value');
			var interest_val = document.getElementById('interest');
			if (value == '00' || value === '000' || value === '0000' || value == '0,00') {
				interest_val.value = "";
			}
			else if (!value.includes(',')) {
				interest_val.value = interest_val.value * 1;
			}
			val = val.replace(',', '.');

			var valNumber = parseFloat(val);
			var max = data_cal.config && data_cal.config.maxInterestRate || 20;
			if (valNumber > max) {
				// e.target.value = '';
				// $(this).attr('placeholder', globalConfig[lang].maxInterestRate);
				el.value = '';
				el.setAttribute('placeholder', globalConfig[lang].maxInterestRate);
			}

			// interest = valNumber / 100;
			interest = valNumber / 100;

			calculatorFixedMonthlyPayment();

		});
	};
	/////function for only dynamic loan calculator such as business-loan-calculator


	var renderInterestDynamic = function ($wraper, interestList) {

		// renderOption($wraper, interestList);
		updateInputRange($wraper, interestList);
		dynamic($wraper, interestList);
		implementFixedMonthlyPayment($wraper, interestList);

		var $currency;
		if ($wraper.find('select[name="currency"]').length) {
			$currency = $wraper.find('select[name="currency"]');
		} else {
			$currency = $wraper.parent().parent().find('select[name="currency"]');
		}

		$currency.on('change', function () {
			$wraper.find('.range-calculotor').each(function () {
				$(this).off();
				$(this).find('input').rangeslider('destroy');
			});
			renderOption($wraper, interestList);
			dynamic($wraper, interestList);
			updateInputRange($wraper, interestList);
			implementFixedMonthlyPayment($wraper, interestList);
		});

		// $amountBorrow.on('change', function(e){
		// 	dynamic($wraper, interestList, e.target.value);
		// 	implementFixedMonthlyPayment($wraper, interestList);
		// });
	};

	//implement range slider for real layout after hide
	var renderTabsRange = function (name, data) {
		$('.nav-tabs a').on('click', function () {
			// var _this = this;
			var $this = $(this);

			var id = $(this).attr('href');
			var rendered = $(this).attr('data-rendered');
			if (id === name && rendered !== 'true') {
				$(id).find('input[type="range"]').each(function () {
					$(this).off();
					$(this).rangeslider('destroy');
					setTimeout(function () {
						updateInputRange($(id), data, false);
						implementFixedMonthlyPayment($(id), data);
						$this.attr('data-rendered', 'true');

						// init tooltip
						if ($this.attr('data-init-tooltip') !== 'true') {
							initSingleTooltip($(id));
							$this.attr('data-init-tooltip', 'true');
						}
					}, 0.5);
				});
			}
		});
	};

	///implement calculator-car-loan
	var $repayment = $('#car-loan-repayment');
	if ($repayment.length) {
		if ($repayment.is(':visible')) {
			updateInputRange($repayment, CAR_LOAN_CAL_DATA);
		}
		implementFixedMonthlyPayment($repayment, CAR_LOAN_CAL_DATA);
		renderTabsRange('#car-loan-repayment', CAR_LOAN_CAL_DATA);

		$repayment.find('input.interest').attr('disabled', 'disabled');
	}


	///implement calculator-business-loan in business landing tool
	var $businessRepayment = $('#business-loan');

	if ($businessRepayment.length && $businessRepayment.data('target') === 'tool') {

		// get data from local
		var businessPreData = localStorage.getItem(localBusinessRepaymentName);
		LOAN_CAL_DATA.config.preData = JSON.parse(businessPreData);

		// reset currency
		if (LOAN_CAL_DATA.config.preData) {
			// update data with default value
			LOAN_CAL_DATA = setBusinessDefaultValue(LOAN_CAL_DATA);
			setBusinessDropdown($businessRepayment, LOAN_CAL_DATA.config.preData);
		}

		renderInterestDynamic($businessRepayment, LOAN_CAL_DATA);
	}

	///////How much can i borrow
	var implementBorrow = function ($wraper, data) {
		dynamic($wraper, data, true);
		var income = parseFloat($wraper.find('.income').attr('data-value'));
		var expenses = parseFloat($wraper.find('.expenses').attr('data-value'));
		var termBorrow = parseFloat($wraper.find('.term').attr('data-value'));
		var interestBorrow = parseFloat($wraper.find('.interest').attr('data-value'));
		var $inputIncome = $wraper.find('input[name="monthly_income"]');
		var $outputIncome = $inputIncome.closest('.range-calculotor').find('input.value-current');
		var $inputExpense = $wraper.find('input[name="monthly_expenses"]');
		var $outputExpense = $inputExpense.closest('.range-calculotor').find('input.value-current');
		var $inputTerm = $wraper.find('input[name="term"]');
		var $outputTerm = $inputTerm.closest('.range-calculotor').find('input.value-current');

		var calculatorBorrow = function (income, expenses, termBorrow, interestBorrow) {
			var interestMonth = interestBorrow / 12 / 100;
			var termMonth = termBorrow * 12; // termBorrow is year now
			var result = (0.9 * income - expenses) / (1 / termMonth + interestMonth);
			if (termBorrow && interestMonth) {
				result = Math.ceil(result.toFixed(0));
				result = result > 0 ? result : 0;
			} else {
				result = 0;
			}
			$wraper.find('.amount-borrow').text(result.formatNumber(thousandsSeparator) + ' ' + data.config.sign);

			// How much I can borrow saving data
			var savingData = {};
			savingData = {
				monthlyIncome: income,
				monthlyExpenses: expenses,
				loanTerm: termBorrow,
				borrowInterestRate: Math.round(interestBorrow * 100) / 100
			};



			startCount(localPersonalBorrowName, savingData);
		};

		calculatorBorrow(income, expenses, termBorrow, interestBorrow);

		///editable "rate", maximum value is 20%
		$wraper.find('.add-rate').on('click', function () {
			$wraper.find('.interest')
				.removeClass('disabled')
				.removeAttr('readonly')
				.removeAttr('disabled');
		});

		$outputIncome.on('keyup', function () {
			income = parseFloat($wraper.find('.income').attr('data-value'));
			calculatorBorrow(income, expenses, termBorrow, interestBorrow);

		});

		$outputTerm.on('keyup', function (e) {
			termBorrow = parseFloat(e.currentTarget.getAttribute('data-value')) || 0;
			calculatorBorrow(income, expenses, termBorrow, interestBorrow);
		});

		$wraper.find('.interest').on('keyup', function (e) {

			var interest;
			var el = e.currentTarget;
			var val = el.value;
			var value = el.getAttribute('data-value');
			var interest_val = document.getElementById('interest');
			if (value == '00' || value === '000' || value === '0000' || value == '0,00') {
				interest_val.value = "";

			}
			else if (!value.includes(',')) {

				interest_val.value = interest_val.value * 1;

			}
			val = val.replace(',', '.');
			var valNumber = parseFloat(val);
			var max = data.config && data.config.maxInterestRate || 20;
			if (valNumber > max) {
				// e.target.value = '';
				// $(this).attr('placeholder', globalConfig[lang].maxInterestRate);
				el.value = '';
				el.setAttribute('placeholder', globalConfig[lang].maxInterestRate);
			}

			// interest = parseFloat($wraper.find('.interest').val())/100;
			interest = valNumber;
			calculatorBorrow(income, expenses, termBorrow, interest);

		});

		$outputExpense.on('keyup', function () {
			expenses = parseFloat($wraper.find('.expenses').attr('data-value'));
			calculatorBorrow(income, expenses, termBorrow, interestBorrow);

		});

		$inputTerm.on('keyup', function () {
			termBorrow = parseFloat($wraper.find('.term').attr('data-value'));
			calculatorBorrow(income, expenses, termBorrow, interestBorrow);

		});

		$wraper.find('.interest').on('change', function (e) {
			// var val = e.currentTarget.getAttribute('data-value');
			var val = e.currentTarget.value || '';
			val = val.replace(',', '.');
			var value = el.getAttribute('data-value');
			var interest_val = document.getElementById('interest');
			if (value == '00' || value === '000' || value === '0000' || value == '0,00') {
				interest_val.value = "";

			}
			else if (!value.includes(',')) {
				// var check = Number(interest_val.value.replace(',', '.')) * 1;
				// interest_val.value = check.replace('.', ',') * 1;
				interest_val.value = interest_val.value * 1;

			}
			interestBorrow = parseFloat(val);

			calculatorBorrow(income, expenses, termBorrow, interestBorrow);

		});
	};

	var $carLoanBorrow = $('#car-loan-borrow');
	if ($carLoanBorrow.length) {
		if ($carLoanBorrow.is(':visible')) {
			updateInputRange($carLoanBorrow, CAR_LOAN_CAL_DATA, true);
		}
		implementBorrow($carLoanBorrow, CAR_LOAN_CAL_DATA);

		$carLoanBorrow.find('input.interest').attr('disabled', 'disabled');
	}

	//////
	/**
   * Personal Tool
   */

	///implement personal-car-loan
	var localPreData = {};
	var $personalRepayment = $('#personal-loan-repayment');

	// if($('select[name="currency"]').val()){
	if ($personalRepayment.length) {
		// set data to config
		localPreData = localStorage.getItem(localPersonalRepaymentName);

		if (localPreData) {
			localPreData = JSON.parse(localPreData);

			PERSONAL_LOAN_CAL_DATA.config.preData = localPreData;
		}

		PERSONAL_LOAN_CAL_DATA = setPersonalLoanDefaultValue(PERSONAL_LOAN_CAL_DATA, true);
		if ($personalRepayment.is(':visible')) {
			updateInputRange($personalRepayment, PERSONAL_LOAN_CAL_DATA);
		}
		implementFixedMonthlyPayment($personalRepayment, PERSONAL_LOAN_CAL_DATA);
		renderTabsRange('#personal-loan-repayment', PERSONAL_LOAN_CAL_DATA);
	}

	////////
	var $personalLoanBorrow = $('#personal-loan-borrow');
	if ($personalLoanBorrow.length) {
		localPreData = localStorage.getItem(localPersonalBorrowName);

		if (localPreData) {
			localPreData = JSON.parse(localPreData);

			$.extend(PERSONAL_LOAN_CAL_DATA.config.preData, localPreData);
		}

		PERSONAL_LOAN_CAL_DATA = setPersonalLoanDefaultValue(PERSONAL_LOAN_CAL_DATA);

		if ($personalLoanBorrow.is(':visible')) {
			updateInputRange($personalLoanBorrow, PERSONAL_LOAN_CAL_DATA, true);
		}
		implementBorrow($personalLoanBorrow, PERSONAL_LOAN_CAL_DATA);
	}

	// tooltip
	destroyTooltip($businessRepayment);
	destroyTooltip($personalRepayment);
	destroyTooltip($personalLoanBorrow);
	destroyTooltip($carLoanBorrow);
	destroyTooltip($repayment);

	function initSingleTooltip($wrapper) {
		var $tooltipsSingle = $wrapper.find('[data-toggle=tooltip][data-single=true]');

		if ($tooltipsSingle.length > 0) {
			$tooltipsSingle.tooltip({
				trigger: 'focus'
			});

			$tooltipsSingle.tooltip('show');

			destroyTooltip($wrapper);
		}
	}

	function destroyTooltip($wrapper) {
		var $tooltipsSingle = $wrapper.find('[data-toggle=tooltip][data-single=true]');
		if ($tooltipsSingle.length > 0) {
			$tooltipsSingle.on('focus mousedown touchstart', function () {
				$tooltipsSingle.tooltip('destroy');

				$wrapper.find('[data-have-tooltip]').removeAttr('data-have-tooltip');
			});
		}
	}

	function getYearLabel(year, isYear) {
		var language = globalConfig[lang];
		var yearText = '';
		var yearSuffix = '';
		var singular;

		year = year || 0;
		year = year + 1;
		var yearLastNo = year % 10;

		if (isYear) {
			singular = language.singularYear;
		} else {
			singular = language.singularMonth;
		}

		switch (yearLastNo) {
			case 1:
				yearSuffix = language.ordinalFirst;
				break;
			case 2:
				yearSuffix = language.ordinalSecond;
				break;
			case 3:
				yearSuffix = language.ordinalThird;
				break;
			default:
				yearSuffix = language.ordinalMore;
		}

		yearText = year + yearSuffix;

		if (lang === 'en') {
			return yearText + ' ' + singular;
		} else {
			return singular.charAt(0).toUpperCase() + singular.slice(1) + ' ' + language.ordinalSeparator + ' ' + yearText;
		}
	}

	function setBusinessDefaultValue(dataCalc) {
		var defaultValue = dataCalc.config.preData;
		var index = {};
		if (defaultValue) {
			index = getDataByCurrency(dataCalc.data, defaultValue.currency);

			// reset data
			dataCalc.data[index].repayment.borrow_amount.value = defaultValue.repaymentLoanAmount;
			dataCalc.data[index].repayment.loan_term.value = defaultValue.repaymentLoanTerm;
			// dataCalc.data[index].repayment.borrow_amount.value = defaultValue.loanAmount;
		}

		return dataCalc;
	}

	function getDataByCurrency(data, currency) {
		data = data || [];

		for (var i = 0; i < data.length; i++) {
			if (data[i].id.toLowerCase() === currency.toLowerCase()) {
				return i;
			}
		}
	}

	function setBusinessDropdown($wrapper, data) {
		var preCurrency = data.currency;
		var repaymentMethod = data.repaymentMethod;

		if (preCurrency) {
			$wrapper.find('select[name=currency]').val(preCurrency.toLowerCase());

		}

		if (repaymentMethod) {
			var $inputs = $wrapper.find('input[type=radio]');
			$inputs.removeAttr('checked');
			$inputs.closest('label').removeClass('checked');

			var input = $wrapper.find('input[type=radio][value=' + repaymentMethod + ']');
			input.attr('checked', true);
			input.prop('checked', true);
			input.closest('label').addClass('checked');
		}
	}

	function setPersonalLoanDefaultValue(dataCalc, isRepayment) {
		var defaultValue = dataCalc.config.preData;
		var index = 0;
		if (defaultValue) {
			index = 0; // getDataByCurrency(dataCalc.data, defaultValue.currency);

			if (isRepayment) {
				dataCalc.data[index].repayment.borrow_amount.value = defaultValue.repaymentLoanAmount;
				dataCalc.data[index].repayment.loan_term.value = defaultValue.repaymentLoanTerm;

				var $inputs = $personalRepayment.find('input[type=radio]');
				$inputs.removeAttr('checked');
				$inputs.closest('label').removeClass('checked');

				var input = $personalRepayment.find('input[type=radio][value=' + defaultValue.repaymentMethod + ']');
				input.attr('checked', true);
				input.prop('checked', true);
				input.closest('label').addClass('checked');

			} else {
				// reset data
				dataCalc.data[index].borrow.monthly_income.value = defaultValue.monthlyIncome;
				dataCalc.data[index].borrow.monthly_expenses.value = defaultValue.monthlyExpenses;
				dataCalc.data[index].borrow.loan_term.value = defaultValue.loanTerm;
			}
		}

		return dataCalc;
	}
});
