<div class="row">
<?php
/**
* LIST USERS
*/
foreach ($utenti as $key => $user) {
    $usermail = isset($user['email']) ? $user['email'] : "";
    $userquota = isset($user['quota']) ? $user['quota'] : "";
    $userdirs = isset($user['dir']) ? json_decode($user['dir']) : false;
    ?>
    <div class="col-sm-6">
        <div class="pull-left intero usrblock">
            <button class="btn btn-block usrindex" data-toggle="modal" data-target="#modaluser">
            <i class="fa fa-pencil-square-o" ></i> <span><strong><?php echo $user['name']; ?> </strong></span>
            <span class="small"><em><?php echo "(".$user['role'].")";?></em></span></button>
            <input type="hidden" value="<?php echo $user['name']; ?>" class="s-username">
            <input type="hidden" value="<?php echo $user['pass']; ?>" class="s-userpass">
            <input type="hidden" value="<?php echo $userquota; ?>" class="s-quota">
            <input type="hidden" value="<?php echo $usermail; ?>" class="s-usermail">
            <input type="hidden" value="<?php echo $user['role']; ?>" class="s-role">
    <?php
    if ($userdirs) {
        foreach ($userdirs as $dir) {
            echo " <input type=\"hidden\" value=\"".$dir."\" class=\"s-userfolders\">";
        }
    }
    ?>
        </div> <!-- usrblock -->
    </div> <!-- col 6 -->
    <?php
   
} // end foreach ?>
</div>