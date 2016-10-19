<?php

/* exception/not_found.twig */
class __TwigTemplate_e483464796a1c235622418e2684b4a70f1c78a7aba1bf37b1d056c3296eb11a3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "exception/not_found.twig", 1);
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
.titleExt {
    font-size: 900%;
}

.headExt {
    width: 100%;
    margin: 1em;
}
.container {
    width: 950px;
}
";
    }

    // line 16
    public function block_content($context, array $blocks = array())
    {
        echo " ";
        ob_start();
        // line 17
        echo "<div class=\"container\">
    <div class=\"row\">
        <div class=\"headExt\">
            <h1 class=\"titleExt\"> ";
        // line 20
        echo (isset($context["code"]) ? $context["code"] : null);
        echo "</h1>
            <h2><span> ";
        // line 21
        echo (isset($context["title"]) ? $context["title"] : null);
        echo " </span></h2>
        </div>
        <div class=\"text-center\"> </div>
    </div>


    <div class=\"row text-left\">
        Не пытайтесь найти эту страницу, в этом нет смысла. Все - тлен, мрак и отчаяние.
    </div>
</div>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 31
        echo " ";
    }

    public function getTemplateName()
    {
        return "exception/not_found.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 31,  63 => 21,  59 => 20,  54 => 17,  49 => 16,  32 => 3,  29 => 2,  11 => 1,);
    }
}
/* {% extends 'layout.twig' %}*/
/* {% block css %}*/
/* {{ parent() }}*/
/* .titleExt {*/
/*     font-size: 900%;*/
/* }*/
/* */
/* .headExt {*/
/*     width: 100%;*/
/*     margin: 1em;*/
/* }*/
/* .container {*/
/*     width: 950px;*/
/* }*/
/* {% endblock %}*/
/* {% block content %} {% spaceless %}*/
/* <div class="container">*/
/*     <div class="row">*/
/*         <div class="headExt">*/
/*             <h1 class="titleExt"> {{ code }}</h1>*/
/*             <h2><span> {{ title }} </span></h2>*/
/*         </div>*/
/*         <div class="text-center"> </div>*/
/*     </div>*/
/* */
/* */
/*     <div class="row text-left">*/
/*         Не пытайтесь найти эту страницу, в этом нет смысла. Все - тлен, мрак и отчаяние.*/
/*     </div>*/
/* </div>*/
/* {% endspaceless %} {% endblock %}*/
/* */
