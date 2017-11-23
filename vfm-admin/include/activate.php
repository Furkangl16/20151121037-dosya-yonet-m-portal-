<?php

function removeUserFromValue($array, $key, $value)
{
    foreach ($array as $subKey => $subArray) {
        if ($subArray[$key] == $value) {
            unset($array[$subKey]);
        }
    }
    return $array;
}

/**
* remove old standby registrations
*
* @param array  $array    array where to search
* @param key    $key      key to search
* @param string $lifetime max lifetime
*
* @return null/$new_image
*/
function removeOldReg($array, $key, $lifetime)
{
    foreach ($array as $subKey => $subArray) {
        $data = strtotime($subArray[$key]);

        if ($data <= $lifetime) {
            unset($array[$subKey]);
        }
    }
    return $array;
}

if ($regactive && $setUp->getConfig("registration_enable") == true) :

    if (file_exists('vfm-admin/users/users-new.php')) {
        include 'vfm-admin/users/users-new.php';

        if (!empty($newusers)) {
        
            global $users;
            global $newusers;

            $newuser = $updater->findUserKey($regactive);
            
            if ($newuser !== false) {
                $username = $newuser['name'];
                $usermail = $newuser['email'];

                if ($updater->findUser($username) === false && $updater->findEmail($usermail) === false) {
                    array_push($users, $newuser);
                    $updater->updateUserFile('new');
                } else {
                    $_ERROR = "<strong>".$username."</strong> ".$encodeExplorer->getString("file_exists");
                }
                //
                // clean old non confirmed users 
                // clean current confirmed user
                //
                $newusers = removeUserFromValue($newusers, 'name', $username);
                $newusers = removeUserFromValue($newusers, 'email', $usermail);

                $lifetime = strtotime("-1 day");
                $newusers = removeOldReg($newusers, 'date', $lifetime);

                if ($updater->updateRegistrationFile($newusers, 'vfm-admin/users/')) {
                    $_SUCCESS = $encodeExplorer->getString("registration_completed");
                } else {
                    $_WARNING = "failed updating registration file";
                }
            } else {
                $_ERROR = $encodeExplorer->getString("invalid_link");
            } 
        } else {
            $_ERROR = $encodeExplorer->getString("link_expired");
        } 
    }

endif;