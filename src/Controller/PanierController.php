<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function panier(SessionInterface $session ,
     ProductRepository $productRepository,
      ?Category $category ,
       CategoryRepository $categoryRepository,
       FlashyNotifier $flashyNotifier): Response
    {
        $panier = $session->get('panier' , []);
        $panierWithData = [];
        foreach($panier as $id => $quantity){

            $panierWithData[] = [
                'product' => $productRepository->find($id) ,
                'quantity' => $quantity

            ];
        }
        $total = 0;
        foreach($panierWithData as $item ){
    
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;

        }
        $category = $categoryRepository->findAll();
        //$flashyNotifier->success('C était bien ajouté, merci.');     

        return $this->render('panier/panier.html.twig', [
            'items' => $panierWithData,
            'total' => $total,
            'categorys' => $category

        ]);
    }
    


    #[Route('/panier/add/{id}', name: 'app_add')]
    public function add(Product $product, SessionInterface $session ,FlashyNotifier $flashyNotifier){
          
          $panier = $session->get('panier' , []);
          $id = $product->getId();
         if(!empty($panier[$id])){
           $panier[$id]++;

         }else{
            
            $panier[$id] = 1;
         }
          $session->set('panier', $panier);
          $flashyNotifier->success('C était bien ajouté, merci.');     

          return $this->redirectToRoute("app_panier");
    }
    
    #[Route('/panier/remove/{id}', name: 'app_remove')]
    public function remove($id , SessionInterface $session ,FlashyNotifier $flashyNotifier){
         
        $panier = $session->get('panier' , []);

        if(!empty($panier[$id])){
            
            unset($panier[$id]);
 
          }
          $session->set('panier', $panier); 
          $flashyNotifier->success('Votre produit a été effacé');     

          return $this->redirectToRoute("app_panier");
    }

    #[Route('/panier/delete/{id}', name: 'app_delete')]
    public function delete(Product $product, SessionInterface $session ,FlashyNotifier $flashyNotifier){
       
        $panier = $session->get('panier' , []);
        $id = $product->getId();
       if(isset($panier[$id])){
          if($panier[$id] > 1){
              $panier[$id]--;
          }else{

            unset($panier[$id]);
          }

       }
          $session->set('panier', $panier); 
          $flashyNotifier->success('Votre produit a été delete');    
       return $this->redirectToRoute("app_panier");
    }
}
