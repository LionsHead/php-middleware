<?php

/* exception/exception.twig */
class __TwigTemplate_8a469767647f0589af29c9dc9694d095f2d99a3125d36d096edfedadc7b8f66e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "exception/exception.twig", 1);
        $this->blocks = array(
            'css' => array($this, 'block_css'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_css($context, array $blocks = array())
    {
        // line 3
        $this->displayParentBlock("css", $context, $blocks);
        echo "
.head-text {
    font-size: 24px;
    color: #;
}
pre {
    display: block;
    padding: 5px; margin-top: 10px;
    color: #333;
    word-break: break-all; word-wrap: break-word;
    background-color: #f5f5f5;
    border: 1px solid #ccc; border-radius: 4px;
}
.container {
    width: 950px;
}
";
    }

    // line 20
    public function block_content($context, array $blocks = array())
    {
        echo " ";
        ob_start();
        // line 21
        echo "<nav class=\"navbar navbar-default navbar-static-top\">
  <div class=\"container\">
    <div class=\"navbar-header\">
      <p class=\"navbar-text head-text\"><b>Ошибка выполнения сценария</b> </p>
    </div>
  </div>
</nav>

<div class=\"container\">
    <div class=\"row\"> ";
        // line 30
        echo (isset($context["message"]) ? $context["message"] : null);
        echo "</div>
</div>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 32
        echo " ";
    }

    public function getTemplateName()
    {
        return "exception/exception.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 32,  69 => 30,  58 => 21,  53 => 20,  32 => 3,  29 => 2,  11 => 1,);
    }
}
/* {% extends 'layout.twig' %}*/
/* {% block css %}*/
/* {{ parent() }}*/
/* .head-text {*/
/*     font-size: 24px;*/
/*     color: #;*/
/* }*/
/* pre {*/
/*     display: block;*/
/*     padding: 5px; margin-top: 10px;*/
/*     color: #333;*/
/*     word-break: break-all; word-wrap: break-word;*/
/*     background-color: #f5f5f5;*/
/*     border: 1px solid #ccc; border-radius: 4px;*/
/* }*/
/* .container {*/
/*     width: 950px;*/
/* }*/
/* {% endblock %}*/
/* {% block content %} {% spaceless %}*/
/* <nav class="navbar navbar-default navbar-static-top">*/
/*   <div class="container">*/
/*     <div class="navbar-header">*/
/*       <p class="navbar-text head-text"><b>Ошибка выполнения сценария</b> </p>*/
/*     </div>*/
/*   </div>*/
/* </nav>*/
/* */
/* <div class="container">*/
/*     <div class="row"> {{ message }}</div>*/
/* </div>*/
/* {% endspaceless %} {% endblock %}*/
/* */
