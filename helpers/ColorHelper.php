<?php

namespace humhub\modules\flexTheme\helpers;

class ColorHelper {
	
	public static function lighten($color, $amount, $relative = false) {
        
        $percentage = $amount / 100;
		$color_parts = ColorHelper::getColorComponents($color);
		$max = hexdec(max($color_parts));
		$min = hexdec(min($color_parts));
		
		if (!$relative) {
			$percentage = 2 * 255 * $percentage / ( $max + $min );
		}
        
		$return = '#';

        foreach ($color_parts as $color) {
            $color   = hexdec($color); // Convert to decimal
            $color   = round( $color + (255 - $color) * $percentage); // Adjust color
            $color   = max(min($color,255),0); // keep between 0 and 255
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        } 

        return $return;

	}
	
	public static function darken($color, $amount, $relative = false) {
		
        $percentage = $amount / 100;
		$color_parts = ColorHelper::getColorComponents($color);
        $max = hexdec(max($color_parts));
		$min = hexdec(min($color_parts));
		
		if (!$relative) {
			$percentage = 2 * 255 * $percentage / ( $max + $min );
		}
        
		$return = '#';

        foreach ($color_parts as $color) {
            $color   = hexdec($color); // Convert to decimal
            $color   = round( $color * (1 - $percentage)); // Adjust color
            $color   = max(min($color,255),0); // keep between 0 and 255
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        } 

        return $return;
		
	}
	
	public static function getColorComponents($color) {
		
		// Remove leading '#'
		$hexstr = ltrim($color, '#');
		// if colors has just 3 digits
        if (strlen($hexstr) == 3) {
            $hexstr = $hexstr[0] . $hexstr[0] . $hexstr[1] . $hexstr[1] . $hexstr[2] . $hexstr[2];
        }
		
		return str_split($hexstr, 2);
	}
}
