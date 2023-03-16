<?php

namespace humhub\modules\flexTheme\helpers;

class ColorHelper {
	
    /* 
     * This function imitates the LESS function lighten()
     * But it does not convert the color into HSL and back because this is not necessary to achieve the same result.
     */
	public static function lighten($color, $amount, $relative = false) {
        
        /*
         * $color is expected to be a hexadecimal color code (including '#')
         * and has to be splitted into its components
         */
        $color_parts = ColorHelper::getColorComponents($color);
        
        // $amount is expected to be a number between 0 an 100
        $percentage = $amount / 100;
        
        // By default the LESS lighten() function adds the $amount absolutely to L, not relatively
        if (!$relative) {
           
            /* 
             * Converting a RGB color to HSL, the Lightness would be calculated by L = [max(R,G,B) + min(R,G,B)] / (2 * 255)
             * So we need $max and $min
             */
            $max = hexdec(max($color_parts));
            $min = hexdec(min($color_parts));
            if ($max !=0) {
			    $percentage = 2 * 255 * $percentage / ( $max + $min );
            }
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
	
    /*
     * Documentation, see lighten()
     */
	public static function darken($color, $amount, $relative = false) {
		
        $percentage = $amount / 100;
		$color_parts = ColorHelper::getColorComponents($color);
        $max = hexdec(max($color_parts));
		$min = hexdec(min($color_parts));
		
        if ($max == 0) {
            return '#000000';
        }
        
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
    
    public static function fade($color, $amount) {
       
        // $amount is expected to be between 0 and 100
        $opacity = ($amount / 100) * 255;
        $opacity = max(min($opacity, 255), 0); // keep between 0 and 255
        $opacity = str_pad(dechex($opacity), 2, '0', STR_PAD_LEFT); // make 2 char hex code
        
        // return RGBA as hex code
        return $color . $opacity;
    }
	
	protected static function getColorComponents($color) {
		
		// Remove leading '#'
		$hexstr = ltrim($color, '#');
		// if color has just 3 digits
        if (strlen($hexstr) == 3) {
            $hexstr = $hexstr[0] . $hexstr[0] . $hexstr[1] . $hexstr[1] . $hexstr[2] . $hexstr[2];
        }
		
		return str_split($hexstr, 2);
	}
}
