<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Category;
use App\Form\AddressType;
use Doctrine\ORM\EntityManager;
use App\Repository\AddressRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/adresse', name: 'app_adresse')]
class AdresseController extends AbstractController
{
    #[Route('/', name: 'app_adresse')]
    public function index(?Category $category,
     CategoryRepository $categoryRepository,
     AddressRepository $addressRepository
    ): Response
    {
        $category = $categoryRepository->findAll();
        return $this->render('adresse/index.html.twig', [
            'categorys' => $category,
            'addresse'=>$addressRepository->findAll()
        ]);
    }

    #[Route('/new/{id}', name: 'app_adresse_new')]
    public function new(Request $request ,
     EntityManagerInterface $entityManager,
     Address $adress){
      $adress = new Address();
      $form = $this->createForm(AddressType::class, $adress);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
        $user = $this->getUser();
        $adress->setUser($user);
        $entityManager->persist($adress);
        $entityManager->flush();
        $this->addFlash('adress_message','votre adress a bien été ajouté');
        return $this->redirectToRoute('app_panier',[],Response::HTTP_SEE_OTHER);

      }
      return $this->renderForm('adresse/index.html.twig' ,[
        'address'=> $adress,
        'form'=> $form,
      ]);

    }




    #[Route('/{id}/edit', name: 'app_adresse_new' , methods: 'GET POST')]
    public function edit(Request $request ,
     EntityManagerInterface $entityManager,
     Address $adress){
      
      $form = $this->createForm(AddressType::class, $adress);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
       
        $entityManager->flush();
        $this->addFlash('adress_message','votre adress a bien été modifiée');
        return $this->redirectToRoute('app_panier',[],Response::HTTP_SEE_OTHER);

      }
      return $this->renderForm('adresse/index.html.twig' ,[
        'address'=> $adress,
        'form'=> $form,
      ]);

    }

    
}
