<?php

/**
 *
 * @category		modules
 * @package			oneforall
 * @author			WBCE Community
 * @copyright		2004-2009, Ryan Djurovich
 * @copyright		2009-2010, Website Baker Org. e.V.
 * @copyright		2019-, WBCE Community
 * @link			https://www.wbce.org/
 * @license			http://www.gnu.org/licenses/gpl.html
 * @platform		WBCE
 *
 */


// Resize PNG image
function resizePNG($source, $destination, $new_max_w, $new_max_h) {

	// Check if GD is installed
	if (extension_loaded('gd') AND function_exists('imagecreatefrompng')) {
		// First figure out the size of the image
		list($orig_w, $orig_h) = getimagesize($source);
		if ($orig_w > $new_max_w) {
			$new_w = $new_max_w;
			$new_h = intval($orig_h * ($new_w / $orig_w));
			if ($new_h > $new_max_h) {
				$new_h = $new_max_h;
				$new_w = intval($orig_w * ($new_h / $orig_h));
			}
		} else if ($orig_h > $new_max_h) {
			$new_h = $new_max_h;
			$new_w = intval($orig_w * ($new_h / $orig_h));
		} else {
			// Image to small to be downsized
			return false;
		}

		// Now make the image
		$source  = imagecreatefrompng($source);
		$dst_img = imagecreatetruecolor($new_w, $new_h);
		// Allow png transparency (full alpha channel information)
		imagealphablending($dst_img, false);
		imagesavealpha($dst_img, true);
		// Resizing
		imagecopyresampled($dst_img, $source, 0,0,0,0, $new_w, $new_h, $orig_w, $orig_h);
		imagepng($dst_img, $destination);
		// Clear memory
		imagedestroy($dst_img);
		imagedestroy($source);
		// Return true
		return true;
	} else {
   		return false;
	}
}


// Resize JPEG image
function resizeJPEG($source, $destination, $new_max_w, $new_max_h, $quality = 75) {

	if (function_exists('exif_read_data')) {
		$exif = exif_read_data($source);
	}

	if ($img = imagecreatefromjpeg($source)) {
	
		$orig_w = imagesx($img);
		$orig_h = imagesy($img);
		if ($orig_w > $new_max_w) {
			$new_w = $new_max_w;
			$new_h = intval($orig_h * ($new_w / $orig_w));
			if ($new_h > $new_max_h) {
				$new_h = $new_max_h;
				$new_w = intval($orig_w * ($new_h / $orig_h));
			}
		} else if ($orig_h > $new_max_h) {
			$new_h = $new_max_h;
			$new_w = intval($orig_w * ($new_h / $orig_h));
		} else {
			// Image to small to be downsized
			return false;
		}

		// Resize using appropriate function
		if (function_exists('imagecopyresampled')) {
			$new_img = imagecreatetruecolor($new_w, $new_h);
			imagecopyresampled($new_img, $img, 0,0,0,0, $new_w, $new_h, $orig_w, $orig_h);
		} else {
			$new_img = imagecreate($new_w , $new_h);
			imagecopyresized($new_img, $img, 0,0,0,0, $new_w, $new_h, $orig_w, $orig_h);
		}
		imagedestroy($img); // Free original image

		if (!empty($exif['Orientation'])) {
			switch ($exif['Orientation']) {
				case 3:
					$new_img = imagerotate($new_img, 180, 0);
					break;
				case 6:
					$new_img = imagerotate($new_img, -90, 0);
					break;
				case 8:
					$new_img = imagerotate($new_img, 90, 0);
					break;
			}
		}
		imagejpeg($new_img, $destination, $quality);
		imagedestroy($new_img);
	}
}

?>