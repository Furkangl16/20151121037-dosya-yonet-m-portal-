<?php

if ($gateKeeper->isAccessAllowed() && $location->editAllowed()) { ?>
  
    <section class="vfmblock tableblock">
        <div class="action-group">
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle groupact" data-toggle="dropdown">
                    <i class="fa fa-cog"></i> 
                    <?php echo $encodeExplorer->getString("group_actions"); ?> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a class="multid" href="#">
                        <i class="fa fa-cloud-download"></i> 
                        <?php echo $encodeExplorer->getString("download"); ?></a>
                    </li>
    <?php
    if ($gateKeeper->isAllowed('move_enable')) { ?>
                    <li>
                        <a class="multimove" href="#">
                            <i class="fa fa-arrow-right"></i> 
                            <?php echo $encodeExplorer->getString("move"); ?>
                        </a>
                    </li>
    <?php
    }

    if ($gateKeeper->isAllowed('delete_enable')) { ?>
                    <li><a class="multic" href="#">
                            <i class="fa fa-trash-o"></i> 
                            <?php echo $encodeExplorer->getString("delete"); ?>
                        </a>
                    </li>
    <?php
    }  ?>
                </ul>
            </div> <!-- .btn-group -->
    <?php
    if ($setUp->getConfig('sendfiles_enable')) { ?>
            <button class="btn btn-default manda">
                <i class="fa fa-paper-plane"></i> 
                <?php echo $encodeExplorer->getString("share"); ?>
            </button>
        <?php
    }  ?>
        </div> <!-- .action-group -->

        <form id="tableform">
            <table class="table table-striped" width="100%" id="sort">
                <thead>
                    <tr class="rowa one">
                        <td class="text-center">
                            <a href="#" id="selectall"><i class="fa fa-check fa-lg"></i></a>
                        </td>
                        <td class="icon"></td>
                        <td class="mini">
                            <span class="sorta nowrap">
                                <?php echo $encodeExplorer->getString("file_name"); ?>
                            </span>
                        </td>
                        <td class="hidden"></td>
                        <td class="taglia reduce mini">
                            <span class="hidden-xs centertext sorta nowrap">
                                <?php echo $encodeExplorer->getString("size"); ?>
                            </span>
                        </td>
                        <td class="hidden"></td>
                        <td class="reduce mini">
                            <span class="hidden-xs centertext sorta nowrap">
                                <?php echo $encodeExplorer->getString("last_changed"); ?>
                            </span>
                        </td>

    <?php
    if ($gateKeeper->isAllowed('rename_enable')) { ?>
                        <td class="mini centertext">
                            <i class="fa fa-pencil"></i>
                        </td>
    <?php
    }           

    if ($gateKeeper->isAllowed('delete_enable')) {  ?>
                        <td class="mini centertext">
                            <i class="fa fa-trash-o"></i>
                        </td>
    <?php
    } ?>
                    </tr>
                </thead>
                <tbody>
    <?php
    // Display the files
    if ($encodeExplorer->files) {

            $alt = $setUp->getConfig('salt');
            $altone = $setUp->getConfig('session_name');
            
        foreach ($encodeExplorer->files as $key => $file) {
            $thislink = $encodeExplorer->location->getDir(
                false, true, false, 0
            ).$file->getNameEncoded();

            $thisdir = urldecode(
                $encodeExplorer->location->getDir(false, true, false, 0)
            );
            $thisfile = $file->getName();
            $thisname = $file->getNameHtml();

            $dash = md5($alt.base64_encode($thislink).$altone.$alt);

            $ext = pathinfo($thisfile, PATHINFO_EXTENSION);
            $withoutExt = preg_replace("/\\.[^.\\s]{2,4}$/", "", $thisfile);
            $del = $location->getDir(false, true, false, 0).$file->getName();

            $thisdel = $encodeExplorer->makeLink(
                false, $del, $location->getDir(
                    false, true, false, 0
                )
            );

            if ($setUp->getConfig('enable_prettylinks') == true) {
                $downlink = "download/".base64_encode($thislink)."/h/".$dash;
                $imgdata = " data-name=\"".$thisname."\" data-link=\"".$thislink
                ."\" data-linkencoded=\"".base64_encode($thislink)."/h/".$dash."\"";
            } else {
                $downlink = "vfm-admin/vfm-downloader.php?q=".base64_encode($thislink)."&h=".$dash;
                $imgdata = " data-name=\"".$thisname."\" data-link=\"".$thislink
                ."\" data-linkencoded=\"".base64_encode($thislink)."&h=".$dash."\"";
            }

            if (array_key_exists($file->getType(), $_IMAGES)) {
                $thisicon = $_IMAGES[$file->getType()];
            } else {
                $thisicon = "fa-file-o";
            }
            echo "<tr class=\"rowa ";
            if ($file->isValidForThumb()) {
                echo "gallindex\" id=\"gall-".$key;
            }
            echo "\">"; ?>

            <td class="checkb centertext">
                <input type="checkbox" name="selecta" class="selecta" value="<?php echo base64_encode($thislink); ?>">
            </td>

            <?php
            $inlinew = $setUp->getConfig("inline_tw");
            $margine = $inlinew / 4;
            $fontsize = $inlinew - ($margine*2);

            // MP3 inline player link
            if (($ext == "mp3") && $setUp->getConfig('playmusic') == true) { ?>

                <td class="icon centertext playme">

                <?php
                if ($setUp->getConfig('enable_prettylinks') == true) {
                    $linkaudio = "download/".base64_encode($thislink)."/h/".$dash;
                } else {
                    $linkaudio = "vfm-admin/vfm-downloader.php?q=".base64_encode($thislink)."&h=".$dash;
                } ?>
                
                <a type="audio/mp3" class="sm2_button" href="<?php echo $linkaudio; ?>&audio=play">

                <?php
                if ($setUp->getConfig('inline_thumbs') == true) {
                    echo "<span class=\"icon-placeholder\" style=\"width:"
                    .$setUp->getConfig("inline_tw")."px; height:"
                    .$setUp->getConfig("inline_tw")."px;
                    font-size:".$fontsize."px; padding:".$margine."px 0;\">";
                }
                echo "<i class=\"trackload fa fa-refresh fa-spin\"></i>"
                ."<i class=\"trackpause fa fa-play-circle-o\"></i>"
                ."<i class=\"trackplay fa fa-circle-o-notch fa-spin\"></i>"
                ."<i class=\"trackstop fa fa-play-circle\"></i>";
                if ($setUp->getConfig('inline_thumbs') == true) {
                    echo "</span>";
                } ?>
                
                </a>
            <?php
            } else { ?>

                <td class="icon centertext">
                    <a href="<?php echo $downlink; ?>" 
                        <?php
                if ($file->isValidForThumb()) {
                    echo $imgdata;
                }

                if ($ext == "pdf" || $ext == "PDF") {
                    echo " target=\"_blank\"";
                } ?>
                 class="item file
                <?php 
                if ($file->isValidForThumb() && $setUp->getConfig('thumbnails') == true) {
                    echo " thumb vfm-gall";
                } ?>
                ">

                <?php
                // INLINE THUMBNAILs
                if ($setUp->getConfig('inline_thumbs') == true) {
                    if ($file->isValidForThumb()) {
                        echo "<img style=\"width:".$setUp->getConfig('inline_tw')."px;\" src=\"vfm-thumb.php?thumb=".$thislink."&in=y\">";
                    } else {
                        echo "<span class=\"icon-placeholder\" style=\"width:"
                        .$setUp->getConfig("inline_tw")."px; height:"
                        .$setUp->getConfig("inline_tw")."px; font-size:"
                        .$fontsize."px; padding:"
                        .$margine."px 0;\"><i class=\"fa "
                        .$thisicon."\"></i></span></a>";
                    }
                } else {
                    echo "<i class=\"fa ".$thisicon."\"></i>";
                } ?>
                    </a>
            <?php
            } ?>

            </td>
            <td class="name">
                <div class="relative">
                <a href="<?php echo $downlink; ?>" 
                
                <?php
            if ($file->isValidForThumb()) {
                echo $imgdata;
            }
            if ($ext == "pdf" || $ext == "PDF") {
                echo " target=\"_blank\"";
            } ?>
             class="item file 
            <?php
            if ($file->isValidForThumb()
                && $setUp->getConfig('thumbnails') == true
            ) {
                echo " thumb";
            } ?>
            "><?php echo $thisname; ?>
                </a>

            <?php

            if ($file->isValidForThumb()
                && $setUp->getConfig('thumbnails') == true
            ) { ?>
                <span class="hover"><i class="fa fa-eye fa-fw"></i></span>
            <?php
            } elseif ($ext == "pdf" || $ext == "PDF") { ?>
                <span class="hover"><i class="fa fa-arrow-right fa-fw"></i></span>
            <?php
            } else { ?>
                <span class="hover"><i class="fa fa-download fa-fw"></i></span>
            <?php
            } ?>
            </div>
            </td>
            
            <td class="hidden"><?php echo $setUp->fullSize($file->getSize()); ?></td>
            <td class="mini reduce nowrap">
                <span class="hidden-xs centertext">
                    <?php echo $setUp->formatSize($file->getSize()); ?>
                </span>
            </td>

            <td class="hidden"><?php echo $file->getModTime(); ?></td>

            <td class="mini reduce">
                <span class="hidden-xs centertext">
                    <?php echo $setUp->formatModTime($file->getModTime()); ?>
                </span>
            </td>
            
            <?php
            if ($gateKeeper->isAllowed('rename_enable') 
                && $location->editAllowed()
            ) { ?>
                <td class="icon rename centertext">
                    <a href="javascript:void(0)" data-thisdir="<?php echo $thisdir; ?>" 
                        data-thisext="<?php echo $ext; ?>" data-thisname="<?php echo $withoutExt; ?>">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                </td>
            <?php
            }
            if ($gateKeeper->isAllowed('delete_enable') 
                && $location->editAllowed()
            ) {

                $delquery = base64_encode($del);
                $cash = md5($delquery.$setUp->getConfig('salt').$setUp->getConfig('session_name')); ?>

                <td class="del centertext">
                    <a data-name="<?php echo $thisfile; ?>" href="<?php echo $thisdel; ?>&h=<?php echo $cash; ?>">
                        <i class="fa fa-times"></i>
                    </a>
                </td>
            <?php
            } ?>
            </tr>
        <?php
        }
    } ?>
                </tbody>
            </table>
        </form>
    </section>

    <?php
    /**
    *
    * init soundmanager
    *
    */
    if ($setUp->getConfig("playmusic") == true) { ?>

        <a type="audio/mp3" class="sm2_button hidden" href="#"></a>
        <script src="vfm-admin/js/soundmanager2.min.js"></script>
    <?php 
    }

    /**
    *
    * init File datatable
    *
    */
    if ($setUp->getConfig("show_pagination_num") == true 
        || $setUp->getConfig("show_pagination") == true 
        || $setUp->getConfig("show_search") == true
    ) { 

        if ($setUp->getConfig("show_pagination_num") == true) { 
            $sPaginationType = 'full_numbers';
        } else {
            $sPaginationType = 'simple';
        }
        
        $bPaginate = ($setUp->getConfig("show_pagination") ? true : 0);
        $bFilter = ($setUp->getConfig("show_search") ? true : 0);
        $iDisplayLength = $setUp->getConfig('filedefnum');

        // list by name
        if ($setUp->getConfig('filedeforder') == "alpha") { 
            $fnSortcol = 2;
            $fnSortdir = 'asc';
            // list by size
        } elseif ($setUp->getConfig('filedeforder') == "size") { 
            $fnSortcol = 4;
            $fnSortdir = 'asc';
            // list by creation date
        } else { 
            $fnSortcol = 6;
            $fnSortdir = 'desc';
        }
        // js output:
        // oTable.fnSort( [ [$fnSortcol, $fnSortdir] ] );
        ?>

        <script type="text/javascript">
            $(document).ready(function() {
                callFilesTable(
                    '<?php echo $sPaginationType; ?>',
                    <?php echo $bPaginate; ?>,
                    <?php echo $bFilter; ?>,
                    <?php echo $iDisplayLength; ?>,
                    <?php echo $fnSortcol; ?>,
                    '<?php echo $fnSortdir; ?>'
                );
            });
        </script>
    <?php
    } 
} ?>