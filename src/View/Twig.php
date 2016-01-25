<?php

namespace LionHead\View;

use \LionHead\App;

class Twig extends App
{
    private $twig_loader;
    private $twig_env;

    private $get = null;

    /**
     * [__construct description]
     * @method __construct
     * @param  LionHeadContainer $container [description]
     */
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

    /**
     * [add description]
     * @method add
     * @param  [type] $name [description]
     * @param  [type] $val  [description]
     */
    public function add($name, $val)
    {
        $this->twig_env->addGlobal($name, $val);
    }

    /**
     * [render description]
     * @method render
     * @param  [type] $tpl  [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function render($tpl, array $data = [])
    {
        $template = $this->twig_env->loadTemplate($tpl);
        return $template->render($data);
    }

    /**
     * [display description]
     * @method display
     * @param  [type]  $tpl  [description]
     * @param  [type]  $data [description]
     * @return [type]        [description]
     */
    public function display($tpl, array $data = [])
    {
        $template = $this->twig_env->loadTemplate($tpl);
        $template->display($data);
    }


}
