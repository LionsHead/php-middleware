<?php

namespace App;

use \LionHead\App;
use \LionHead\Http\Response;
/**
 * start page
 */
class Home extends App
{

    public function display()
    {
        return new Response(
            $this->get('view')->render('home.twig', [
                'title' => $this->config('title'),
                'environment' => $this->get('configs')
            ])
        );
    }
}
