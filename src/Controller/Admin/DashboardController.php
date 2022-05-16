<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Contact;
use App\Entity\Product;
use App\Entity\Slider;
use App\Entity\Transport;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ){
        
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
        ->setController(ProductCrudController::class)
        ->generateUrl();
           
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Storepfe');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Homme');
        yield MenuItem::linkToRoute('StorePFE', 'fa fa-undo' , 'app_store');

        
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Products');
        yield MenuItem::subMenu('Products' , 'fas fa-bars')->setSubItems([
              MenuItem::linkToCrud('Create product' , 'fas fa-plus' ,Product::class )->setAction(Crud::PAGE_NEW),
              MenuItem::linkToCrud('show product' , 'fas fa-eye' ,Product::class )

        ]);  
        yield MenuItem::section('Category');
        yield MenuItem::subMenu('Categories' , 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Category' , 'fas fa-plus' ,Category::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('show Category' , 'fas fa-eye' ,Category::class )

      ]);  

      yield MenuItem::section('Commend');
      yield MenuItem::linkToCrud('Adresse', 'class="fas fa-address-book', Address::class);

      if($this->isGranted(attribute: 'ROLE_SUPER_ADMIN')){ 
       yield MenuItem::section('Slider');
       yield MenuItem::linkToCrud('Slider', 'fa-solid fa-sliders', Slider::class);
      }
        
        if($this->isGranted(attribute: 'ROLE_SUPER_ADMIN')){ 
        yield MenuItem::section('User');
        yield MenuItem::linkToCrud('User', 'fa fa-user', User::class);
        }
        
        yield MenuItem::section('Comment');
        yield MenuItem::linkToCrud('Comment', 'fa fa-comment', Comment::class);
    
        if($this->isGranted(attribute: 'ROLE_SUPER_ADMIN')){ 
        yield MenuItem::section('Contact');
        yield MenuItem::linkToCrud('Contace', 'fas fa-sms', Contact::class);
    }
        yield MenuItem::section('Transport');
        yield MenuItem::linkToCrud('Transport', 'fa fa-truck', Transport::class);



       
    }

}
