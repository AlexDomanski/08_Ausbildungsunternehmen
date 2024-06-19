<?php
function loescheVZ(string $root="./"):bool {
	$r = true;
	
	if(file_exists($root)) {
		$inhalt = scandir($root);
		foreach($inhalt as $d) {
			if($d!="." && $d!="..") {
				if(is_dir($root.$d)) {
					$r = $r && loescheVZ($root.$d."/");
				}
				else {
					$r = $r && unlink($root.$d);
					//ta("versuche zu löschen (Datei/Verknüpfung): ".$root.$d);
				}
			}
		}
		
		if($r) {
			$r = $r && rmdir($root);
			//ta("versuche zu löschen (Verzeichnis): ".$root);
		}
	}
	
	return $r;
}
?>