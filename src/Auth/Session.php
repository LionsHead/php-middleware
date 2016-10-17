<?php
namespace LionHead\Auth;


class Session {

    //
    private $session_name = 'sid';

    /**
     * session start
     * @method __construct
     */
    public function __construct($container = null, $save_handler = null) {
        $this->iniSet($save_handler);

        session_name($this->session_name);
        session_set_cookie_params(SESSION_LIFE_TIME, '/');

        if (!$this->session_start()) {
            session_id(uniqid());
            session_start();
            session_regenerate_id();
        }

        setcookie(session_name(), session_id(), ($_SERVER['REQUEST_TIME'] + SESSION_LIFE_TIME), '/', HOME_URL, 0, 1);
    }

    /**
     * костыль для возникновении ошибки
     * Warning: session_start() [function.session-start]:
     * The session id contains illegal characters, valid characters are a-z, A-Z, 0-9 and '-,' in /home/path on line 17
     * @return boolean
     */
    private function session_start() {
        $s_name = session_name();
        if (isset($_COOKIE[$s_name])) {
            $sessid = $_COOKIE[$s_name];
        } else if (isset($_GET[$s_name])) {
            $sessid = $_GET[$s_name];
        } else {
            return session_start();
        }

        if (!preg_match('/^[a-zA-Z0-9,\-]{22,40}$/', $sessid)) {
            return false;
        }
        return session_start();
    }

    /**
     * [iniSet description]
     * @method iniSet
     * @return [type] [description]
     */
    public function iniSet()
    {
            ini_set('session.use_trans_sid', '0');
            ini_set('session.use_cookies', '1');
            ini_set('session.use_only_cookies', '1');

            ini_set('session.gc_maxlifetime', SESSION_LIFE_TIME);
            ini_set('session.gc_probability', '1');
            ini_set('session.gc_divisor', '100');

            // выбор хранилища
            switch (strtolower(getenv('SESSION_STORE'))) {
                case 'memcached':
                    ini_set('session.save_handler', 'memcached');
                    ini_set('session.save_path', 'localhost:11211?persistent=1&weight=1&timeout=1&retry_interval=15');
                    break;
                case 'memcache':
                    ini_set('session.save_handler', 'memcache');
                    ini_set('session.save_path', 'tcp://localhost:11211?persistent=1&weight=1&timeout=1&retry_interval=15');
                    break;

                default:
                    # default save_handler
                    break;
            }
    }
}
