<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleAddType;
use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{

    #[Route('/category/news', name: 'app_category_news')]
    public function indexNews(ArticleRepository $articleRepository): Response
    {
        return $this->render('category/template.html.twig', [
            'article_list' => $articleRepository->findArticleInCategoryByDate('promo'),
            'page' => [
                'name' => 'Новости',
                'description' => 'На данной странице изображены новости, проходящие в мире.'
            ]
        ]);
    }

    #[Route('/category/promo', name: 'app_category_promo')]
    public function indexPromo(ArticleRepository $articleRepository): Response
    {
        return $this->render('category/template.html.twig', [
            'article_list' => $articleRepository->findArticleInCategoryByDate('promo'),
            'page' => [
                'name' => 'Промо',
                'description' => 'На данной странице изображены промо.'
            ]
        ]);
    }

    #[Route('/category/events', name: 'app_category_events')]
    public function indexEvents(ArticleRepository $articleRepository): Response
    {
        return $this->render('category/template.html.twig', [
            'article_list' => $articleRepository->findArticleInCategoryByDate('promo'),
            'page' => [
                'name' => 'Мероприятия',
                'description' => 'На данной странице изображены мероприятия, проходящие в мире.'
            ]
        ]);
    }

    #[Route('/add', name: 'app_article')]
    public function addArticle(Request $request, ParameterBagInterface $params, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleAddType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $params->get('kernel.project_dir') . '\public\article_images\\' . $form->get('photoFileName')->getData();

            if (!file_exists($file)) {
                $this->addFlash('error', 'Не найдено изображение!');
            }

            $article = new Article();

            $article->setName($form->get('name')->getData());
            $article->setText($form->get('text')->getData());
            $article->setCategory($form->get('category')->getData());
            $article->setPhotoFileName($form->get('photoFileName')->getData());
            $article->setDate(new DateTimeImmutable());

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->index();
        }

        return $this->render('category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/', name: 'app_index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = [
            $articleRepository->findOneArticleInCategoryByDate('news'),
            $articleRepository->findOneArticleInCategoryByDate('events'),
            $articleRepository->findOneArticleInCategoryByDate('promo')
        ];
        return $this->render('index/index.html.twig', [
            'article_list' => $articles
        ]);
    }
}
