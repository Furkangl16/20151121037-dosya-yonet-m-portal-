<?php

function cmpname($alfa, $beta)
{
    return strnatcasecmp($alfa->getName(), $beta->getName());
}

/**
* Sort array by date
*
* @param string $alfa first item to compare
* @param string $beta second item to compare
*
* @return sorted
*/
function cmptime($alfa, $beta)
{   
    // alfone, betone = older-newer
    // betone, alfone = newer-older
    $alfone = filectime($alfa->getLocation().$alfa->getName());
    $betone = filectime($beta->getLocation().$beta->getName());
    return strcmp($betone, $alfone);
}

if ($_DLIST == "date") {
    $metodo = "cmptime";
} else {
    $metodo = "cmpname";
}


/**
* List Folders
*/
if ($gateKeeper->isAccessAllowed()) { 

    $cleandir = "?dir="
        .substr(
            $setUp->getConfig('starting_dir')
            .$gateKeeper->getUserInfo('dir'), 2
        );
    $stolink = $encodeExplorer->makeLink(
        false, null, $location->getDir(false, true, false, 1)
    );

    $stodeeplink = $encodeExplorer->makeLink(
        false, null, $location->getDir(false, true, false, 0)
    );

    if (strlen($stolink) > strlen($cleandir)) {
            $parentlink = $encodeExplorer->makeLink(
                false, null, $location->getDir(false, true, false, 1)
            );
    } else {
            $parentlink = "?dir=";
    } 


    if (strlen($stodeeplink) > strlen($cleandir)
        && $setUp->getConfig("show_path") !== true
    ) { ?>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $parentlink; ?>">
                    <i class="fa fa-angle-left"></i> <i class="fa fa-folder-open"></i>
                </a>
            </li>
        </ol>
    <?php
    } ?>
    <script src="vfm-admin/js/datatables.js"></script>

    <?php    
    // Ready to display folders.
    if ($encodeExplorer->dirs) { ?>
        <section class="vfmblock tableblock">
            <table class="table table-striped table-condensed" width="100%" id="sortable">
                <thead>
                    <tr class="rowa two">
                        <td class="firstfolderitem icon text-center col-xs-4 col-sm-2">
    <?php
        if (count($encodeExplorer->dirs) > 1) {
            /*
            * switch listing
            */
            echo "<a ";
            if ($metodo == "cmpname") {
                echo "class=\"active\" "; 
            }
            echo "href=\"".$stodeeplink."&dlist=alpha\"><i class=\"fa fa-sort-alpha-asc\"></i></a>";
            echo " <a ";
            if ($metodo == "cmptime") { 
                echo "class=\"active\" "; 
            }
            echo "href=\"".$stodeeplink."&dlist=date\"><i class=\"fa fa-calendar\"></i></a>";

        } ?>
        </td>
    <?php 
        if ($setUp->getConfig("show_folder_counter") === true) { ?>
            <td></td>
    <?php 
        } ?>
        <?php
        // edit column
        if ($gateKeeper->isAllowed('rename_dir_enable') && $location->editAllowed()) { ?>
            <td class="mini del centertext col-xs-1"><i class="fa fa-pencil"></i></td>
        <?php 
        }

        // delete column
        if ($gateKeeper->isAllowed('delete_dir_enable') && $location->editAllowed()) { ?>
            <td class="mini del centertext col-xs-1"><i class="fa fa-trash-o"></i></td>
        <?php 
        } ?>
                    </tr>
                </thead>
                <tbody>
    <?php

        $showdirs = $encodeExplorer->dirs;        
        usort($showdirs, $metodo);

        foreach ($showdirs as $dir) {
            $thislink = $encodeExplorer->makeLink(
                false, null, $location->getDir(
                    false, true, false, 0
                ).$dir->getNameEncoded()
            );

            $del = $location->getDir(false, true, false, 0).$dir->getNameEncoded();
            $thisdel = $encodeExplorer->makeLink(false, $del, $location->getDir(false, true, false, 0));
            $thisdir = urldecode($encodeExplorer->location->getDir(false, true, false, 0));


            ?>
            <tr class="rowa">
    <?php 
            if ($setUp->getConfig("show_folder_counter") === true) {
                $quanti = Utils::countContents($location->getDir(false, false, false, 0).$dir->getName());
                $quantifiles = $quanti['files'];
                $quantedir = $quanti['folders']; ?>
                <td class="icon">
                    <a href="<?php echo $thislink; ?>">
                        <span class="badge hidden-xs">
                            <i class="fa fa-folder-o"></i> 
                            <?php echo $quantedir; ?>
                        </span>
                        <span class="badge">
                            <i class="fa fa-files-o"></i> 
                            <?php echo $quantifiles; ?>
                        </span> 
                    </a>
                </td>
    <?php   
            } ?>
                <td class="name">
                    <div class="relative">
                        <a href="<?php echo $thislink; ?>">
                            <span class="icon text-center">
                                <i class="fa fa-folder"></i>
                            </span> 
                            <?php echo $dir->getName(); ?>
                        </a>
                        <span class="hover">
                            <i class="fa fa-folder-open-o fa-fw"></i>
                        </span>
                    </div>
                </td>

            <?php
            if ($gateKeeper->isAllowed('rename_dir_enable') 
                && $location->editAllowed()
            ) { ?>
                <td class="icon centertext rename">
                    <a href="javascript:void(0)" data-thisdir="<?php echo $thisdir; ?>" 
                        data-thisname="<?php echo $dir->getName(); ?>">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                </td>
            <?php
            }
            if ($gateKeeper->isAllowed('delete_dir_enable') 
                && $location->editAllowed()
            ) {
                $delquery = base64_encode($del);
                $cash = md5($delquery.$setUp->getConfig('salt').$setUp->getConfig('session_name')); ?>

                <td class="del centertext">
                    <a data-name="<?php echo $dir->getName(); ?>" 
                        href="<?php echo $thisdel; ?>&h=<?php echo $cash; ?>&fa=<?php echo $delquery; ?>">
                        <i class="fa fa-times"></i>
                    </a>
                </td>
            <?php
            } ?>
            </tr>
        <?php
        } ?>
                </tbody>
            </table>
        </section>
    <?php    
    } ?>
    
    <?php
    if ($setUp->getConfig("show_pagination_folders") == true) { 

        if ($setUp->getConfig("show_pagination_num_folder") == true) { 
            $sPaginationTypeF = 'full_numbers';
        } else {
            $sPaginationTypeF = 'simple';
        }
        $iDisplayLengthF = $setUp->getConfig('folderdefnum');

        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                callFoldersTable('<?php echo $sPaginationTypeF; ?>', <?php echo $iDisplayLengthF; ?>)
            });
        </script>
    <?php
    }
} ?>