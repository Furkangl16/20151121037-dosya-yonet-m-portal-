<?php
/**
 * VFM - veno file manager: include/downloader.php
 * Show download buttons for shared links
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013-2016 Nicola Franchini
 * @license   Standard License http://codecanyon.net/licenses/standard
 * @link      http://localhost
 */

/**
* Downloader
*/
$expired = false;
global $getfilelist;

if ($getfilelist && file_exists('vfm-admin/shorten/'.$getfilelist.'.json')) {

    $datarray = json_decode(file_get_contents('vfm-admin/shorten/'.$getfilelist.'.json'), true);
    $passa = true;
    
    if ($setUp->getConfig('enable_prettylinks') == true) {
        $zip_url = "download/dl/".$getfilelist;
    } else {
        $zip_url = "vfm-admin/vfm-downloader.php?dl=".$getfilelist;
    }
    
    $pass = (isset($datarray['pass']) ? $datarray['pass'] : false);

    if ($pass) { 
        $passa = false;
        $postpass = filter_input(INPUT_POST, "dwnldpwd", FILTER_SANITIZE_STRING);
        if (md5($postpass) === $pass) {
            $passa = true;
            $zip_url .= "&pw=".urlencode($postpass);
        }
    }

    $hash = $datarray['hash'];
    $time = $datarray['time'];
        
    if ($passa === true) {    

        $countfiles = 0;
        
        if ($downloader->checkTime($time) == true) { ?>
            <div class="intero centertext bigzip">
                <a class="btn btn-primary btn-lg centertext" href="<?php echo $zip_url; ?>">
                    <i class="fa fa-cloud-download fa-5x"></i><br>
                    .zip
                </a>
            </div>
            
            <div class="intero">
                <ul class="multilink">
            <?php

            $pieces = explode(",", $datarray['attachments']);

            $totalsize = 0;
            $salt = $setUp->getConfig('salt');

            foreach ($pieces as $pezzo) {

                $myfile = urldecode(base64_decode($pezzo));

                if (file_exists($myfile)) {

                    $countfiles++;

                    $filepathinfo = Utils::mbPathinfo($myfile);
                    $filename = $filepathinfo['basename'];
                    $extension = strtolower($filepathinfo['extension']);
                    $supah = md5($hash.$salt.$pezzo);
                    $filesize = File::getFileSize($myfile);
                    $totalsize += $filesize;
                    if (array_key_exists($extension, $_IMAGES)) {
                        $thisicon = $_IMAGES[$extension];
                    } else {
                        $thisicon = "fa-file-o";
                    }
                    
                    if ($setUp->getConfig('enable_prettylinks') == true) {
                        $downlink = "download/".$pezzo."/h/".$hash."/sh/".$supah;
                    } else {
                        $downlink = "vfm-admin/vfm-downloader.php?q=".$pezzo."&h=".$hash."&sh=".$supah;
                    } ?>

                    <li>
                        <a class="btn btn-primary" href="<?php echo $downlink; ?>">
                            <span class="pull-left small">
                                <i class="fa <?php echo $thisicon; ?> fa-2x"></i> <?php echo $filename; ?>
                            </span>
                            <span class="pull-right small">
                                <?php echo $setUp->formatsize($filesize); ?> <i class="fa fa-download fa-2x"></i>
                            </span>
                        </a>
                    </li>
                    <?php
                }
            }
            print "</ul></div>";

            // if more than 1 file file exists create a zip
            if (strlen($countfiles > 1)) {
                // check number of files and total size 
                // if under the limits, show the zip button
                $max_zip_filesize = $setUp->getConfig('max_zip_filesize');
                $max_zip_files = $setUp->getConfig('max_zip_files');
                $totalsize = $totalsize/1024/1024;
                $totalfiles = $countfiles;

                if ($totalsize <= $max_zip_filesize && $totalfiles <= $max_zip_files) { ?>
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $('.bigzip').fadeIn();
                    });
                    </script>
                    <?php
                }
            }
        } 
        // download link time expired
        // or no more file available
        if (strlen($countfiles < 1) || $downloader->checkTime($time) == false) {
            unlink('vfm-admin/shorten/'.$getfilelist.'.json');
            $expired = true;
        }
        
    } // END if $passa == true

    if (strlen($pass) > 0 && $passa != true) { 
        if ($postpass) { ?>
            <script type="text/javascript">
                var $error = $('<div class="response nope"><i class="fa fa-times closealert"></i>'
                    +' <?php echo $encodeExplorer->getString("wrong_pass"); ?></div>');
                $('#error').append($error);
            </script>
        <?php
        }
        ?>
        <div class="row" id="dwnldpwd">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <form method="post">
                  <div class="form-group">
                    <label for="exampleInputPassword1"><?php echo $encodeExplorer->getString("password"); ?></label>
                    <input type="password" name="dwnldpwd" class="form-control" placeholder="<?php echo $encodeExplorer->getString("password"); ?>">
                  </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-check"></i>
                      </button>
                    </div>
                </form>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
    <?php
    }
} else {
    $expired = true;
}

if ($expired === true) { ?>
    <div class="intero centertext">
        <a class="btn btn-default btn-lg centertext whitewrap" href="./">
            <?php echo $encodeExplorer->getString("link_expired"); ?>
        </a>
    </div>
<?php
}