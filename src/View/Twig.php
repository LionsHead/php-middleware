<?php

namespace LionHead\View;

use \LionHead\App;

class Twig extends App
{
    private $twig_loader;
    private $twig_env;

    public $pg_current_page = 1;
    public $pg_last_page = 1;
    public $pg_limit = 10;

    private $get = null;

    public function __construct(\LionHead\Container $container) {
        $this->get = $container;

        $this->twig_loader = new \Twig_Loader_Filesystem(PATH_TEMPLATE);
        $this->twig_env = new \Twig_Environment($this->twig_loader, [
          'cache' => PATH_TEMPLATE_CACHE,
          'debug' => true,
          'autoescape' => false
      ]);

        $this->twig_env->addExtension(new \Twig_Extension_Debug());
        $this->twig_env->getExtension('core')->setDateFormat('j.m.Y, H:i', '%d days');
    }

    public function add($name, $val)
    {
        $this->twig_env->addGlobal($name, $val);
    }

    public function render($tpl, array $data = [])
    {
        $template = $this->twig_env->loadTemplate($tpl);
        return $template->render($data);
    }

    public function display($tpl, array $data = [])
    {
        $template = $this->twig_env->loadTemplate($tpl);
        $template->display($data);
    }

    /**
     * [setLimit description]
     * @method setLimit
     * @param  integer  $limit [description]
     */
    public function setLimit($limit = 10)
    {
        $this->pg_limit = $limit;
        return $this;
    }

    /**
     * [getLastPage description]
     * @method getLastPage
     * @return integer      [description]
     */
    public function getLastPage()
    {
        return $this->pg_last_page;
    }

    /**
     * [getCurrentPage description]
     * @method getCurrentPage
     * @return integer         [description]
     */
    public function getCurrentPage()
    {
        return $this->pg_current_page;
    }

    /**
     * Создание постраничной навигации
     * @param integer $all - всего элементов
     * @param integer $limit - сколько отображать на странице
     */
    public function setPagination($all = 10) {
        $this->pg_last_page = ceil($all / $this->pg_limit);
        $this->pg_current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    }

    /**
     * Получение универсальной конструкции
     *  LIMIT x (сколько) OFFSET y (откуда начинать) для sql запроса
     *  работает с mysql, postgresql, sqlite
     * @return string
     */
    public function getOffset($all = 10) {
        $this->setPagination($all);

        if ( $this->pg_current_page < 1 or $this->pg_current_page > $this->pg_last_page){
            $this->pg_current_page = $this->pg_last_page;
        }

        if ($this->pg_last_page > 1) {
            return ' LIMIT ' .$this->limit . ' OFFSET ' . ( ($this->pg_current_page - 1) * $this->pg_limit );
        } else {
            return ' ';
        }
    }
}
