<?php
/**
* MODAL USER PANEL
*/
?>          
<div class="modal fade" id="modaluser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-user"></i> 
                    <span class="modalusername"></span>
                </h4>
            </div>

            <div class="modal-body">
                <form role="form" method="post" autocomplete="off" 
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?users=update" 
                enctype="multipart/form-data" class="removegroup">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user fa-fw"></i>
                                </span>
                                <input type="hidden" class="form-control" 
                                name="usernameold" id="r-usernameold"
                                value="">

                                <input type="text" class="form-control deleteme" 
                                name="username" id="r-username"
                                value="">
                            </div>
                        </div>

                        <div class="col-md-6 form-group cooldropgroup">
                                <label class="sr-only">
                                    <?php print $encodeExplorer->getString("role"); ?>
                                </label>
                            <div class="input-group btn-group cooldrop">
                                <span class="input-group-addon">
                                    <i class="fa fa-check fa-fw"></i>
                                </span>
                                <select class="form-control coolselect" name="role" id="r-role">
                                    <option value="user">user</option>
                                    <option value="admin">admin</option>
                                    <option value="superadmin">superadmin</option>
                                </select>
                            </div>
                        </div>
                    </div> <!-- row -->

                    <div class="row">

                        <div class="col-md-6 form-group">
                            <input type="hidden" class="form-control" 
                            name="userpass" id="r-userpass"
                            value="">

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock fa-fw"></i>
                                </span>
                                <input type="password" class="form-control" 
                                name="userpassnew" id="r-userpassnew"
                                placeholder="<?php print $encodeExplorer->getString("new_password"); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <input type="hidden" class="form-control" 
                            name="usermailold" id="r-usermailold"
                            value="">

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope fa-fw"></i>
                                </span>
                                <input type="email" class="form-control" 
                                name="usermail" id="r-usermail"
                                value="" 
                                placeholder="<?php print $encodeExplorer->getString("email"); ?>">
                            </div>
                        </div>

                    </div> <!-- row -->

                    <div class="row">
                        <div class="col-md-6 form-group cooldropgroup">
                            <label>
                                <?php print $encodeExplorer->getString("user_folder"); ?>
                            </label>
                            <?php
                            if (empty($availableFolders)) {
                                print "<fieldset disabled>";
                            } ?>
                            <div class="input-group btn-group cooldrop">
                                <span class="input-group-addon">
                                    <i class="fa fa-sitemap fa-fw"></i>
                                </span>
                                <select name="userfolders[]" id="r-userfolders" 
                                class="form-control assignfolder" multiple="multiple">
                                <?php
                                foreach ($setUp->getFolders() as $folder) {
                                    print "<option value=\"".$folder."\"";
                                    print ">".$folder."</option>";
                                } ?>
                                </select>
                            </div>
                            <?php
                            if (empty($availableFolders)) {
                                print "</fieldset>";
                            } ?>
                        </div>

                        <div class="col-md-6">
                            <label><?php print $encodeExplorer->getString("make_directory"); ?></label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-folder fa-fw"></i>
                                </span>
                                <input type="text" class="form-control getfolder assignnew" 
                                name="userfolder" 
                                placeholder="<?php print $encodeExplorer->getString("add_new"); ?>">
                            </div>
                        </div> <!-- col-md-6 -->
                    </div> <!-- row -->

                    <div class="row" style="min-height:60px;">
                        <div class="col-md-6 userquota cooldropgroup">
                            <label><?php print $encodeExplorer->getString("available_space"); ?></label>

                            <div class="input-group btn-group cooldrop">
                                <span class="input-group-addon">
                                    <i class="fa fa-tachometer fa-fw"></i>
                                </span>

                                <select class="form-control coolselect" name="quota" id="r-quota">
                                    <option value=""><?php print $encodeExplorer->getString("unlimited"); ?></option>
                                    <?php
                                    foreach ($_QUOTA as $value) {
                                        print "<option value=\"".$value."\">".$value."MB</option>";
                                    } ?>
                                </select>
                            </div> <!-- input-group -->
                        </div> <!-- col-md-6 userquota -->
                    </div> <!-- row -->

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="btn-group pull-right">
                                <button class="btn btn-info">
                                    <i class="fa fa-refresh"></i> 
                                    <small>
                                        <?php print $encodeExplorer->getString("update_profile"); ?>
                                    </small>
                                </button>

                                <button class="btn btn-danger remove">
                                    <i class="fa fa-trash-o"></i> 
                                    <small><?php print $encodeExplorer->getString("delete"); ?></small>
                                    <input type="hidden" name="delme" class="delme" value="">
                                </button>
                            </div><!-- btn-group -->
                        </div><!-- col-md-12 form-group -->
                    </div><!-- row -->
                </form>
            </div> <!-- modal-body -->

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
