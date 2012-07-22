<?php defined('SYSPATH') or die('No direct script access.');
 
class gen_Core {
	
	public static function display_date($tps)
	{
		return date('H\:i\:s', $tps);
	}
	
	public static function time_left($tps)
	{
		if ($tps > 0) {
			$res = "";
			$plurals = array(
				0 => array('seconde', 'secondes'),
				1 => array('minute', 'minutes'),
				2 => array('heure', 'heures'),
				3 => array('jour', 'jours'),
				4 => array('mois', 'mois'),
				5 => array('an', 'ans')
			);
			$tps = max(1, time() - $tps);
			if ($tps < 60) $cat = 0;
			else {
				$tps = floor($tps/60);
				if ($tps < 60) $cat = 1;
				else {
					$tps = floor($tps/60);
					if ($tps < 24) $cat = 2;
					else {
						$tps = floor($tps/24);
						if ($tps < 30) $cat = 3;
						else {
							$tps = floor($tps/30);
							if ($tps < 12) $cat = 4;
							else {
								$tps = floor($tps/12);
								$cat = 5;
							}
						}
					}
				}
			}
			$duree = ($tps == 1) ? $plurals[$cat][0] : $plurals[$cat][1] ;
			$final = $tps.' '.$duree;
		} else {$final = '-';}
		return $final;
	}
}