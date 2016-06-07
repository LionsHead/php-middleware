<?php
namespace LionHead\Auth;

/**
 *
 */
trait UserProfileTrait
{
    /**
     * getIP description
     * @method getIP
     * @return int - last used ip address
     */
    public function getIP() {
        return isset($this->profile['ip']) ? $this->profile['ip'] : null;
    }
}
