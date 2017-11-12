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

    /**
     * return user Nickname
     * @method getNickname
     * @return string      nickname
     */
    public function getNickname() {
      return isset($this->profile['nickname']) ? $this->profile['nickname'] : null;
    }
    
    /**
     * [getLevel description]
     * @method getLevel
     * @return [type]   [description]
     */
    public function getLevel() {
        return $this->profile['user_level'];
    }
}
