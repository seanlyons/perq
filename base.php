<html>
    <script>
        var count=181;
        var counter=setInterval(timer, 1000); //1000 will  run it every 1 second    
        function timer() {
            count=count-1;
            if (count <= 0) {
                clearInterval(counter);
                document.getElementById("timer").innerHTML = 'Timer exhausted.'; // watch for spelling
                console.log('Your turn is over!');
                formsubmit();
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
        
        function input_onblur() {
            console.log('blurry!');
            console.log(this);
        }
        
        function formsubmit() {
            wordslist = new Array();
            words = document.getElementById('words').elements;
            for (i = 0; i < words.length; i++) {
                //Iterate through all of the ids, getting their row+col values.
                if (words[i]['value']) {
                    init = words[i]['id'].slice(4);
                    // row = init.slice( -1 );
                    // col = init.slice(0, init.indexOf("_"));
                    console.log('oh hello, ' + words[i]['value'] );
                    wordslist.push(words[i]['value']);
                }
            }
            score = parseWordslist( wordslist );
            return false;
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
            score = 0;
            base = 0;
            mult = 0;
            if (row == 3) {
                base = 50;
                mult = 10;
            } else if (row == 4) {
                base = 100;
                mult = 20;
            } else if (row == 5) {
                base = 150;
                mult = 50;
            } else if (row == 6) {
                base = 200;
                mult = 100;
            } else if (row == 7) {
                base = 350;
                mult = 150;
            } else if (row == 8) {
                base = 500;
                mult = 250;
            } else if (row == 9) {
                base = 500;
                mult = 1000;
            } else if (row == 10) {
                base = 0;
                mult = 1500;
            }
            score = base + (col * mult);
console.log(base+'+ ('+col+' * '+mult+') = '+score);
            return score;
        }

        
    </script>
</html>

<?PHP
$black = array(
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
$red = array(
    'BPNHFL',
    'SVWYQS',
    'KCGMJD',
);

//Display the letters on the dice.
$i = 0;
$display = '';
foreach ($black as $b) {
    $i++;
    $display .= substr($b, mt_rand(0, 5), 1);
}
$i = 0;
if (isset($_GET['red'])) {
    foreach ($red as $r) {
        $i++;
        $display .= substr($r, mt_rand(0, 5), 1);
    }
}
echo "<span id='letters' style='font-size:30px;'>$display</span>";

//Build out the input form.
?>
&nbsp;<button id="anagram" onclick="anagramify()" >&#8634;</button>
<?PHP 
    for ($i = 3; $i <= 10; $i++) {
?>
        <span type='text'  id='inp_head' style='position:absolute; top:40px; left:<?PHP echo ((($i - 3) * 197) + 45); ?>px;'><?PHP echo $i; ?> letters</span>
<?PHP
    }
?>
<span id="timer"></span>

<form id='words' onsubmit="return formsubmit();">
<?PHP
    for ($i = 3; $i <= 10; $i++) {
        for ($j = 1; $j <= 5; $j++) {
?>
        <input type='text' id='inp_<?PHP echo $i; ?>_<?PHP echo $j; ?>' onblur="input_onblur(); style='position:absolute; top:<?PHP echo ((($j - 1) * 30) + 70); ?>px; left:<?PHP echo  (($i - 3) * 200) + 10; ?>px;'>
<?PHP
        }
    }
?>
    <button id="score_button" style='position:absolute; top:220px; left:1500px;'>Rescore!</button>
    <input type="reset" style='position:absolute; top:220px; left:1412px;' value="Reset!">
    <input type="reset" id="next_turn" style='position:absolute; top:220px; left:1270px;' value="Next Turn" onclick="reload()">
</form>