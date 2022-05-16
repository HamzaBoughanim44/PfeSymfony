<?php

namespace App\Controller;

use DateTime;
use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\AddressType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    




    #[Route('/checkout', name: 'app_checkout')]
    public function index(?Category $category,
    CategoryRepository $categoryRepository,
    Request $request,
     FlashyNotifier $flashyNotifier,
     EntityManagerInterface $manager,
     ): Response
    {
        $category = $categoryRepository->findAll();
        $user = $this->getUser();

        $address = new Address();
        $form = $this->createForm(AddressType::class , $address);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $address = $form->getData();
           
           // $commentService->persistComment($comment ,$product ,null);
           // $address->setDatecomment(new DateTime());
           $manager->persist($address);
           $manager->flush();
            $flashyNotifier->success('C était bien ajouté, merci.'); 
            return $this->redirectToRoute("app_checkout") ;    

         
           
        }
        
        return $this->render('checkout/index.html.twig', [
            'categorys' => $category,
            'AddressForm'=>$form->createView(),
        ]);
    }
}
