<?php

/* layout.twig */
class __TwigTemplate_15cf3c942c0bd884e5e16ec613fccf1db86ee8a1343e64a8e0a02aae23eaa78c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'css' => array($this, 'block_css'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        ob_start();
        // line 2
        echo "<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Hello</title>

    <!-- Bootstrap -->
    <link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>
      <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
    <![endif]-->

    <style>
";
        // line 22
        $this->displayBlock('css', $context, $blocks);
        // line 32
        echo "    </style>

  </head>
  <body>
";
        // line 36
        $this->displayBlock('content', $context, $blocks);
        // line 44
        echo "    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
  </body>
</html>

";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    // line 22
    public function block_css($context, array $blocks = array())
    {
        // line 23
        echo "    body {
        min-width: 950px;
        font-family: \"Helvetica Neue\",Helvetica,Arial,sans-serif; font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        background-color: #fff;
        margin: 0;
    }
";
    }

    // line 36
    public function block_content($context, array $blocks = array())
    {
        // line 37
        echo "<div class=\"container\">
    <h1>Hello, world!</h1>
    <div class=\"well\">
        ";
        // line 40
        echo (isset($context["title"]) ? $context["title"] : null);
        echo "
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  90 => 40,  85 => 37,  82 => 36,  70 => 23,  67 => 22,  55 => 44,  53 => 36,  47 => 32,  45 => 22,  23 => 2,  21 => 1,);
    }

    public function getSource()
    {
        return "{% spaceless %}
<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Hello</title>

    <!-- Bootstrap -->
    <link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>
      <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
    <![endif]-->

    <style>
{% block css %}
    body {
        min-width: 950px;
        font-family: \"Helvetica Neue\",Helvetica,Arial,sans-serif; font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        background-color: #fff;
        margin: 0;
    }
{% endblock %}
    </style>

  </head>
  <body>
{% block content %}
<div class=\"container\">
    <h1>Hello, world!</h1>
    <div class=\"well\">
        {{ title }}
    </div>
</div>
{% endblock %}
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
  </body>
</html>

{% endspaceless %}
";
    }
}
