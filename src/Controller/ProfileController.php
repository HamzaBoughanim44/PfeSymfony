<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index( CategoryRepository $categoryRepository): Response
    {
        



        $category = $categoryRepository->findAll();
        return $this->render('profile/profile.html.twig', [
            'user' => $this->getUser(),
            'categorys'=> $category,
        ]);
    }
}
