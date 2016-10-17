<?php
/**
 *  Routes
 * addRoute(method, url, calleble handler)
 *  - method = GET/POST/DELETE/etc
 *  - url = route/path/{param_name}[/maybe_param]
 *  - handler = Closure function (array $args, \LionHead\Container $container) {
 *  	# run code
 *  }
 *
 * Example:
 *  $app->addRoute('GET', '/users', Closure);
 *   {id} must be a number (\d+)
 *
 *  $app->addRoute('GET', '/user/{id:\d+}', Closure);
 *   The /{title} suffix is optional
 *
 *  $app->addRoute('GET', '/articles/{id:\d+}[/{title}]', Closure);
 */

$app->addRoute('GET', '/', function ($arg, $di) {
    return ( new \App\Home($di) )->display();
});
