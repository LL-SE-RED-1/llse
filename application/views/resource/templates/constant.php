<?php
$terms = [TERM_SPRING => '春', TERM_SUMMER => '夏', TERM_AUTUMN => '秋', TERM_WINTER => '冬', 
	TERM_SUMMER_SHORT => '暑假', TERM_WINTER_SHORT => '寒假', TERM_SPRING_SUMMER => '春夏', 
	TERM_AUTUMN_WINTER => '秋冬'];

function year_format($year){
	return intval($year).'-'.(intval($year) + 1);
}

$roles = [ROLE_TEACHER => "teacher", ROLE_STUDENT => "student"];
?>