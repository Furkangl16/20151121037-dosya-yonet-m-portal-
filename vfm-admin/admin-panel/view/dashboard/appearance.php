<?php
/**
 * ASPECT
 *
 * @package    VenoFileManager
 * @subpackage Administration
 */
?>
<div id="view-appearance" class="anchor"></div>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">

            <div class="box-header with-border">
                <i class="fa fa-paint-brush"></i> <?php print $encodeExplorer->getString("appearance"); ?>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">

                            <label><?php print $encodeExplorer->getString("skin"); ?></label>
                            <select class="form-control" name="skin">
                            <?php
                            $skins = glob('skins/*.css');
                            foreach ($skins as $skin) { 

                                $skininfo = Utils::mbPathinfo($skin);
                                $skinname = $skininfo['filename'];
                                $fileskin = $skinname.".css"; 
                                echo "<option ";
    if ($fileskin == $setUp->getConfig('skin')) {
        echo "selected ";
    } 
                                echo "value=\"".$fileskin."\""; 
                                echo ">".$skinname."</option>";
                            } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php print $encodeExplorer->getString("upload_progress"); ?></label>
                            <div class="radio pro">
                                <label>
                                    <input type="radio" name="progressColor" value="" 
                                    <?php
                                    if ($setUp->getConfig('progress_color') == "") {
                                        echo "checked";
                                    } ?>>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                            <p class="pull-left propercent">45%</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="radio pro">
                                <label>
                                    <input type="radio" name="progressColor" value="progress-bar-info"
                                    <?php
                                    if ($setUp->getConfig('progress_color') == "progress-bar-info") {
                                        echo "checked";
                                    } ?>>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                            <p class="pull-left propercent">65%</p>
                                        </div>
                                    </div>
                              </label>
                            </div>
                            <div class="radio pro">
                                <label>
                                    <input type="radio" name="progressColor" value="progress-bar-success"
                                    <?php
                                    if ($setUp->getConfig('progress_color') == "progress-bar-success") {
                                        echo "checked";
                                    } ?>>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%">
                                            <p class="pull-left propercent">35%</p>
                                        </div>
                                    </div>
                              </label>
                            </div>
                            <div class="radio pro">
                                <label>
                                    <input type="radio" name="progressColor" value="progress-bar-warning"
                                    <?php
                                    if ($setUp->getConfig('progress_color') == "progress-bar-warning") {
                                        echo "checked";
                                    } ?>>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%">
                                            <p class="pull-left propercent">85%</p>
                                        </div>
                                    </div>
                              </label>
                            </div>
                            <div class="radio pro">
                                <label>
                                    <input type="radio" name="progressColor" value="progress-bar-danger"
                    <?php
                    if ($setUp->getConfig('progress_color') == "progress-bar-danger") {
                                        echo "checked";
                    } ?>>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                                            <p class="pull-left propercent">75%</p>
                                        </div>
                                    </div>
                              </label>
                            </div>

                            <div class="checkbox clear intero">
                                <label>
                                    <input type="checkbox" name="show_percentage" id="percent" 
                                    <?php
                                    if ($setUp->getConfig('show_percentage')) {
                                            echo "checked";
                                    } ?>>
                                    <?php print $encodeExplorer->getString("show_percentage"); ?> %
                                </label>
                            </div>

                            <div class="checkbox clear intero">
                                <label>
                                    <input type="checkbox" name="single_progress" id="single-progress" 
                                    <?php
                                    if ($setUp->getConfig('single_progress')) {
                                            echo "checked";
                                    } ?>>
                                    <div class="progress progress-single">
                                        <div class="progress-bar <?php echo $setUp->getConfig('progress_color'); ?>"  role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                            <p class="pull-left propercent"><?php print $encodeExplorer->getString("single_progress"); ?></p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div><!-- col6 -->

<?php
$logoAlignment = $setUp->getConfig("align_logo");
switch ($logoAlignment) {
case "left":
    $placealign = "text-left";
    break;
case "center":
    $placealign = "text-center";
    break;
case "right":
    $placealign = "text-right";
    break;
default:
    $placealign = "text-left";
} ?>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="show_head" 
                                        <?php
                                        if ($setUp->getConfig('show_head')) {
                                            echo "checked";
                                        } ?>><i class="fa fa-certificate fa-fw"></i> 
                                        <?php print $encodeExplorer->getString("custom_header"); ?>
                                    </label>
                            </div>
                                <label><?php print $encodeExplorer->getString("alignment"); ?></label>

                                <div class="form-group select-logo-alignment">
                                    <label class="radio-inline">
                                        <input form="settings-form" type="radio" name="align_logo" 
                                        <?php
                                        if ($setUp->getConfig('align_logo') == "left") {
                                            echo "checked";
                                        } ?> value="left"> <i class="fa fa-align-left"></i>
                                    </label>
                                    <label class="radio-inline">
                                        <input form="settings-form" type="radio" name="align_logo" 
                                        <?php
                                        if ($setUp->getConfig('align_logo') == "center") {
                                            echo "checked";
                                        } ?> value="center"> <i class="fa fa-align-center"></i>
                                    </label>
                                    <label class="radio-inline">
                                        <input form="settings-form" type="radio" name="align_logo" 
                                        <?php
                                        if ($setUp->getConfig('align_logo') == "right") {
                                            echo "checked";
                                        } ?> value="right"> <i class="fa fa-align-right"></i>
                                    </label>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file">
                                                <?php print $encodeExplorer->getString("upload"); ?> 
                                                <i class="fa fa-upload"></i>
                                                <input type="file" name="file" value="select">
                                            </span>
                                        </span>
                                        <input class="form-control" type="text" readonly 
                                        name="fileToUpload" id="fileToUpload" onchange="fileSelected();">
                                    </div>
                                </div>

                                <div class="placeheader form-group <?php echo $placealign; ?>">
                                    <img src="images/<?php print $setUp->getConfig('logo'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-defalt pull-right" 
                    data-toggle="tooltip" data-placement="left"
                    title="<?php print $encodeExplorer->getString("save_settings"); ?>">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
                
            </div><!-- box body -->
        </div><!-- box -->
    </div><!-- col -->
</div> <!-- row -->


<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <i class="fa fa-eyedropper"></i> <?php print $encodeExplorer->getString("administration_color_scheme"); ?>
            </div>
            <div class="box-body">
                <div class="row adminscheme">
                <?php
                $colorlist = array('blue', 'purple', 'red', 'yellow', 'green', 'white');

                foreach ($colorlist as $color) { 
    if ($setUp->getConfig('admin_color_scheme') == $color) { 
        $layoutclass = "minilayout active";
        $state = "checked";
    } else {
        $layoutclass = "minilayout";
        $state = "";
    }               ?>

                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="<?php echo $layoutclass; ?>">
                            <label>
                                <input type="radio" name="admin_color_scheme" value="<?php echo $color; ?>" <?php echo $state; ?> >
                                <?php echo $color; ?>
                                <div class="colorbar-scheme">
                                    <div class="colorbar primary-<?php echo $color; ?>"></div>
                                    <div class="colorbar primary-side-<?php echo $color; ?>"></div>
                                    <div class="colorbar secondary-side-<?php echo $color; ?>"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                <?php
                } // end foreach
                ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-defalt pull-right" 
                    data-toggle="tooltip" data-placement="left"
                    title="<?php print $encodeExplorer->getString("save_settings"); ?>">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>