$(function(){
	
	$.validator.setDefaults({
		errorClass:"help-block",
		highlight: function(element){
			$(element).closest(".form-group").addClass("has-error");
		},
		unhighlight: function(element){
			$(element).closest(".form-group").removeClass("has-error");
		}
	});
	

	//DATASET
	$("#formdataset").validate({
		rules:{
			judulreview: {
				required: true,
				maxlength: 100,
				
			},
			teksreview: {
				required: true,
				maxlength: 7500
			}
		},
		messages:{
			judulreview:{
				required: "Judul review tidak boleh kosong.",
				maxlength: "Judul review tidak boleh melebihi 100 karakter."
			},
			teksreview: {
				required: "Isi review tidak boleh kosong.",
				maxlength: "Isi review tidak boleh melebihi 7500 karakter"
			}
		},
		submitHandler: function(form){
			form.submit();
		}
	});

	//KATA DASAR
	$("#formkatadasar").validate({
		rules:{
			katadasarbaru: {
				required: true,
				maxlength: 30,
				nowhitespace: true,
				lettersonly: true				
			}
		},
		messages:{
			katadasarbaru: {
				required: "Kata dasar tidak boleh kosong.",
				maxlength: "Kata dasar tidak boleh melebihi 30 karakter."
			}
		},
		submitHandler: function(form){
			form.submit();
		}
	});

	//STOP WORDS
	$("#formstopwords").validate({
		rules:{
			stopwordsbaru: {
				required: true,
				maxlength: 30,
				nowhitespace: true,
				lettersonly: true				
			}
		},
		messages:{
			stopwordsbaru: {
				required: "Stop words tidak boleh kosong.",
				maxlength: "Stop words tidak boleh melebihi 30 karakter."
			}
		},
		submitHandler: function(form){
			form.submit();
		}
	});
});