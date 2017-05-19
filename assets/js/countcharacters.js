function count_review(obj){
	var counter = obj.value.length;
	document.getElementById('countreviewchar').innerHTML = counter;
	if(counter>7500){
		document.getElementById('countreviewchar').style.color = 'red';
	}
	else{
		document.getElementById('countreviewchar').style.color = 'grey';
	}
}

function count_katdas(kata){
	var counter = kata.value.length;
	document.getElementById('countkatdaschar').innerHTML = counter;
	if(counter>30){
		document.getElementById('countkatdaschar').style.color = 'red';
	}
	else{
		document.getElementById('countkatdaschar').style.color = 'grey';
	}
}

function count_stopwords(stopw){
	var counter = stopw.value.length;
	document.getElementById('countstopwordschar').innerHTML = counter;
	if(counter>30){
		document.getElementById('countstopwordschar').style.color = 'red';
	}
	else{
		document.getElementById('countstopwordschar').style.color = 'grey';
	}
}

function count_visitor_review(review){
	var counter = review.value.length;
	document.getElementById('count-visitor-review').innerHTML = counter;
	if(counter>7500){
		document.getElementById('count-visitor-review').style.color = 'red';
	}
	else{
		document.getElementById('count-visitor-review').style.color = 'grey';
	}
}