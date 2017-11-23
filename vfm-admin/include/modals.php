<?php

if ($gateKeeper->isAccessAllowed()) {

    $time = time();
    $hash = md5($_CONFIG['salt'].$time);
    $doit = ($time * 12);
    $url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $url .= $_SERVER['HTTP_HOST'];
    $url .= htmlspecialchars($_SERVER['PHP_SELF']);
    $pulito = dirname($url);
    $insert4 = $encodeExplorer->getString('insert_4_chars');

    if ($setUp->getConfig("show_pagination_num") == true 
        || $setUp->getConfig("show_pagination") == true 
        || $setUp->getConfig("show_search") == true
    ) {
        $activepagination = true;
    } else {
        $activepagination = 0;
    }
    $selectfiles = $encodeExplorer->getString("select_files");
    $toomanyfiles = $encodeExplorer->getString('too_many_files');

    $maxzipfiles = $setUp->getConfig('max_zip_files');
    $prettylinks = ($setUp->getConfig('enable_prettylinks') ? true : 0);
    ?>
    <script type="text/javascript">
        createShareLink(
            '<?php echo $insert4; ?>', 
            '<?php echo $time; ?>', 
            '<?php echo $hash; ?>', 
            '<?php echo $pulito; ?>', 
            <?php echo $activepagination; ?>,
            <?php echo $maxzipfiles; ?>,
            '<?php echo $selectfiles; ?>', 
            '<?php echo $toomanyfiles; ?>',
            <?php echo $prettylinks; ?>
        );
    </script>
    <div class="modal fade downloadmulti" id="downloadmulti" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <p class="modal-title">
                        <?php echo " " .$encodeExplorer->getString('selected_files'); ?>: 
                        <span class="numfiles badge badge-danger"></span>
                    </p>
                </div>
                <div class="text-center modal-body">
                    <a class="btn btn-primary btn-lg centertext bigd sendlink" href="#">
                        <i class="fa fa-cloud-download fa-5x"></i>
                    </a>
                </div>
            </div>
         </div>
    </div>
    <?php
    /**
    *
    * Send files window
    *
    */
    if ($setUp->getConfig('sendfiles_enable')) { ?>
            <div class="modal fade sendfiles" id="sendfilesmodal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h5 class="modal-title">
                                <?php echo " " .$encodeExplorer->getString("selected_files"); ?>: 
                                <span class="numfiles badge badge-danger"></span>
                            </h5>
                        </div>

                        <div class="modal-body">
                            <div class="form-group createlink-wrap">
                                <button id="createlink" class="btn btn-primary btn-block"><i class="fa fa-check"></i> 
                                    <?php echo $encodeExplorer->getString("generate_link"); ?></button>
                            </div>
        <?php
        if ($setUp->getConfig('secure_sharing')) { ?>
                            <div class="checkbox">
                                <label>
                                    <input id="use_pass" name="use_pass" type="checkbox"><i class="fa fa-key"></i> 
                                    <?php echo $encodeExplorer->getString("password_protection"); ?>
                                </label>
                            </div>
        <?php
        } ?>


                        <script src="vfm-admin/js/clipboard.min.js"></script>
                        <script type="text/javascript">

                        var clipboardSnippets = new Clipboard('#clipme');

                        var timer = window.setTimeout(function() {
                            $('#clipme').popover('destroy');
                        }, 1000);


                        clipboardSnippets.on('success', function(e) {
                            window.clearTimeout(timer);

                            $('#clipme').popover('show');
                            timer = setTimeout(function() {
                                $('#clipme').popover('destroy')
                            }, 1000);
                        });

                        </script>
                        <div class="form-group shalink">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a class="btn btn-primary sharebutt" href="#" target="_blank">
                                        <i class="fa fa-link fa-fw"></i>
                                    </a>
                                </span>
                                <input id="copylink" class="sharelink form-control" type="text" onclick="this.select()" readonly>

                                <span class="input-group-btn">
                                    <button id="clipme" class="btn btn-primary" data-toggle="popover" data-placement="bottom" data-content="<?php echo $encodeExplorer->getString("copied"); ?>" data-clipboard-target="#copylink">
                                        <i class="fa fa-clipboard fa-fw"></i>
                                    </button>
                                </span>
                            </div>
                        </div>


        <?php
        if ($setUp->getConfig('secure_sharing')) { ?>
                            <div class="form-group seclink">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    <input class="form-control passlink setpass" type="text" onclick="this.select()" 
                                    placeholder="<?php echo $encodeExplorer->getString("random_password"); ?>">
                                </div>
                            </div>
        <?php
        } 
        $mailsystem = $setUp->getConfig('email_from');
        if (strlen($mailsystem) > 0) { ?>
                            <div class="openmail">
                                <span class="fa-stack fa-lg">
                                  <i class="fa fa-circle-thin fa-stack-2x"></i>
                                  <i class="fa fa-envelope fa-stack-1x"></i>
                                </span>
                            </div>
                            <form role="form" id="sendfiles">
                                <div class="mailresponse"></div>
                                
                                <input name="thislang" type="hidden" 
                                value="<?php echo $encodeExplorer->lang; ?>">

                                <label for="mitt">
                                   <?php echo $encodeExplorer->getString("from"); ?>:
                                </label>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                    <input name="mitt" type="email" class="form-control" id="mitt" 
                                    value="<?php echo $gateKeeper->getUserInfo('email'); ?>" 
                                     placeholder="<?php echo $encodeExplorer->getString("your_email"); ?>" required >
                                </div>
                            
                                <div class="wrap-dest">
                                    <div class="form-group">
                                        <label for="dest">
                                            <?php echo $encodeExplorer->getString("send_to"); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                            <input name="dest" type="email" data-role="multiemail" class="form-control addest" id="dest" 
                                            placeholder="" required >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group clear">
                                    <div class="btn btn-primary btn-xs shownext">
                                        <i class="fa fa-plus"></i> <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <textarea class="form-control" name="message" id="mess" rows="3" 
                                    placeholder="<?php echo $encodeExplorer->getString("message"); ?>"></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-envelope"></i>
                                    </button>
                                </div>

                                <input name="passlink" class="form-control passlink" type="hidden">
                                <input name="attach" class="attach" type="hidden">
                                <input name="sharelink" class="sharelink" type="hidden">
                            </form>
                            
                            <div class="mailpreload"></div>
        <?php
        } ?>
                        </div> <!-- modal-body -->
                    </div>
                </div>
            </div>
        <?php
    } // end sendfiles enabled

            
    /**
    *
    * Rename files and folders
    *
    */
    if ($gateKeeper->isAllowed('rename_enable')) { ?>

        <div class="modal fade changename" id="modalchangename" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $encodeExplorer->getString("rename"); ?></h4>
                    </div>

                    <div class="modal-body">
                        <form role="form" method="post">
                            <input readonly name="thisdir" type="hidden" 
                            class="form-control" id="dir">
                            <input readonly name="thisext" type="hidden"
                            class="form-control" id="ext">
                            <input readonly name="oldname" type="hidden" 
                            class="form-control" id="oldname">

                            <div class="input-group">
                                <label for="newname" class="sr-only">
                                    <?php echo $encodeExplorer->getString("rename"); ?>
                                </label>
                                <input name="newname" type="text" 
                                class="form-control" id="newname">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo $encodeExplorer->getString("rename"); ?>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } // end rename_enable

    /**
    *
    * Move files
    *
    */
    if ($gateKeeper->isAllowed('move_enable')) { 
        ?>
        <script type="text/javascript">
        setupMove(
            <?php echo $activepagination; ?>,
            '<?php echo $selectfiles; ?>',
            '<?php echo $time; ?>', 
            '<?php echo $hash; ?>', 
            '<?php echo $doit; ?>'
        );
        </script>

        <div class="modal fade movefiles" id="movemulti" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-list"></i> 
                            <?php echo $encodeExplorer->getString("select_destination_folder"); ?></h4>
                    </div>

                    <div class="modal-body">
                        <div class="hiddenalert"></div>
                        <form id="moveform">     
        <?php
        if (isset($_GET['dir']) && strlen($_GET['dir']) > 0) {
            $currentdir = "./".trim($_GET['dir'], "/")."/";
        } else {
            $currentdir = $setUp->getConfig('starting_dir');
        }
        // check if any folder is assigned to the current user
        if ($gateKeeper->getUserInfo('dir') !== null) {
            $userpatharray = array();
            $userpatharray = json_decode(GateKeeper::getUserInfo('dir'), true);

            // show all available directories trees
            foreach ($userpatharray as $userdir) {
                
                $path = $setUp->getConfig('starting_dir').$userdir.'/';

                echo '<ul class="foldertree"><li class="folderoot">';

                if ($path === $currentdir) {
                    echo '<i class="fa fa-folder-open"></i> '.$userdir;
                } else {
                    echo '<a href="#" data-dest="'.urlencode($path).'" class="movelink">';
                    echo '<i class="fa fa-folder"></i> '.$userdir.'</a>';
                }

                Actions::walkDir($path, $currentdir);

                echo "</li></ul>";
            }
        } else {
            // no directory assigned, access to all folders
            $movedir = $setUp->getConfig('starting_dir');
            $cleandir = substr(
                $setUp->getConfig('starting_dir'), 2
            );
            $cleandir = substr_replace($cleandir, "", -1);
            
            echo '<ul class="foldertree"><li class="folderoot">';

            if ($movedir === $currentdir) {
                echo '<i class="fa fa-folder-open"></i> '.$cleandir;
            } else {
                echo '<a href="#" data-dest="'.urlencode($movedir).'" class="movelink">';
                echo '<i class="fa fa-folder"></i> '.$cleandir.'</a>';
            }

            Actions::walkDir($movedir, $currentdir);
            
            echo "</li></ul>";
        } ?>    
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } // end move_enable

    /**
    *
    * delete multiple files
    *
    */
    if ($gateKeeper->isAllowed('delete_enable')) { 
        $confirmthisdel = $encodeExplorer->getString('delete_this_confirm');
        $confirmdel = $encodeExplorer->getString('delete_confirm'); ?>
        <script type="text/javascript">
            setupDelete(
                '<?php echo $confirmthisdel; ?>', 
                '<?php echo  $confirmdel; ?>', 
                <?php echo $activepagination; ?>, 
                '<?php echo $time; ?>', 
                '<?php echo $hash; ?>', 
                '<?php echo $doit; ?>', 
                '<?php echo $selectfiles; ?>'
            );
        </script>
        <div class="modal fade deletemulti" id="deletemulti" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <p class="modal-title">
                            <?php echo " " .$encodeExplorer->getString("selected_files"); ?>: 
                            <span class="numfiles badge badge-danger"></span>
                        </p>
                    </div>
                    <div class="text-center modal-body">
                        <form id="delform">
                            <a class="btn btn-primary btn-lg centertext bigd removelink" href="#">
                            <i class="fa fa-trash-o fa-5x"></i></a>
                            <p class="delresp"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php  
    } // end delete enabled
    
} // end isAccessAllowed

/**
*
* Show Thumbnails
*
*/
if ($setUp->getConfig("thumbnails") == true ) { ?>
    <div class="modal fade zoomview" id="zoomview" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <div class="modal-title">
                        <a class="vfmlink btn btn-primary" href="#">
                            <i class="fa fa-download fa-lg"></i> 
                        </a> <span class="thumbtitle"></span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="vfm-zoom"></div>
                    <!--            
                     <div style="position:absolute; right:10px; bottom:10px;">Custom Watermark</div>
                    -->                
                </div>
            </div>
        </div>
    </div>
    <?php    
    /**
    *
    * Load image preview 
    *
    */ 
    ?>
    <script type="text/javascript">
    function loadImg(thislink, thislinkencoded, thisname, thisID){

        $(".vfm-zoom").html("<i class=\"fa fa-refresh fa-spin\"></i><img class=\"preimg\" src=\"vfm-thumb.php?thumb="+ thislink +"\" \/>");
        // remove extension from filename    
        // fileExtension = '.' + thisname.replace(/^.*\./, '');
        // thisname = thisname.replace(fileExtension, '');
        $("#zoomview .thumbtitle").html(thisname);
        $("#zoomview").data('id', thisID);

        var firstImg = $('.preimg');
        firstImg.css('display','none');

        $("#zoomview").modal();

        firstImg.one('load', function() {
            $(".vfm-zoom .fa-refresh").fadeOut();
            $(this).fadeIn();
            checkNextPrev(thisID);
            <?php 
    if ($setUp->getConfig('enable_prettylinks') == true) { ?>
                $(".vfmlink").attr("href", "download/"+thislinkencoded);
            <?php 
    } else { ?>
                $(".vfmlink").attr("href", "vfm-admin/vfm-downloader.php?q="+thislinkencoded);
            <?php 
    } ?>
            }).each(function() {
                if(this.complete) $(this).load();
        });   
    }
    </script>
    <?php
} ?>