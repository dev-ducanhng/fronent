var TheBank = TheBank || {};
// saving calculation function for personal only
$(function () {
	'use strict';

	var config, savingAccountData = null,
		thousandsSeparator, decimalSeparator, lang;
	var globalConfig = TheBank.GLOBAL_CONFIG || {};
	if (typeof SAVING_ACCOUNT_CAL_DATA !== 'undefined') {
		savingAccountData = SAVING_ACCOUNT_CAL_DATA.data;
		config = SAVING_ACCOUNT_CAL_DATA.config;
		lang = config.lang;
		$.extend(config, globalConfig[lang]);
		thousandsSeparator = config.thousandsSeparator || '.';
		decimalSeparator = config.decimalSeparator || ',';
	}

	var
		$wrapper = $('.saving-personal-calculator'),
		$inputDeposit = $wrapper.find('[data-name="input-deposit-amount"]'),
		$inputTerm = $wrapper.find('[data-name="input-deposit-term"]'),
		$inputInterest = $wrapper.find('.range-interest'),
		$interestEarned = $wrapper.find('[data-name="interest-earned"]'),
		$totalBalance = $wrapper.find('[data-name="total-balance"]'),
		$savingCalBlock = $wrapper.find('[data-name="saving-cal"]'),
		$outputDeposit = $inputDeposit.closest('.range-calculotor').find('input.value-current'),
		$outputTerm = $inputTerm.closest('.range-calculotor').find('input.value-current'),
		$outputInterest = $inputInterest.find('input.value-current'),
		savingCalType = $savingCalBlock.attr('data-type'),
		currentCurrency = null,
		model = null,
		saveTimeout = null,
		localName = 'saving personal calculator';

	var getInterestEarned = function (model) {
		var currentDate,
			month_term, pa,
			result, dayNo;

		currentDate = model.currentDate;

		month_term = model.depositTerm;
		pa = model.pa;
		result = model.amount * (pa / 100) / 12 * month_term;
		result = Math.round(result, 2);
		return result;
	};

	var getTotalBalance = function (model) {
		return model.amount + getInterestEarned(model);
	};

	var updateData = function () {
		var current = currentCurrency, earned, total, divType;
		divType = config.thousandsSeparator;
		if (isNaN(model.amount)) {
			model.amount = 0;
		}

		earned = getInterestEarned(model).formatNumber(divType) + ' ' + current.sign;
		total = Math.round(getTotalBalance(model) / current.offsetValue).formatNumber(divType) + ' ' + current.offsetName + ' ' + current.sign;

		$interestEarned.html(earned);
		$totalBalance.html(total);

		// save to local storage
		var savingData = {};
		savingData = {
			currency: model.currency,
			depositAmount: model.amount,
			depositTerms: model.depositTerm,
			depositPa: model.pa
		};

		startCount(localName, savingData);
	};

	var startCount = function (name, savingData) {
		clearTimeout(saveTimeout);

		saveTimeout = setTimeout(function () {
			saveDataToLocal(name, savingData);
		}, 3000);
	};

	var saveDataToLocal = function (name, savingData) {
		// console.log('Saved', savingData);
		localStorage.setItem(name, JSON.stringify(savingData));
	};

	var updateInputDeposit = function () {
		var current = currentCurrency;
		var value = current.depositRule.value || current.depositRule.min;

		$inputDeposit.attr('value', value);
		$inputDeposit.attr('min', current.depositRule.min);
		$inputDeposit.attr('max', current.depositRule.max);
		$inputDeposit.attr('unit', current.type);
		$inputDeposit.attr('step-value', current.step);
		$inputDeposit.attr('decimal-separator', decimalSeparator);
		$inputDeposit.attr('thousands-separator', thousandsSeparator);

		$inputDeposit.attr('million', 'true');

		if (model.pa != '')
			$outputInterest.attr('value', model.pa + '%/năm').attr('data-value', model.pa);
		if (parseInt(model.depositTerm) > 0) {
			$inputTerm.attr('value', model.depositTerm).attr('data-value', model.depositTerm);
		}
		// update
		$inputDeposit.unbind();

		$wrapper.find('.range-calculotor').each(function () {
			var r = new TheBank.rangeslider();
			r.implementRangeslider(this, true);
		});

		$wrapper.find('.range-interest').each(function () {
			var r = new TheBank.rangeslider();
			r.implementInterest(this, true);
		});

	};


	function onOutputDepositAmountChanged(e) {
		var el = e.currentTarget;
		var value = el.getAttribute('data-value');

		model.amount = value * currentCurrency.offsetValue;

		updateData();
	}

	function onOutputDepositTermChanged(e) {
		var el = e.currentTarget;
		var value = el.getAttribute('data-value');
		if (value == "NaN") {
			value = 0;
		}
		if (value > 60) {
			el.value = '';
			el.setAttribute('placeholder', globalConfig[lang].maxTerm);
		}
		model.depositTerm = parseInt(value);

		updateData();
	}
	function onOutputDepositInterestChanged(e) {
		var el = e.currentTarget;
		var value = el.getAttribute('data-value');
		var interest_val = document.getElementById('interest');
		if (value == '00') {
			interest_val.value = 0;
		}

		if (value.toString().indexOf(',') != -1 || value.toString().indexOf('.') != -1) {
			value = value.toString().replace(',', '.');
			value = parseFloat(value);
		}
		else
			value = parseInt(value);
		var max = 20;
		// var min = 0;

		// if(value < min){
		// 	el.value = '';
		// }
		if (value > max) {
			el.value = '';
			el.setAttribute('placeholder', globalConfig[lang].maxInterestRate);
		}
		else {
			model.pa = (value == '') ? 0 : value;
			if (isNaN(model.pa))
				model.pa = 0;
			updateData();
		}
	}

	var init = function () {
		// do nothing when data is not ready
		if (savingAccountData === null || savingCalType === 'business') {
			return;
		}

		var preData;
		var index = 0;
		var depositTerm = 1;
		var amount = 0;
		var depositPa = 0;

		// get last data
		preData = localStorage.getItem(localName);
		preData = JSON.parse(preData);

		currentCurrency = savingAccountData[index];
		if (!currentCurrency) {
			currentCurrency = savingAccountData[0];
		}

		amount = currentCurrency.depositRule.min * currentCurrency.offsetValue;

		if (preData) {
			currentCurrency.depositRule.value = preData.depositAmount;
			depositTerm = preData.depositTerms;
			amount = preData.depositAmount;
			depositPa = preData.depositPa;
		}

		model = {
			currency: currentCurrency.type,
			amount: amount,
			pa: depositPa,//Default Interest 1 Month
			depositTerm: depositTerm, //Default Month 
			currentDate: new Date()
		};

		updateInputDeposit();

		// update default content
		updateData();

		// binding events

		// $outputDeposit.on('keyup', onOutputDepositAmountChanged);
		// $outputTerm.on('keyup', onOutputDepositTermChanged);
		// $outputInterest.on('keyup', onOutputDepositInterestChanged);

		// tooltip
		var $tooltipsSingle = $wrapper.find('[data-toggle=tooltip][data-single=true]');
		if ($tooltipsSingle.length > 0) {
			$tooltipsSingle.on('focus mousedown touchstart', function () {
				$tooltipsSingle.tooltip('dispose');
			});
		}
	};
	init();
});