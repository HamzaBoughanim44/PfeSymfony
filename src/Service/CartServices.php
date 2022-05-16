<?php
namespace App\Service;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartServices{
    private $productrepo;
    private $session;
    private $tva=0.2;
    public function __construct(SessionInterface $session , ProductRepository $productrepo)
    {
        $this->session =$session;
        $this->productrepo = $productrepo;
    }

   
    public function add(Product $product, SessionInterface $session ,FlashyNotifier $flashyNotifier){
          
        $panier = $this->getPanier();
        $id = $product->getId();
       if(isset($panier[$id])){
         $panier[$id]++;
       }else{
          $panier[$id] = 1;
       }
        $this->updatePanier($panier);
        $flashyNotifier->success('C était bien ajouté, merci.');        
  }
  


    public function delete($id, Product $product, SessionInterface $session ,FlashyNotifier $flashyNotifier){
        $panier =$this->getPanier();
        $id = $product->getId();
       if(isset($panier[$id])){
          if($panier[$id] > 1){
              $panier[$id]--;
          }else{
            unset($panier[$id]);
          }
       }
          $this->updatePanier($panier); 
          $flashyNotifier->success('Votre produit a été delete');    
       
    }


    public function remove($id , SessionInterface $session ,FlashyNotifier $flashyNotifier){   
        $panier =$this->getPanier();
        if(isset($panier[$id])){     
            unset($panier[$id]);
          }
          $this->updatePanier($panier);
          $flashyNotifier->success('Votre produit a été effacé');         
    }


    public function getPanier (){
        return $this->session->get('panier' , []);
    }


    public function updatePanier($panier){
        $this->session->set('panier',$panier);
        $this->session->set('panierData',$this->getPanier());

    }
    public function deletPanier(){
       $this->updatePanier([]);
    }


    public function Panier(SessionInterface $session ,
    ProductRepository $productRepository,
     ?Category $category ,
      Product $product,
      CategoryRepository $categoryRepository,
      FlashyNotifier $flashyNotifier)
   {
       $panier =$this->getPanier();
       $fullpanier= [];
       $quantityPanier =0;
       $subTotal = 0;
       foreach($panier as $id => $quantity){
          $product = $this-> $productRepository->find($id);
          if($product){
           $fullpanier[] = [
               'product' =>  $product,
               'quantity' => $quantity

           ];
           $quantityPanier +=$quantity;
           $subTotal +=$quantity*$product->getPrice()/100;
        }else{
            $this->deletPanier($id);
        }


       }
       $fullpanier['data']= [
         "quantityPanier" =>$quantityPanier,
         "subTotalHT" => $subTotal,
         "taxe"=>round($subTotal*$this->tva,2),
         "subTotalTTC" =>round(($subTotal + ($subTotal*$this->tva))),
       ]; 
       return $fullpanier;

       
   }

    




}
