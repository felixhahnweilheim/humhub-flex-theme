<?php

namespace humhub\modules\flexTheme\helpers;

class ColorHelper {
	
	public static function lighten($color, $percentage) {
        
		$color_parts = ColorHelper::getColorComponents($color);
		
		$return = '#';

        foreach ($color_parts as $color) {
            $color   = hexdec($color); // Convert to decimal
            $color   = $color + (255 - $color) * $percentage; // Adjust color
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        } 

        return $return;

	}
	
	public static function darken($color, $percentage) {
		
		$color_parts = ColorHelper::getColorComponents($color);
		
		$return = '#';

        foreach ($color_parts as $color) {
            $color   = hexdec($color); // Convert to decimal
            $color   = $color * (1 - $percentage); // Adjust color
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
