<html>
    <script>
        function anagramify() {
            var text = document.getElementById("letters").innerHTML;
            split = text.split("");
            rearranged = shuffle(split);
            back = rearranged.join("");
            document.getElementById("letters").innerHTML = back;
        }
        
        function shuffle(o){
            for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
            return o;
        }
        
        function formsubmit() {
            words = document.getElementById('words').elements;
            for (i = 0; i < words.length; i++) {
                //Iterate through all of the ids, getting their row+col values.
                if (words[i]['value']) {
                    init = words[i]['id'].slice(4);
                    row = init.slice( -1 );
                    col = init.slice(0, init.indexOf("_"));
                }
            }
            return false;
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
<button id="anagram" onclick="anagramify()" >&#8634;</button>
<?PHP 
    for ($i = 3; $i <= 10; $i++) {
?>
        <span type='text'  id='inp_head' style='position:absolute; top:40px; left:<?PHP echo ((($i - 3) * 197) + 45); ?>px;'><?PHP echo $i; ?> letters</span>
<?PHP
    }
?>
<form id='words' onsubmit="return formsubmit();">
<?PHP
    for ($i = 3; $i <= 10; $i++) {
        for ($j = 1; $j <= 5; $j++) {
?>
        <input type='text' id='inp_<?PHP echo $i; ?>_<?PHP echo $j; ?>' style='position:absolute; top:<?PHP echo ((($j - 1) * 30) + 70); ?>px; left:<?PHP echo  (($i - 3) * 200) + 10; ?>px;'>
<?PHP
        }
    }
?>
    <button id="score_button" style='position:absolute; top:220px; left:1500px;'>Score!</button>
</form>