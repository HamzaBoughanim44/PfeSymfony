<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\SliderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{
    #[Route('/', name: 'app_store')]
    public function index(?Category $category,
    CategoryRepository $categoryRepository,
     ProductRepository $productRepository,
     PaginatorInterface $paginator ,
     Request $request ,
     SliderRepository $sliderRepository ): Response
    {

        $category = $categoryRepository->findAll();
        $product = $productRepository->findByStatus(1);
        $silder = $sliderRepository->findAll();

        $product = $paginator->paginate($productRepository->findAll(),
        $request->query->getInt('page',1),
        16
    
    );
        return $this->render('store/index.html.twig', [
            'categorys' => $category,
            'products' => $product,
            'sliders' => $silder,
        ]);
    }

   
}
