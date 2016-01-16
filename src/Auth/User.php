<?php
namespace LionHead\Auth;

use \LionHead\App;
use \LionHead\Container;

class User extends App {

    use UserProfileTrait;

    // статус авторизации пользователя
    private $auth = FALSE;
    // ид пользователя
    private $user_id = 0;
    // ключ авторизации
    private $auth_key = null;
    // DI container
    private $container = null;
    // профиль
    private $profile = array(
        'id' => 0,
        'nickname' => null,
        'user_level' => 0
    );
    // instance LionHead\Session
    private $session;

    /**
     * __construct description
     * @method __construct
     * @param  LionHead\Container $container DI Container
     */
    public function __construct(Container $container, $session = null) {
        $this->container = $container;
        $this->session = $session;

        if (isset($_COOKIE['u.id']) && isset($_COOKIE['u.key']) && strlen($_COOKIE['u.key']) == 32) {
            $this->setVerificationUser($_COOKIE['u.id'], $_COOKIE['u.key']);
        }
        // перезаписываем данные полученные с "печенек", себе надо доверять больше
        if (isset($_SESSION['u.id']) && isset($_SESSION['u.key']) && strlen($_SESSION['u.key']) == 32) {
            $this->setVerificationUser($_SESSION['u.id'], $_SESSION['u.key']);
        }

    }

    /**
     * Verification user data
     * @method setVerification
     * @param  int             $id  [description]
     * @param  [type]          $key [description]
     */
    private function setVerificationUser(int $id, string $key){
        $id = intval($id);
        $key = htmlspecialchars(trim($key), ENT_QUOTES);

        if ($id > 0) {
            $this->checkUser($id, $key);
        }

        // else - guest
    }

    /**
     * [checkUser description]
     * @method checkUser
     * @param  int       $id  [description]
     * @param  string    $key [description]
     * @return [type]         [description]
     */
    private function checkUser(int $id, string $key)
    {
        $profile = $this->getUserInfo($id);

        if ($profile['auth_key'] == $key) {
            $this->updLastVisit($id);

            $this->auth = TRUE;
            $this->id = $id;
            $this->auth_key = $key;
            $this->profile = $profile;

        } else {
                // user not found
        }
    }

    /**
     * return user profile by user id
     * @method getUserInfo
     * @param  int           $id user id
     * @return array         user info
     */
    public function getUserInfo(int $id)
    {
        $pre = $this->container['database']->request('SELECT * FROM `users_main` WHERE `id` = ?', [$id]);

        if ($pre->rowCount() <> 1){
            throw new UserException("User not found", 404);
        }

        return $pre->fetch();
    }

    /**
     * return user Id
     * @method getId
     * @return int user id
     */
    public function getId() {
        return $this->profile['id'];
    }


    /**
     * return user Nickname
     * @method getNickname
     * @return string      nickname
     */
    public function getNickname() {
        return $this->profile['nickname'];
    }

    /**
     * return user auth status
     * @method getAuth
     * @return bool  auth status
     */
    public function getAuth() {
        return $this->auth;
    }

    /**
     * [getLevel description]
     * @method getLevel
     * @return [type]   [description]
     */
    public function getLevel() {
        return $this->profile['user_level'];
    }

    /**
     * return all profile info
     * @method getProfile
     * @return array    user profile
     */
    public function getProfile() {
        return $this->profile;
    }

    /**
     * create New User profile
     * @method createNewUser
     * @param  string       $key     user auth_key
     * @param  array        $profile user profile data
     * @return int                   new user id
     */
    public function createNewUser($key = NULL, $profile = NULL) {
        if (!isset($profile['nickname'])) {
            $profile['nickname'] = NULL;
        }
        if (!isset($profile['password'])) {
            $profile['password'] = NULL;
        }
        if (!isset($profile['email'])) {
            $profile['email'] = NULL;
        }

        $db = $this->container['database'];

        $sql = 'INSERT INTO `users_main` SET
        `nickname` = :nickname,
        `pass` = :password,
        `email` = :email,
        `auth_key` = :key,
        `created` = :time,
        `last_visit` = :time';

        $db->request($sql, [
            ':nickname' => $profile['nickname'],
            ':password' => $profile['password'],
            ':email' => $profile['email'],
            ':key' => $key,
            ':time' => $_SERVER['REQUEST_TIME'],
        ]);

        return $db->lastInsertId();
    }

    /**
     * [setVerificationInfo description]
     * @method setVerificationInfo
     * @param  int                 $id  [description]
     * @param  [type]              $key [description]
     */
    public function setVerificationInfo(int $id, $key) {
        setcookie('u.id', $id, ( $_SERVER['REQUEST_TIME'] + SESSION_LIFE_TIME), '/');
        setcookie('u.key', $key, ( $_SERVER['REQUEST_TIME'] + SESSION_LIFE_TIME), '/');

        $_SESSION['u.id'] = $id;
        $_SESSION['u.key'] = $key;
    }



    /**
     * [logout description]
     * @method logout
     * @return [type] [description]
     */
    public function logout() {
        setcookie('u.id', '', 0, '/');
        setcookie('u.key', '', 0, '/');

        unset($_SESSION['u.id']);
        unset($_SESSION['u.key']);

        session_unset();
        session_destroy();

        $this->auth = false;
    }

    /**
     * [updLastVisit description]
     * @method updLastVisit
     * @param  int          $id [description]
     * @return [type]           [description]
     */
    private function updLastVisit(int $id)
    {
        $sql = 'UPDATE `users_main` SET `last_visit` =  ? , `ip` = ? WHERE  `id` = ? ';

        $this->container['database']->request($sql, [
            $_SERVER['REQUEST_TIME'],
            $_SERVER['REMOTE_ADDR'],
            $id
        ]);
    }

}
