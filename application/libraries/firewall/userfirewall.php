<?php

/**
 * Description of UserFirewall
 *
 * @author leo
 */
class UserFirewall {

    /**
     * 
     * @param User $CI
     */
    public function profil($CI) {
        $id=$CI->uri->rsegment(3);
        if($id==$CI->usersession->getInfos(UserSession::ID)) {
            return true;
        }
        return false;
    }

}

?>
