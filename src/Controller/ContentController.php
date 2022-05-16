<?php

namespace App\Controller;

use DateTime;
use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\User;
use App\Form\CommentType;
use App\Service\CommentService;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
//use Symfony\Bridge\Doctrine\ManagerRegistry;

class ContentController extends AbstractController
{
    #[Route('/content/{id}', name: 'app_content')]
    public function content($id, Product $product ,
     Request $request ,
     ?Category $category,
      CategoryRepository $categoryRepository,
      FlashyNotifier $flashyNotifier,
      EntityManagerInterface $manager,
      ProductRepository $productRepository,
      ManagerRegistry $doctrine   
      
      ): Response 
    { 
        $category = $categoryRepository->findAll();
        //$product = $productRepository->findOneBy(['id'=> $id]);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class , $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment = $form->getData();
           // $commentService->persistComment($comment ,$product ,null);
           $product = $productRepository->findOneBy(['id'=> $id]);
           $manager = $doctrine->getManager();
           $manager->persist($comment);
           $manager->flush();
           // $comment->setDatecomment(new DateTime());
            $flashyNotifier->success('C était bien ajouté, merci.');
           // return $this->redirectToRoute("app_content");      
        }
        

        return $this->render('content/content.html.twig', [
            'product' => $product,
            'commentForm'=>$form->createView(),
            'categorys' => $category
            
        ]);
    }
}
