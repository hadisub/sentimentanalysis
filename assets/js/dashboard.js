$(document).ready(function () {
	var data_latih = $("#jumlah-data-latih").text();
	var data_uji = $("#jumlah-data-uji").text();
	var data_latih_pos = $("#jumlah-data-latih-positif").text();
	var data_latih_neg = $("#jumlah-data-latih-negatif").text();
	
	Morris.Donut({
	element: 'latih-dan-uji-chart',
	data: [
		{label: "Data Latih", value: data_latih},
		{label: "Data Uji", value: data_uji}
	],
	colors: [
		'#4CB1CF',
		'#F0AD4E',
	]
	});
	
	Morris.Donut({
	element: 'pos-neg-chart',
	data: [
		{label: "Review Positif", value: data_latih_pos},
		{label: "Review Negatif", value: data_latih_neg}
	],
	colors: [
		'#5CB85C',
		'#F0433D',
	]
	});
});