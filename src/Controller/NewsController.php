<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/news/add", name="news_add")
     * @Route("/news/edit/{id}", name="news_edit")
     */
    public function news_add(Request $request, EntityManagerInterface $entityManager, News $news = null)
    {
        if (!$news) {
            $news = new News();
        }

        $newsform = $this->createForm(NewsType::class, $news);

        $newsform->handleRequest($request);

        if ($newsform->isSubmitted() && $newsform->isValid()) {


            $news->setActive(1);

            $entityManager->persist($news);
            $entityManager->flush();

            $this->addFlash("success", "Sikeres hozzáadás");
            return $this->redirectToRoute("news");
        }

        return $this->render('news/edit.html.twig', [
            'newsform' => $newsform->createView()
        ]);

    }

    /**
     * @Route("/news", name="news")
     */
    public function all_news(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $news = $entityManager->getRepository(News::class)->findAll();
        return $this->render('news/all.html.twig', [
            'error' => '', 'news' => $news
        ]);
    }

    /**
     * @Route("/news/delete/{id}", name="news_delete")
     */
    public function news_delete(EntityManagerInterface $entityManager, Request $request, NewsRepository $newsRepository, News $news)
    {

        $entityManager->remove($news);
        $entityManager->flush();
        $error = "";
        return $this->render('news/all.html.twig', [
            'error' => ''
        ]);
    }

    /**
     * @Route("/news/readable_news", name="readable_news")
     */
    public function readable_news(EntityManagerInterface $entityManager)
    {
        $news = $entityManager->getRepository(News::class)->getReadableNews($this->getUser());
        return $this->render('news/all.html.twig', [
            'error' => '', 'news' => $news
        ]);
    }

    /**
     * @param News $news
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/news/{slug}",name="news_get_news")
     */
    public function getNews(News $news)
    {
        return $this->render('news/detail.html.twig',
            ['news' => $news]);
    }
}
