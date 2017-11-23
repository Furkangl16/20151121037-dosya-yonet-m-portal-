<?php
/**
* TABLES CONFIGURATION
**/
?>
<div id="view-lists" class="anchor"></div>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <i class="fa fa-list-alt"></i> <?php print $encodeExplorer->getString("lists"); ?>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="checkbox checkbox-big">
                            <label>
                                <input type="checkbox" name="show_search" 
                                <?php
                                if ($setUp->getConfig('show_search')) {
                                        echo "checked";
                                } ?>><i class="fa fa-search fa-fw"></i> 
                                <?php print $encodeExplorer->getString("show_search"); ?>
                            </label>
                        </div>

                       <div class="checkbox checkbox-big">
                            <label>
                                <input type="checkbox" name="playmusic" 
                                <?php
                                if ($setUp->getConfig('playmusic') == true) {
                                    echo "checked";
                                } ?>><i class="fa fa-play-circle fa-fw"></i> 
                                <?php print $encodeExplorer->getString("mp3_player"); ?>
                            </label>
                        </div>

                        <div class="checkbox checkbox-big toggle">
                            <label>
                                <input type="checkbox" name="inline_thumbs" 
                                <?php
                                if ($setUp->getConfig('inline_thumbs')) {
                                    echo "checked";
                                } ?>><i class="fa fa-picture-o fa-fw"></i>

                                <?php print $encodeExplorer->getString("inline_thumbs"); ?>
                            </label>
                        </div>
                        <div class="row toggled">
                            <div class="form-group col-xs-6">
                                <label><?php print $encodeExplorer->getString("thumb_w"); ?></label>
                                <input type="text" class="form-control" name="inline_tw" placeholder="50" 
                                value="<?php print $setUp->getConfig('inline_tw'); ?>">
                            </div>
                        </div>


                        <div class="checkbox checkbox-big toggle">
                            <label>
                                <input type="checkbox" name="thumbnails" 
                                <?php
                                if ($setUp->getConfig('thumbnails')) {
                                    echo "checked";
                                } ?>><i class="fa fa-desktop fa-fw"></i>

                                <?php print $encodeExplorer->getString("can_thumb"); ?>
                            </label>
                        </div>

                        <div class="row toggled">
                            <div class="form-group col-xs-6">
                                <label><?php print $encodeExplorer->getString("thumb_w"); ?></label>
                                <input type="text" class="form-control" name="thumbnails_width" placeholder="760" 
                                value="<?php print $setUp->getConfig('thumbnails_width'); ?>">
                            </div>
                            <div class="form-group col-xs-6">
                                <label><?php print $encodeExplorer->getString("thumb_h"); ?></label>
                                <input type="text" class="form-control" name="thumbnails_height" placeholder="800" 
                                value="<?php print $setUp->getConfig('thumbnails_height'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="checkbox clear toggle checkbox-big">
                            <label>
                                <input type="checkbox" name="show_pagination" 
                                <?php
                                if ($setUp->getConfig('show_pagination')) {
                                        echo "checked";
                                } ?>> <i class="fa fa-caret-left"></i> 
                                <i class="fa fa-list"></i> <i class="fa fa-caret-right"></i>
                                <?php print $encodeExplorer->getString("show_pagination"); ?>
                            </label>
                        </div>

                        <div class="toggled">
                            <div class="checkbox clear">
                                <label>
                                    <input type="checkbox" name="show_pagination_num" 
                                    <?php
                                    if ($setUp->getConfig('show_pagination_num')) {
                                            echo "checked";
                                    } ?>><i class="fa fa-caret-left"></i>..2..<i class="fa fa-caret-right"></i>
                                    <?php print $encodeExplorer->getString("show_pagination_num"); ?>
                                </label>
                            </div>

                            <label class="radio-inline">
                                <input type="radio" name="filedefnum" 
                                <?php
                                if ($setUp->getConfig('filedefnum') == 10) {
                                    echo "checked";
                                } ?> value="10"> 10
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="filedefnum" 
                                <?php
                                if ($setUp->getConfig('filedefnum') == 25) {
                                    echo "checked";
                                } ?> value="25"> 25
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="filedefnum" 
                                <?php
                                if ($setUp->getConfig('filedefnum') == 50) {
                                    echo "checked";
                                } ?> value="50"> 50
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="filedefnum" 
                                <?php
                                if ($setUp->getConfig('filedefnum') == 100) {
                                    echo "checked";
                                } ?> value="100"> 100
                            </label>
                        </div>

                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="filedeforder" 
                                <?php
                                if ($setUp->getConfig('filedeforder') == "alpha") {
                                    echo "checked";
                                } ?> value="alpha"> <i class="fa fa-sort-alpha-asc"></i>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="filedeforder" 
                                <?php
                                if ($setUp->getConfig('filedeforder') == "date") {
                                    echo "checked";
                                } ?> value="date"> <i class="fa fa-calendar"></i>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="filedeforder" 
                                <?php
                                if ($setUp->getConfig('filedeforder') == "size") {
                                    echo "checked";
                                } ?> value="size"> <i class="fa fa-tachometer"></i>
                            </label>
                        </div>

                        <div class="checkbox clear toggle checkbox-big">
                            <label>
                                <input type="checkbox" name="show_pagination_folders" 
                                <?php
                                if ($setUp->getConfig('show_pagination_folders')) {
                                        echo "checked";
                                } ?>>
                                <i class="fa fa-caret-left"></i> <i class="fa fa-folder"></i> 
                                <i class="fa fa-caret-right"></i>
                                <?php print $encodeExplorer->getString("show_pagination_folders"); ?>
                            </label>
                        </div>

                        <div class="toggled">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="show_pagination_num_folder" 
                                    <?php
                                    if ($setUp->getConfig('show_pagination_num_folder')) {
                                        echo "checked";
                                    } ?>>
                                    <i class="fa fa-caret-left"></i>..2..<i class="fa fa-caret-right"></i>
                                    <?php print $encodeExplorer->getString("show_pagination_num"); ?>
                                </label>
                            </div>

                            <label class="radio-inline">
                                <input type="radio" name="folderdefnum" 
                                <?php
                                if ($setUp->getConfig('folderdefnum') == 10) {
                                        echo "checked";
                                } ?> value="10"> 10
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="folderdefnum" 
                                <?php
                                if ($setUp->getConfig('folderdefnum') == 25) {
                                        echo "checked";
                                } ?> value="25"> 25
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="folderdefnum" 
                                <?php
                                if ($setUp->getConfig('folderdefnum') == 50) {
                                        echo "checked";
                                } ?> value="50"> 50
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="folderdefnum" 
                                <?php
                                if ($setUp->getConfig('folderdefnum') == 100) {
                                        echo "checked";
                                } ?> value="100"> 100
                            </label>
                        </div> <!-- toggled -->

                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="folderdeforder" 
                                <?php
                                if ($setUp->getConfig('folderdeforder') == "alpha") {
                                    echo "checked";
                                } ?> value="alpha"> <i class="fa fa-sort-alpha-asc"></i>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="folderdeforder" 
                                <?php
                                if ($setUp->getConfig('folderdeforder') == "date") {
                                    echo "checked";
                                } ?> value="date"> <i class="fa fa-calendar"></i>
                            </label>
                        </div>


                        <div class="checkbox clear checkbox-big">
                            <label>
                                <input type="checkbox" name="show_folder_counter" 
                                <?php
                                if ($setUp->getConfig('show_folder_counter')) {
                                        echo "checked";
                                } ?>>
                                <span class="badge hidden-xs">
                                    <i class="fa fa-folder-o"></i> 0
                                </span>
                                <span class="badge hidden-xs">
                                    <i class="fa fa-files-o"></i> 0
                                </span>

                                <?php print $encodeExplorer->getString("counter"); ?>
                            </label>
                        </div>

                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-defalt pull-right" 
                    data-toggle="tooltip" data-placement="left"
                    title="<?php print $encodeExplorer->getString("save_settings"); ?>">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div> <!-- box-body -->
        </div> <!-- box -->
    </div> <!-- col -->
</div> <!-- row -->