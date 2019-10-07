<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
Use Symfony\Component\Routing\Annotation\Route;
Use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     * @return Response
     */
    public function homepage(): Response
    {
        return $this->render("article/homepage.html.twig");
    }

    /**
     * @Route("/news/{slug}", name="app_news")
     * @param string $slug The URL slug from the news page
     * @return Response
     */
    public function show(string $slug): Response
    {
        $comments = [
            'That is amazing!',
            'Really cool information @:-)'
        ];

        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     * @param $slug
     * @return JsonResponse
     */
    public function toggleArticleHeart(string $slug): JsonResponse
    {
        return new JsonResponse(['hearts' => rand(5,100)]);
    }
}