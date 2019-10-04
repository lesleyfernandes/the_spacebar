<?php


namespace App\Controller;

Use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    public function homepage()
    {
        return new Response('Home Page');
    }
}