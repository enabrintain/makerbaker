<?php

class MakerLogic {
	public static function proposalVotePassed($responses) {
	        $num_yea = count($responses['Yea']);
	        $num_nay = count($responses['Nay']);
	        if ($num_nay > 1 || $num_nay >= $num_yea) {
	                return false;
	        }
	        return true;
	}
	public static function complaintVotePassed($responses) {
		$num_yea = count($responses['Yea']);
		$num_nay = count($responses['Nay']);
		if ($num_nay >= $num_yea) {
			return false;
		}
		return true;
	}

}

?>
