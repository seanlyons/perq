<html>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="perq.js"></script>
	<link rel="stylesheet" href="perq.css">
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
<button id="anagram" onclick="anagramify()" >
    &#8634;
</button>

<form id='master_input' onsubmit="return delegate_words();">
    <input type='text' id='mi'>
    <button id="delegate_submit" style='position:absolute; top:13px; left:400px;'>Delegate!</button>
</form>

<?PHP 
    $i = (isset($red)) ? 4 : 3;
    for (; $i <= 10; $i++) {
?>
        <span type='text'  id='inp_head' style='left:<?PHP echo ((($i - 3) * 197) + 45); ?>px;'><?PHP echo $i; ?> letters</span>
<?PHP
    }
?>
<span id="timer"></span>

<form id='words' onsubmit="return formsubmit();">
<?PHP
    $i = (isset($red)) ? 4 : 3;
    for (; $i <= 10; $i++) {
        for ($j = 1; $j <= 5; $j++) {
            $id = 'inp_'.$i.'_'.$j;
?>
        <input class='words_input' type='text' id='<?PHP echo $id; ?>' onfocus="input_onfocus(this.id);" onblur="input_onblur(this);" style='top:<?PHP echo ((($j - 1) * 30) + 70); ?>px; left:<?PHP echo  (($i - 3) * 200) + 10; ?>px;'>
        <div style="top:<?PHP echo ((($j - 1) * 30) + 75); ?>px; left:<?PHP echo  (($i - 3) * 200) + 165; ?>px;" class='validation_box' id='valid_<?PHP echo $id; ?>'></div>
<?PHP
        }
    }
?>
    <button id="score_button">Rescore!</button>
    <input id="reset" type="reset" value="Reset!">
    <input id="next_turn" type="reset" value="Next Turn" onclick="reload()">
</form>
<div id='words_you_missed'></div>