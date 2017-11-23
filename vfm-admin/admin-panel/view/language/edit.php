    <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?languagemanager=update">

        <h3><?php print $encodeExplorer->getString("edit").": ".$editlang; ?></h3>

        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right">
                <button type="submit" class="btn btn-info">
                    <i class=\"fa fa-refresh\"></i> 
                    <?php print $encodeExplorer->getString("save_settings"); ?>
                </button>
                <?php
                if ($editlang != "en") { 
                    print "<a href=\"?languagemanager=update&remove=".$editlang."\" 
                    class=\"btn btn-danger delete\"><i class=\"fa fa-trash-o\"></i> "
                    .$encodeExplorer->getString("remove_language")."</a>";
                } ?>
                </div>
            </div>
        </div>
        <input type="hidden" class="form-control" name="thenewlang" value="<?php echo $editlang; ?>">
        <div class="row">
        <?php
        $index = 0;
        foreach ($baselang as $key => $voce) {
            $ide = ( ($index % 2) ? '' : ' </div></div class="row>"' );
            $index++; ?>
            <?php //echo $ide; ?>
            <div class="col-sm-6">
                <label><?php echo $key; ?></label>
    <?php
    if (array_key_exists($key, $_TRANSLATIONSEDIT)) {
        $tempval = $_TRANSLATIONSEDIT[$key];
    } else {
        $tempval = "";
    }       ?>
                <input type="text" class="form-control" name="<?php echo $key; ?>" 
                value="<?php echo stripslashes($tempval); ?>"
                placeholder="<?php echo stripslashes($baselang[$key]); ?>">
            </div>
    <?php
        } ?>
        </div> <!-- row -->

        <hr>
        <button type="submit" class="btn btn-info btn-lg btn-block">
            <i class="fa fa-refresh"></i> 
            <?php print $encodeExplorer->getString("save_settings"); ?>
        </button>
    </form>