//datepicker ui settings
$(document).ready(function(){
	var today = new Date();
	var studentLastDate = new Date(today.getFullYear() -15, 1, 1);
	var professionalLastDate = new Date(today.getFullYear() -18, 1, 1);
	
	$("#event_start_date").datepicker({
		dateFormat : 'dd/mm/yy',
		changeMonth: true,
	    changeYear: true, 
	    maxDate: new Date(today-100, 1,1),
	    hideIfNoPrevNext: true,
	    yearRange:  "-100:+0"
	}).val();
	$("#event_end_date").datepicker({
		dateFormat : 'dd/mm/yy',
		changeMonth: true,
	    changeYear: true, 
	    maxDate: professionalLastDate,
	    maxDate: new Date(today-100, 1,1),
	    hideIfNoPrevNext: true,
	    yearRange: '-100:+0'
	}).val();
	
	$("#registration_start_date").datepicker({
		dateFormat : 'dd/mm/yy',
		changeMonth: true,
	    changeYear: true, 
	    maxDate: professionalLastDate,
	    maxDate: new Date(today-100, 1,1),
	    hideIfNoPrevNext: true,
	    yearRange: '-100:+0'
	}).val();
	
	$("#registration_end_date").datepicker({
		dateFormat : 'dd/mm/yy',
		changeMonth: true,
	    changeYear: true, 
	    maxDate: professionalLastDate,
	    maxDate: new Date(today-100, 1,1),
	    hideIfNoPrevNext: true,
	    yearRange: '-100:+0'
	}).val();
	
	$("#payment_date_deadline").datepicker({
		dateFormat : 'dd/mm/yy',
		changeMonth: true,
	    changeYear: true, 
	    maxDate: professionalLastDate,
	    maxDate: new Date(today-100, 1,1),
	    hideIfNoPrevNext: true,
	    yearRange: '-100:+0'
	}).val();
	
	$("#dob").datepicker({
		dateFormat : 'dd/mm/yy',
		changeMonth: true,
	    changeYear: true, 
	    maxDate: professionalLastDate,
	    maxDate: new Date(today-100, 1,1),
	    hideIfNoPrevNext: true,
	    yearRange: '-100:+0'
	}).val();
	
	
});