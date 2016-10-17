<?php

/**
 * http kernel middleware
 * example use function push & unshift
 *
 * 	$app->push(function (
 * 		$app,          #  instance of LionHead\Kernel
 * 		$request,      # instance of HttpFoundation\Requerst
 * 	) {
 * 		# code
 * 		return new response($request);
 *  });
 *
 *  $app->push(
 *  	'App\Middleware\ClassName', # instanceof kernel\terminate middleware
 *  	 $args.. # __counstruct($app, arguments)
 *  );
 *
 *
 */

$app->push('App\Middleware\Auth', getenv('SESSION_STORE'));

$app->push('App\Middleware\Terminate');
