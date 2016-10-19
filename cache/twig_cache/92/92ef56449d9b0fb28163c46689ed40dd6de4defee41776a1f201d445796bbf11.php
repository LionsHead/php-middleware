<?php

/* home.twig */
class __TwigTemplate_dcd58b7774e14f6e9d97e6b745e3a97754057f3ca1fa74e22481ebd1a5a0739c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "home.twig", 1);
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
        echo ".hello {
    margin-top: 50px;
}
";
    }

    // line 7
    public function block_content($context, array $blocks = array())
    {
        // line 8
        ob_start();
        // line 9
        echo "<div class=\"container\">

<div class=\"row hello\">
        <h1>Welcome to HERESY</h1>
        <div class=\"well\">
             ";
        // line 14
        echo (isset($context["title"]) ? $context["title"] : null);
        echo "
        </div>
</div>

<div class=\"row text-center\">
    <p><img src=\"http://152617.selcdn.com/d2cdn/d2.png\"></p>
</div>

<div class=\"row\">
    <pre> ";
        // line 23
        echo twig_var_dump($this->env, $context, (isset($context["environment"]) ? $context["environment"] : null));
        echo " </pre>
</div>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "home.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 23,  51 => 14,  44 => 9,  42 => 8,  39 => 7,  32 => 3,  29 => 2,  11 => 1,);
    }

    public function getSource()
    {
        return "{% extends 'layout.twig' %}
{% block css %}
.hello {
    margin-top: 50px;
}
{% endblock %}
{% block content %}
{% spaceless %}
<div class=\"container\">

<div class=\"row hello\">
        <h1>Welcome to HERESY</h1>
        <div class=\"well\">
             {{ title }}
        </div>
</div>

<div class=\"row text-center\">
    <p><img src=\"http://152617.selcdn.com/d2cdn/d2.png\"></p>
</div>

<div class=\"row\">
    <pre> {{ dump(environment) }} </pre>
</div>
{% endspaceless %}
{% endblock %}
";
    }
}
