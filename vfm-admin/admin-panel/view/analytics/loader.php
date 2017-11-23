<?php
/**
* Generate random rgb color
*
* @return rgb color
*/ 
function hex2rgb($hex) 
{
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    $rgb = array($r, $g, $b);
    return implode(",", $rgb); // returns the rgb values separated by commas
    //return $rgb; // returns an array with the rgb values
}

/**
* Generate random rgb color
*
* @return color
*/ 
function randomColor() 
{
    $color = mt_rand(0, 255).",".mt_rand(0, 255).",".mt_rand(0, 255);
    return $color;
}
// $colorplay = randomColor();
// $colordown = randomColor();
$colorplay = hex2rgb('#f09927');
$colordown = hex2rgb('#16b5de');
?>
<script type="text/javascript" src="js/datatables.js"></script>
<script type="text/javascript" src="admin-panel/plugins/chartjs/Chart.min.js"></script>

<script>
    var pieData = [
            {
                value: <?php echo $numup; ?>,
                color:"#5cb85c",
                highlight: "#32b836",
                title: "<?php print $encodeExplorer->getString('add'); ?> ",
                label: "<?php print $encodeExplorer->getString('add'); ?> "
            },
            {
                value : <?php echo $numdown; ?>,
                color : "#5bc0de",
                highlight: "#16b5de",
                title: "<?php print $encodeExplorer->getString('download'); ?>",
                label: "<?php print $encodeExplorer->getString('download'); ?>"
            },
            {
                value : <?php echo $numdel; ?>,
                color : "#d9534f",
                highlight: "#d9211e",
                title: "<?php print $encodeExplorer->getString('remove'); ?>",
                label: "<?php print $encodeExplorer->getString('remove'); ?>"
            },
            {
                value : <?php echo $numplay; ?>,
                color : "#f0ad4e",
                highlight: "#f09927",
                title: "<?php print $encodeExplorer->getString('play'); ?>",
                label: "<?php print $encodeExplorer->getString('play'); ?>"
            },
        ];

    var polarDataPlay = [
    <?php 
    arsort($polarplay);
    $highest = (!empty($polarplay) ? max($polarplay) : 1);

    foreach ($polarplay as $key => $value) {
        $gradient = $value/$highest;
        echo "{ value: ".$value.",";
        echo "label: '".$key."',";
        echo "title: '".$key."',";
        echo "color:\"rgba(".$colorplay.",".$gradient.")\",";
        echo "highlight:\"rgba(".$colorplay.",0.6)\"},";
    } ?>
    ];

    var polarDataDown = [
    <?php 

    arsort($polardown);
    $highest = (!empty($polardown) ? max($polardown) : 1);

    foreach ($polardown as $key => $value) {
        $gradient = $value/$highest;
        echo "{ value: ".$value.",";
        echo "label: '".$key."',";
        echo "title: '".$key."',";
        echo "color:\"rgba(".$colordown.",".$gradient.")\",";
        echo "highlight:\"rgba(".$colordown.",0.6)\"},";
    } ?>
    ];
    $(".num-play").html('(<?php echo $numplay; ?>)');
    $(".num-down").html('(<?php echo $numdown; ?>)');
    <?php
    if ($numdown < 1) {
        echo "$(\"#chart-download\").remove();";
    }
    if ($numplay < 1) {
        echo "$(\"#chart-play\").remove();";
    } ?>

</script>
<script type="text/javascript" src="admin-panel/js/statistics.js"></script>