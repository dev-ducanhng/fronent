var TheBank = TheBank || {};
TheBank.rangeslider = function rangeslider() {
	'use strict';

	var MAX_VALUE = Number.MAX_VALUE;

	var $wraper, $input, $min, $max,
		minValue, maxValue, step,
		$output, unit, divType, defaultValue,
		minLabel, maxLabel,
		isMoreThanMax, moreThanMax;

	/**
	 * Update output with value
	 */
	var updateOutput = function(val) {
		// TK: update month, month base on number on month
		if (maxLabel && minLabel){
			if (val > 1) {
				$output.val(val.formatNumber(divType) + ' ' + maxLabel);
			} else {
				$output.val(val.formatNumber(divType) + ' ' + minLabel);
			}
		} else {
			$output.val(val.formatNumber(divType) + ' ' + unit);
		}

		$output.attr('data-value', val);
		$output.trigger('keyup');
	};

	/**
	 * handle Output change
	 */
	var onOutputChanged = function(e) {
		var val = e.currentTarget.value;
		var reg;
		var unit = $input.attr('unit');

		if (divType === ',') {
			reg = /,/g;
		} else {
			reg = /\./g;
		}
		var str = val.replace(reg, '');
		var value = parseFloat(str);

		if (value >= maxValue) {
			if (isMoreThanMax === undefined) {
				// cannot input more than maximum
				value = maxValue;
				str = maxValue;
			} else {
				// allow to input more than maximum
				if (value >= MAX_VALUE) {
					value = MAX_VALUE;
					str = MAX_VALUE + ' ' + unit;
				}
			}

			if (e.isTrigger && maxLabel) {
				str += ' ' + maxLabel;
			}
		} else if (value <= minValue) {
			value = minValue;
			str = minValue;

			if (e.isTrigger) {
				if (minLabel) {
					str += ' ' + minLabel;
				} else {
					str += ' ' + unit;
				}
			}
		}

		if (/^0+/.test(str)) {
			//if the text start with zeros
			if (value > 0) {
				str = str.replace('0', '');
			}
		}

		var valStr = String.addCommas(str, divType);
		
		$output.attr('data-value', value);
		$output.val(valStr);
	};

	/**
	 * handle when output focused
	 */
	var onOutputFocused = function(e) {
		var $target = $(e.target),
			value = String.addCommas($target.attr('data-value'), divType);
		$target.val(value);
	};

	var onOutputFocusedOut = function() {
		var amount = $(this).attr("pattern");
		var value = $output.attr('data-value');
		if(amount == "amount") {
			if(value < 1000){
				value = 0;
			}
		}
		value = parseFloat(value) || 0;
		var mod = value%step;
		var divide = value/step;

		if (mod >= step) {
			value = step * Math.ceil(divide);
		} else {
			value = step * Math.floor(divide);
		}

		updateOutput(value);
		if (value >= maxValue) {
			$input.val(maxValue);
		} else {
			$input.val(value);
		}
		$input.rangeslider('update', true);
	};
	// $('.amount_input').focusout(function(){
	// 	var value = $('.amount_input').attr('data-value');
	// 	if(value < 1000) {
	// 		$('.amount_input').attr("data-value","1000")
	// 	}
	// });
	var onOutputFocusedOutInterest = function() {
		var value = $(this).val();
		value 	  = value || 0;
		var lastchild = value[value.length-1];
		if(lastchild == ','){
			var value = value.replace(",","");
		}
		
		$(this).attr('data-value', value);
		if(typeof $(this).data('suffix') != 'undefined')
			value = value + $(this).data('suffix');
		else
			value = value + '%/năm';
		
		$(this).val(value);
	};
	var onOutputChangedInterest = function(e) {
		var val = $(this).val();
		$(this).attr('data-value', val);
	};
	var onInputChanged = function(e) {
		var targetValue = parseFloat(e.target.value);
		var mod = targetValue%step;
		var divide = targetValue/step;

		// TK: If output is on focus
		// we should blur output before change value
		if (!$output.is(':focus')) {
			///step = minvalue, show value with step value
			if (mod>=step/2) {
				targetValue = step * Math.ceil(divide);
			} else {
				targetValue = step * Math.floor(divide);
			}
			updateOutput(targetValue);

		} else {
			$output.blur();
			e.preventDefault();
		}
	};
	this.implementInterest 	  = function(wraper,add_event_input)
	{
		$wraper 	= $(wraper);
		$input 		= $wraper.find('input');
		$input.attr('tabindex', '-1');
		if(add_event_input)
		{
			$input.off('focus focusout keydown keyup input');
			
			$input.on('focus', onOutputFocused);
			$input.on('focusout', onOutputFocusedOutInterest);
			$input.on('keyup', onOutputChangedInterest);
		}
	}
	this.implementRangeslider = function(wraper,add_event_input) {

		$wraper 	= $(wraper);
		$input 		= $wraper.find('input[type=range]');
		
		$min = $wraper.find('.min-value');
		$max = $wraper.find('.max-value');
		minValue = $input.attr('min');
		maxValue = $input.attr('max');
		unit = $input.attr('unit');
		step = $input.attr('step-value');
		isMoreThanMax = $input.attr('data-mt-max');

		var decimalSeparator = $input.attr('decimal-separator');
		var thousandsSeparator = $input.attr('thousands-separator');

		// ignore tab focus
		$input.attr('tabindex', '-1');

		//if dont enter step-value attribute, it'll use min-value
		step = step || minValue;

		$output = $wraper.find('.value-current');
		
		$output.attr('data-decimal-separator', decimalSeparator);
		$output.attr('data-thousands-separator', thousandsSeparator);
	
		defaultValue = parseInt($input.attr('value') || minValue);
		unit = $input.attr('unit');
		divType = thousandsSeparator || ','; // Vietnamese separator is default
		decimalSeparator = decimalSeparator || '.'; // Vietnamese separator is default

		// parse to Number
		minValue = parseInt(minValue) || 0;
		maxValue = parseInt(maxValue) || 0;

		if (!$input.length) {
			return;
		}
		// set initial output value
		var initValue = parseInt($input[0].value);
		
		minLabel = $input.attr('min-label');
		maxLabel = $input.attr('max-label');
		if (maxLabel) {
			$max.text(maxValue.formatNumber(divType) + ' ' + maxLabel);
		} else {
			$max.text(maxValue.formatNumber(divType) + ' ' + unit);
		}
		if (minLabel) {
			$min.text(minValue.formatNumber(divType) + ' ' + minLabel);
		} else {
			$min.text(minValue.formatNumber(divType) + ' ' + unit);
		}
		
		// update content
		updateOutput(initValue);
		if(add_event_input)
		{
			// binding on input event
			$input.on('keyup', onInputChanged);

			// unbind events
			$output.off('focus focusout keydown keyup input');

			// binding event for output
			$output.on('focus', onOutputFocused);
			$output.on('focusout', onOutputFocusedOut);
			$output.on('keyup', onOutputChanged);
		}
		/*jshint multistr:true*/
		var $ruler = $('<span class="arrow-left-1" /> <span class="arrow-left-2" />\
			<span class="arrow-right-1" /> <span class="arrow-right-2" />');

			var $ruler = '<span class="arrow-left-1"></span><span class="arrow-left-2"></span><span class="arrow-right-1"></span><span class="arrow-right-2"></span>';

		//rangeslider__fill
		var splitterLength = maxValue/step-1;
		var splitter = '';

		splitterLength = splitterLength>15?15:splitterLength;

		for(var i=0; i< splitterLength; i++) {
			splitter += '<span class="splitter" style="width: ' + 100/splitterLength + '%"></span>';
		}
		var $newFill = $('<div class="rangeslider__fill__new">' + splitter + '</div>');
		// Initialize
		$input.rangeslider({
			polyfill: false,
			onInit: function() {
				var $fill = this.$range;
				this.$handle.html($ruler);
				$newFill.width(this.$range.width()-80);
				$fill.prepend($newFill);
			},
			onSlide: function(position, value) {
				updateOutput(value);
			},
			onSlideEnd: function() {
				moreThanMax = false;
			}
		});
		// reset value to default
		if (defaultValue > maxValue) {
			$input.val(maxValue);
			$input.rangeslider('update', true);

			updateOutput(defaultValue);
		} else {
			$input.val(defaultValue).change();
		}

		// init tooltip
		var $rangeslider = $wraper.find('.rangeslider__handle');
		if ($input.attr('data-have-tooltip')) {
			$rangeslider.attr('data-placement', $input.attr('data-placement'));
			$rangeslider.attr('title', $input.attr('title'));
			$rangeslider.attr('data-single', $input.attr('data-single'));
			$rangeslider.attr('data-toggle', 'tooltip');

			if ($().tooltip && $rangeslider.attr('data-single') && $rangeslider.attr('data-inited')) {
				$rangeslider.tooltip({
					trigger: 'focus'
				});

				// TheBank.resetPositionOfTooltip($rangeslider);
				$rangeslider.tooltip('show');

				$rangeslider.attr('data-inited', true);
			}
		}
	};
};
