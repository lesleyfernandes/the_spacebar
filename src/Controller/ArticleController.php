<?php


namespace App\Controller;

use App\Services\SlackClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
Use Symfony\Component\Routing\Annotation\Route;
Use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{

    /**
     * @var SlackClient
     */
    private $slackClient;

    /**
     * ArticleController constructor.
     * @param SlackClient $slackClient
     */
    public function __construct(SlackClient $slackClient)
    {
        $this->slackClient = $slackClient;
    }

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
     * @param AdapterInterface $cache
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function show(string $slug, AdapterInterface $cache): Response
    {

        $comments = [
            'That is amazing!',
            'Really cool information @:-)'
        ];

        if($slug == 'slack') {
            $this->slackClient->sendMessage('Dark Fox', 'Hey, There!');
        }



        $articleContent = '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aliquam atque
                        cumque cupiditate dignissimos ducimus eius et excepturi ipsum, laudantium minus
                        natus nisi obcaecati, optio perspiciatis sequi, tempore ut voluptate?
                    </p>
                    <p>Adipisci alias aliquam amet aperiam cum distinctio doloribus eius fugit harum id
                        inventore iure laborum modi necessitatibus, nemo officiis pariatur perspiciatis
                        praesentium quam qui recusandae soluta tenetur vel vitae voluptatibus?
                    </p>
                    <p>Deserunt dicta expedita facere fugit impedit laboriosam numquam sapiente sunt?
                        Adipisci aspernatur dolor doloremque laborum neque provident recusandae repellat sit
                        veritatis, vitae? Animi doloribus optio quibusdam quis ratione saepe tempore.
                    </p>
                    <p>Aliquam amet delectus natus nesciunt placeat, quasi qui. Ad aperiam atque beatae
                        culpa cum cumque distinctio dolorum eos, ex inventore laudantium necessitatibus
                        nihil nostrum quasi reprehenderit sapiente ullam velit voluptas.
                    </p>
                    <p>A autem doloremque eius esse harum hic ipsum minima minus nisi nulla obcaecati,
                        odio omnis quas reiciendis rem temporibus velit, vero? Inventore neque nesciunt
                        perspiciatis, quasi quibusdam quis quo sunt!
                    </p>
                    <p>Aperiam ipsa ipsam itaque nobis non quaerat quis ratione reiciendis, vel velit? Ab,
                        alias aperiam consequatur dolorem enim id laboriosam libero numquam quis quos
                        ratione, rem repellat sed suscipit, totam?
                    </p>';

        $cacheItem = $cache->getItem('markdown_' . md5($articleContent));

        if(!$cacheItem->isHit()){
            $cacheItem->set($articleContent);
            $cache->save($cacheItem);
        }

        $articleContent = $cacheItem->get();

        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'comments' => $comments,
            'article' => $articleContent,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     * @param $slug
     * @return JsonResponse
     */
    public function toggleArticleHeart(string $slug): JsonResponse
    {
        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}