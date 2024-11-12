<?php

class MiBD extends SQLite3
{
	function __construct()
	{
		$this->open('bd_concejos.db');
	}
}

$bd = new MiBD();


$query = $bd->query("select * from local_c_comunales where id_Comuna='$_GET[comuna]'");
$states = array();
while ($r = $query->fetchArray()) {
	$states[] = $r;
}

if (count($states) > 0) {
	print '<option value="">Seleccione..</option>';

	foreach ($states as $s) {
		print "<option value='$s[8]'>&nbsp;$s[1]</option>";
	}
}
