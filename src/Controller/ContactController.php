<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Category;
use App\Form\ContactType;
use APP\Service\ContactSer;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request ,
    EntityManagerInterface $manager,
    ?Category $category,
    CategoryRepository $categoryRepository,
    FlashyNotifier $flashyNotifier): Response
    {
      
        $contact = new Contact();
         $form =$this->createForm(ContactType::class , $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $contact = $form->getData();
            $contact->setIsSend(true);
            $manager->persist($contact);
            $manager->flush();
            $flashyNotifier->success('Success Votre message est bien envoyé, merci.');     
            return $this->redirectToRoute("app_contact");          

        }
        

        return $this->render('contact/contact.html.twig', [
            'form' =>$form->createView(),
            'categorys' => $category
        ]);
    }
    
   

}
