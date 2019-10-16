<?php

header ("Content-Type:text/css");

$color = "#FF6000"; // Change your Color Here
function checkhexcolor($color) {

    return preg_match('/^#[a-f0-9]{6}$/i', $color);

}
if( isset( $_COOKIE[ 'marsd_cosmos_color' ] ) AND $_COOKIE[ 'marsd_cosmos_color' ] != '' ) {
    $color = "#" . $_COOKIE[ 'marsd_cosmos_color' ];
    $colorWitoutHash = $_COOKIE[ 'marsd_cosmos_color' ];
}

if( isset( $_GET[ 'color' ] ) AND $_GET[ 'color' ] != '' ) {
    $color = "#" . $_GET[ 'color' ];
    $colorWitoutHash = $_GET[ 'color' ];
}

if( !$color OR !checkhexcolor( $color ) ) {
    $color = "#FF6000";
    $colorWitoutHash = 'FF6000';
}

echo "/*" . $color . "*/";
$fileName = $_SERVER["DOCUMENT_ROOT"] . "/local/modules/boxsol.cosmofashion/install/wizards/boxsol/cosmos/site/templates/cosmos/style_to_change_color.css";
if (!file_exists($fileName)) {
    $fileName = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/boxsol.cosmofashion/install/wizards/boxsol/cosmos/site/templates/cosmos/style_to_change_color.css";
}

$fileStyle = file_get_contents($fileName);
$fileStyle = str_replace('#THEME_COLOR#', $color, $fileStyle);
$newLighterColor = colourBrightness($color, 0.90);
$fileStyle = str_replace('#THEME_LIGHTER_COLOR#', $newLighterColor, $fileStyle);
echo $fileStyle;


function colourBrightness($hex, $percent) {
    // Work out if hash given
    $hash = '';
    if (stristr($hex,'#')) {
        $hex = str_replace('#','',$hex);
        $hash = '#';
    }
    /// HEX TO RGB
    $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
    //// CALCULATE
    for ($i=0; $i<3; $i++) {
        // See if brighter or darker
        if ($percent > 0) {
            // Lighter
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
        } else {
            // Darker
            $positivePercent = $percent - ($percent*2);
            $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
        }
        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    //// RBG to Hex
    $hex = '';
    for($i=0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        // Add a leading zero if necessary
        if(strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }
        // Append to the hex string
        $hex .= $hexDigit;
    }
    return $hash.$hex;
}
?>
