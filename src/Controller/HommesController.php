<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HommesController extends AbstractController
{
    #[Route('/hommes', name: 'app_hommes')]
    public function index(
        ProductRepository $productRepository , 
        PaginatorInterface $paginator ,
        Request $request ,
        ?Category $category,
        CategoryRepository $categoryRepository,): Response {
        $category = $categoryRepository->findAll();
    
        $products = $paginator->paginate($productRepository->findAll(),
        $request->query->getInt('page',1),
        5
    
    );
        
    
        return $this->render('hommes/hommes.html.twig', [
            'products' => $products,
            'categorys' => $category,

        ]);
    }
}
