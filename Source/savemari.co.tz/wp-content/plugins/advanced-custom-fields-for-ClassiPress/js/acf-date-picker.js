jQuery(document).ready(function($) {

	$.acf_date = $.datepicker.regional[dateOptions.locale];

	if (dateOptions.date_format != "")
		$.acf_date.dateFormat = dateOptions.date_format;

	$.acf_date.showAnim = dateOptions.animation;

	if (dateOptions.multi_month) {
		$.acf_date.numberOfMonths = parseInt(dateOptions.multi_month, 10);
	}

	$.acf_date.minDate = dateOptions.minDate;
	$.acf_date.maxDate = dateOptions.maxDate;

	if (dateOptions.yearRange) {
		$.acf_date.yearRange = dateOptions.yearRange;
	}

	if (dateOptions.button_bar) {
		$.acf_date.showButtonPanel = true;
	}

	if (dateOptions.menus) {
		$.acf_date.changeMonth = true;
		$.acf_date.changeYear = true;
	}

	if (dateOptions.other_dates) {
		$.acf_date.showOtherMonths = true;
		$.acf_date.selectOtherMonths = true;
	}

	if (dateOptions.icon_trigger) {
		$.acf_date.showOn = "both";
		if( typeof dateOptions.buttonImage != 'undefined' ) {
			$.acf_date.buttonImage = dateOptions.buttonImage;
			$.acf_date.buttonImageOnly = false;
		} else {
			$.acf_date.buttonText = dateOptions.buttonText;
			$.acf_date.buttonImageOnly = false;
		}
	}

	$(".dateCustom").datepicker($.acf_date);
	$("body:not(.page-template-tpl-registration-php) .dateCustom").css({ 'max-width' : '90%' });
	$("body.page-template-tpl-registration-php .dateCustom").prev('label').css({ 'max-width' : '90%' });
	$(".dateCustom").parent().css({ 'position' : 'relative' });
});