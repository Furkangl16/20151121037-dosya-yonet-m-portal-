<?php 
/**
 * VFM - veno file manager: include/disk-space.php
 * user's used space bar
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013-2015 Nicola Franchini
 * @license   Standard License http://codecanyon.net/licenses/standard
 * @link      http://localhost
 */

/**
*
* Show user used space
*
*/
if ($gateKeeper->getUserInfo('dir') !== null
    && $gateKeeper->getUserInfo('quota') !== null
    && $gateKeeper->isAllowed('upload_enable') 
    && isset($_SESSION['vfm_user_used'])
) {

    $_USED = $_SESSION['vfm_user_used'];
    $maxsize = $gateKeeper->getUserInfo('quota');
    $maxsize = $maxsize*1048576;

    $division = $_USED / $maxsize;
    $rest = $maxsize - $_USED;
    
    if ($division > 1) {
        $division = 1;
    }
    if ($rest < 0) {
        $rest = 0;
    }

    $perc = round($division * 100, 2);

    if ($perc < 0) {
        $perc = 0;
    }
    if ($perc <= 60) {
        $progressclass = "progress-bar-info";
    } elseif ($perc > 60 && $perc <= 90) {
        $progressclass = "progress-bar-warning";
    } elseif ($perc > 90) {
        $progressclass = "progress-bar-danger";
    } ?>
    <div class="vfmblock">
        <div class="text-center">
            <span class="pull-left small">
                <i class="fa fa-circle"></i> <?php print $setUp->formatSize($_USED); ?>
            </span>
            <span class="pull-right small">
                <?php print $setUp->formatSize($rest); ?> <i class="fa fa-circle-o"></i>
            </span>
        </div>
    </div>
    <div class="vfmblock fullp">
        <div class="progress">
            <div class="progress-bar <?php print $progressclass; ?>" role="progressbar" 
                aria-valuenow="<?php print $perc; ?>" aria-valuemin="0" aria-valuemax="200" 
                style="width: <?php print $perc; ?>%;">
                <?php print $perc; ?>%
            </div>
        </div>
    </div>
    <?php
} ?>