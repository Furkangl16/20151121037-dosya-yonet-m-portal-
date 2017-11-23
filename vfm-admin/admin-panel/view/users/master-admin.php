    <?php
    /**
    * DISPLAY MASTER-ADMIN
    */
    ?>
<div class="col-sm-6">
    
    <form role="form" method="post" autocomplete="off" 
    action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?users=updatemaster" 
    enctype="multipart/form-data">
            
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title"><i class="vfmi vfmi-king"></i></a> Master Admin</h4>
            </div>

            <div class="box-body">
                <div class="form-group pull-left intero">

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user fa-fw"></i>
                                </span>
                                <input type="hidden" class="form-control" 
                                name="masterusernameold" 
                                value="<?php echo $king['name']; ?>">

                                <input type="text" class="form-control" 
                                name="masterusername" 
                                value="<?php echo $king['name']; ?>">
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-check fa-fw"></i>
                                </span>
                                <input type="text" class="form-control" readonly 
                                value="<?php echo $king['role']; ?>">
                            </div>
                        </div>   
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="hidden" class="form-control" 
                            name="masteruserpass" 
                            value="<?php echo $king['pass']; ?>">

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock fa-fw"></i>
                                </span>
                                <input type="password" class="form-control" 
                                name="masteruserpassnew" 
                                placeholder="<?php print $encodeExplorer->getString("new_password"); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <input type="hidden" class="form-control" 
                            name="masterusermailold" 
                            value="<?php echo $kingmail; ?>">

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope fa-fw"></i>
                                </span>
                                <input type="email" class="form-control" 
                                name="masterusermail" 
                                value="<?php echo $kingmail; ?>" 
                                placeholder="<?php print $encodeExplorer->getString("email"); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 form-group">
                        </div>
                        <div class="col-xs-6 form-group">
                            <button class="btn btn-info btn-block pull-right">
                                <i class="fa fa-refresh"></i> 
                                <small>
                                    <?php print $encodeExplorer->getString("update_profile"); ?>
                                </small>
                            </button>
                        </div>
                    </div> <!-- row -->
                </div>
            </div>
        </div>
    </form>
</div>