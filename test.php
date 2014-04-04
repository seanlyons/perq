<style>
	input[type="text"],
	.validation_box {
		/* position:relative;*/

	}
	input[type="text"] {
		width:35px;
		margin-left:20px;
	}
	.col_div {
		display:inline-block;
	}
	.j_1,
	.j_2,
	.j_3,
	.j_4,
	.j_5 {
		top:60px;
	}
	
	#col_3 {
		left:200px;
	}
	#col_4 {
		left:350px;
	}
	#col_5 {
		left:500px;
	}
	#col_6 {
		left:650px;
	}
	#col_7 {
		left:800px;
	}
	#col_8 {
		left:950px;
	}
	#col_9 {
		left:1100px;
	}
	#col_10 {
		left:1250px;
	}
	
</style>
<form id='words' onsubmit="return formsubmit();">
<?PHP
    $i = (isset($red)) ? 4 : 3;
    for (; $i <= 10; $i++) {
		echo "<div id='col_$i' class='col_div'>";
		
        for ($j = 1; $j <= 5; $j++) {
			$ij = "j_$j";
?>
        <input class='<?PHP echo $ij; ?>' type='text' onfocus="input_onfocus(this.id);" onblur="input_onblur(this);" value='<?PHP echo $ij; ?>'>
        <div class='validation_box v_j_<?PHP echo $j;?>'></div>
<?PHP
        }
		echo '</div>';
    }
?>
    <button id="score_button">Rescore!</button>
    <input id="reset" type="reset" value="Reset!">
    <input id="next_turn" type="reset" value="Next Turn" onclick="reload()">
</form>
<div id='words_you_missed'></div>