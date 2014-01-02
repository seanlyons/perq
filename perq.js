var currentFocus;
var count = 12;
var counter = setInterval(timer, 1000); //1000 will  run it every 1 second
var columns_filled = new Array();

function timer() {
	count--;
	if (count <= 0) {
		clearInterval(counter);
		document.getElementById("timer").innerHTML = 'Timer exhausted.';
		formsubmit();
		console.log('calling get_words_you_missed:');
		missed = get_words_you_missed();
		build_out_missed(missed);
		return;
	}
	secs = ("0" + Math.floor(count % 60)).slice(-2);
	remaining = Math.floor(count/60) + ":" + secs + ' remaining';
	document.getElementById("timer").innerHTML = remaining; // watch for spelling
}

function anagramify() {
	var text = document.getElementById("letters").innerHTML;
	split = text.split("");
	rearranged = shuffle(split);
	back = rearranged.join("");
	document.getElementById("letters").innerHTML = back;
}
function reload() {
	location.reload(true);
}

function shuffle(o){
	for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	return o;
}

function input_onfocus(id) {
	document.getElementById( 'valid_' + id ).style.background = 'orange';
}

function input_onblur(ele) {
	value = ele.value;
	id = ele.id;

	if ( ! value) {
		return;
	}
	color = (is_word_valid(value)) ? 'green' : 'red';
	v = 'valid_' + id;
	document.getElementById(v).style.background = color;
}

function is_word_valid(word) {
	word = word.toUpperCase();
	text = document.getElementById("letters").innerHTML;
	for( i = 0; i < word.length; i++)
	{
		//ch is the Nth character in the word
		ch = word.charAt(i);
		//Now we have to locate that character in `text` and remove it, or throw an error.
		position = text.indexOf(ch);
		if (position == -1) {
			return false;
		} else {
			slice1 = text.slice(0, position);
			slice2 = text.slice(position + 1, text.length);
			text = slice1 + slice2;
		}
	}
	return true;
}

function delegate_words() {
	mi = document.getElementById('mi').value;
	if ( ! mi ) {
		return false;
	}
	document.getElementById("mi").value = '';
	if ( ! is_word_valid(mi)) {
		return false;
	}
	//Word is valid; let's insert it into the appropriate spot.
	row = mi.length;
	for (i = 1; i <= 5; i++) {
		id = "inp_"+row+'_'+i;
		val = document.getElementById( id ).value;
		if ( ! val ) {
			document.getElementById(id).value = mi;
			document.getElementById("valid_" + id ).style.background = 'green';
			return false;
		}
	}
	return false;

}

function build_out_missed( missed ) {
	split = jQuery.parseJSON(missed);
	miss_string = '';
	console.log(split);
	for (var i in split) {
		miss_string = miss_string + split[i] + '<br/>'
	}
	console.log(miss_string);
	document.getElementById("words_you_missed").innerHTML = miss_string;
}

function get_words_you_missed() {
	letters = document.getElementById("letters").innerHTML;

	return $.ajax({ type: "GET",
		url: "perquackey/get_anagram_words.php?" + letters,
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		async: false
	}).responseText;
}

function formsubmit() {
	wordslist = new Array();
	wordslist = getWordsArray();
	score = parseWordslist( wordslist );
	return false;
}

function getWordsArray() {
	words = document.getElementById('words').elements;
	for (i = 0; i < words.length; i++) {
		//Iterate through all of the ids, getting their row+col values.
		if (words[i]['id'].slice(0, 4) == 'inp_' && words[i]['value']) {
			wordslist.push(words[i]['value']);
		}
	}
	return wordslist;
}

function parseWordslist( w ) {
	quant_letters = 0;
	quant_count = 0;
	word = '';
	turn_score = 0;
	for (i = 0; i < w.length; i++) {
		word = w[i];
		if (word.length != quant_letters) {
			quant_letters = word.length;
			quant_count = 0;
		}
		quant_count++;
		word_score = getScore(word.length, quant_count);
		turn_score += word_score;
	}
	alert('You scored ' + turn_score + ' points this turn.');

	return turn_score;
}

function getScore( col, row) {
	base = 0;
	add = 0;
	if (col == 3) {
		base = 50;
		add = 10;
	} else if (col == 4) {
		base = 100;
		add = 20;
	} else if (col == 5) {
		base = 150;
		add = 50;
	} else if (col == 6) {
		base = 200;
		add = 100;
	} else if (col == 7) {
		base = 350;
		add = 150;
	} else if (col == 8) {
		base = 500;
		add = 250;
	} else if (col == 9) {
		base = 500;
		add = 1000;
	} else if (col == 10) {
		base = 0;
		add = 1500;
	}
console.log(col +', '+ row);
	if (row == 1) {
		return base;
	} else {
		return add;
	}
	//TODO: add bonuses.
}

// Array Remove - By John Resig (MIT Licensed)
Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};