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

class CategoryController extends AbstractController
{
    #[Route('/category/{slug}', name: 'app_category')]
    public function index(?Category $category, ProductRepository $productRepository , 
    PaginatorInterface $paginator, Request $request ,CategoryRepository $categoryRepository  ): Response
    {
       

        $products = $paginator->paginate($productRepository->findAll(),
        $request->query->getInt('page',1),
        4
    );

    if(!$category){

        return $this->redirectToRoute('app_store');
    }
        return $this->render('category/category.html.twig', [
            'categorys' => $category,
            'products' => $products,
        ]);
    }
}
