(function($) {
	/**
	 * Number input plugin
	 */
	'use strict';

	// var $el, el;

	function NumberInput(el) {
		this.$el = $(el);
		this.el = el;

		this.initialize();
	}

	/**
	 * initialize
	 */
	NumberInput.prototype = {

		constructor: NumberInput,

		initialize: function() {
			var _this = this;

			this.$el.on('focus', function() {
				_this.handleFocus();
			});
			this.$el.on('blur', function() {
				_this.handleBlur();
			});
		},

		handleFocus: function() {
			// this.el.value = this.getValue() || '';
			var value = this.getValue() || '';
			// var decimalSeparator = this.el.getAttribute('data-decimal-separator');

			// value = value.replace('.', decimalSeparator);
			this.el.value = value;
		},

		/**
		 * on Input Blur
		 * add prefix and suffix if any
		 */
		handleBlur: function() {
			// var el = e.currentTarget;
			var prefix, suffix;
			var value = this.el.value;

			// set value
			this.setValue(value);

			prefix = this.el.getAttribute('data-prefix');
			suffix = this.el.getAttribute('data-suffix');

			if (prefix) {
				value = prefix + value;
			}

			if (suffix) {
				value = value + suffix;
			}

			// what you see
			this.el.value = value;
		},

		setValue: function(value) {
			value = value || '';

			// save data with decimal separator is '.'
			value = value.replace(',', '.');

			this.el.setAttribute('data-value', value);
		},

		getValue: function() {
			// return parseFloat(this.el.getAttribute('data-value')) || '';
			var value = this.el.getAttribute('data-value') || '';
			var decimalSeparator = this.el.getAttribute('data-decimal-separator') || ',';

			value = value.replace('.', decimalSeparator);

			return value; // parseFloat(value);

		}
	};

	function Plugin() {

		var chain = this.each(function() {
			var $this = $(this);
			var data = $this.data('numberInput');

			if (!data) {
				$this.data('numberInput', new NumberInput(this));
			}

		});

		return chain;
	}

	$.fn.numberInput = Plugin;
	$.fn.numberInput.Constructor = NumberInput;

})(jQuery);