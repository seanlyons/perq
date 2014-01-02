<html>
    <script>
        var currentFocus;
        var count = 2;
        var counter = setInterval(timer, 1000); //1000 will  run it every 1 second    
        var columns_filled = new Array();
        
        function timer() {
            count--;
            if (count <= 0) {
                clearInterval(counter);
                document.getElementById("timer").innerHTML = 'Timer exhausted.';
                formsubmit();
				console.log('calling get_words_you_missed:');
				get_words_you_missed();
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
console.log('position = '+ position +' on ch = '+ ch +' for text = '+ text);
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
console.log('id = ' + id);
                val = document.getElementById( id ).value;
                if ( ! val ) {
                    document.getElementById(id).value = mi;
                    document.getElementById("valid_" + id ).style.background = 'green';
                    return false;
                }
            }
            return false;
            
        }

		function get_words_you_missed() {
			console.log('yay here0');
			var xhReq = new XMLHttpRequest();
			console.log('yay here1');
			xhReq.open("GET", "http://sean.hexault.com/perquackey/get_anagram_words.php?abcasdwe", true);
			console.log('yay here2');
			xhReq.send({'foo':'bar'});
			console.log('yay here3');
			var serverResponse = xhReq.responseText;
			console.log('yay here4');
			console.log(serverResponse); // Shows "15"
		
		
		
			missed = new Array();//ajax request to /get_anagram_words.php
			gotten = getWordsArray();
			// for (i = 0; i < missed.length; i++) {
			
			return missed;			
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
                if (words[i]['id'].slice(0, 4) != 'inp_' && words[i]['value']) {
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
                console.log('word ' + word + ' is worth ' + word_score + ' >> ' + turn_score);
            }
            alert('You scored ' + turn_score + ' points this turn.');
            
            return turn_score;
        }
        
        function getScore( row, col ) {
            base = 0;
            add = 0;
            if (row == 3) {
                base = 50;
                add = 10;
            } else if (row == 4) {
                base = 100;
                add = 20;
            } else if (row == 5) {
                base = 150;
                add = 50;
            } else if (row == 6) {
                base = 200;
                add = 100;
            } else if (row == 7) {
                base = 350;
                add = 150;
            } else if (row == 8) {
                base = 500;
                add = 250;
            } else if (row == 9) {
                base = 500;
                add = 1000;
            } else if (row == 10) {
                base = 0;
                add = 1500;
            }
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
    </script>
</html>

<?PHP
$black_dice = array(
    'MOCOWP',
    'EEAAAE',
    'UNTFPI',
    'HRFUIS',
    'ZJQVEX',
    'LTNDRO',
    'WLYBOO',
    'EEEAAA',
    'KRHBIT',
    'MRISGU',
);
$red_dice = array(
    'BPNHFL',
    'SVWYQS',
    'KCGMJD',
);

//Display the letters on the dice.
$i = 0;
$display = '';
foreach ($black_dice as $b) {
    $i++;
    $display .= substr($b, mt_rand(0, 5), 1);
}
$i = 0;
if (isset($_GET['red'])) {
    $red = TRUE;
}
if (isset($red)) {
    foreach ($red_dice as $r) {
        $i++;
        $letter = substr($r, mt_rand(0, 5), 1);
        $display .= $letter;
    }
}
echo "<span id='letters' style='font-size:30px;'>$display</span>";

//Build out the input form.
?>
&nbsp;
<button style="position:relative; bottom:5px;" id="anagram" onclick="anagramify()" >
    &#8634;
</button>

<form id='master_input' onsubmit="return delegate_words();">
    <input type='text' id='mi' style='position:absolute; top:13px; left:260px;'>
    <button id="delegate_submit" style='position:absolute; top:13px; left:400px;'>Delegate!</button>
</form>

<?PHP 
    $i = (isset($red)) ? 4 : 3;
    for (; $i <= 10; $i++) {
?>
        <span type='text'  id='inp_head' style='position:absolute; top:40px; left:<?PHP echo ((($i - 3) * 197) + 45); ?>px;'><?PHP echo $i; ?> letters</span>
<?PHP
    }
?>
<span id="timer" style="float:right; background:cyan; "></span>

<form id='words' onsubmit="return formsubmit();">
<?PHP
    $i = (isset($red)) ? 4 : 3;
    for (; $i <= 10; $i++) {
        for ($j = 1; $j <= 5; $j++) {
            $id = 'inp_'.$i.'_'.$j;
?>
        <input type='text' id='<?PHP echo $id; ?>' onfocus="input_onfocus(this.id);" onblur="input_onblur(this);" style='position:absolute; top:<?PHP echo ((($j - 1) * 30) + 70); ?>px; left:<?PHP echo  (($i - 3) * 200) + 10; ?>px;'>
        <div style="width:10px; height:10px; background:orange; position:absolute; top:<?PHP echo ((($j - 1) * 30) + 75); ?>px; left:<?PHP echo  (($i - 3) * 200) + 165; ?>px;" class='validation_box' id='valid_<?PHP echo $id; ?>'></div>
<?PHP
        }
    }
?>
    <button id="score_button" style='position:absolute; top:220px; left:1500px;'>Rescore!</button>
    <input type="reset" style='position:absolute; top:220px; left:1412px;' value="Reset!">
    <input type="reset" id="next_turn" style='position:absolute; top:220px; left:1270px;' value="Next Turn" onclick="reload()">
</form>
<div id='wordsyoumissed'></div>