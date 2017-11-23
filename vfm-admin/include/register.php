<?php

if (!$gateKeeper->isAccessAllowed()
    && $setUp->getConfig("registration_enable") == true 
) { ?>
    
    <script type="text/javascript" src="vfm-admin/js/registration.js"></script>

    <section class="vfmblock">
        <div class="login">
            <div id="regresponse"></div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user-plus"></i> <?php print $encodeExplorer->getString('registration'); ?>
                </div>
                <div class="panel-body">

                    <form id="regform" action="<?php print $encodeExplorer->makeLink(false, null, ""); ?>">
                        
                        <input type="hidden" id="trans_pwd_match" value="<?php echo $encodeExplorer->getString("passwords_dont_match"); ?>">
                        <input type="hidden" id="trans_accept_terms" value="<?php echo $encodeExplorer->getString("accept_terms_and_conditions"); ?>">

                        <div id="login_bar" class="form-group">
                            <div class="form-group">
                                <div class="has-feedback">
                                    <label for="user_name">
                                        <?php echo $encodeExplorer->getString("username"); ?>
                                    </label>  
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="fa fa-user fa-fw"></i>
                                        </span>
                                        <input type="text" name="user_name" value="" id="user_name" class="form-control" />
                                    </div>
                                    <span class="glyphicon glyphicon-minus form-control-feedback"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_pass">
                                    <?php echo $encodeExplorer->getString("password"); ?>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    <input type="password" name="user_pass" id="user_pass" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_pass">
                                    <?php echo $encodeExplorer->getString("password")
                                    ." (".$encodeExplorer->getString("confirm").")"; ?>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    <input type="password" name="user_pass_confirm" id="user_pass_check" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_email">
                                    <?php echo $encodeExplorer->getString("email"); ?>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                    <input type="email" name="user_email" 
                                    class="form-control" />
                                </div>
                            </div>

                            <?php
                            $disclaimerfile = 'vfm-admin/registration-disclaimer.html';
    if (file_exists($disclaimerfile)) {
                                $disclaimer = file_get_contents($disclaimerfile);
                                echo $disclaimer; ?>

                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox" id="agree" name="agree"> Accept <a href="#" data-toggle="modal" data-target="#disclaimer" required><u>terms and conditions</u></a>
                                    </label>
                                </div>
    <?php
    } ?>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" />
                                    <i class="fa fa-check"></i> 
                                    <?php print $encodeExplorer->getString("register"); ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mailpreload"></div>
            </div>
            <a href="?dir="><i class="fa fa-sign-in"></i>  <?php print $encodeExplorer->getString("log_in"); ?></a>
        </div>
    </section>
    <?php
}