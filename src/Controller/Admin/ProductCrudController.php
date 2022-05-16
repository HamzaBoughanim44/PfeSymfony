<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use phpDocumentor\Reflection\Types\Self_;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public const PRODUCTS_BASE_PATH = 'images/';
    public const PRODUCTS_UPLOAD_DIR = 'public/images/';
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nomep','Nome Produit'),
            DateTimeField::new('datapro'),
            MoneyField::new('price')->setCurrency('MAD'),
            AssociationField::new('category'),
            IntegerField::new('quantity'),
            TextEditorField::new('description'),
            ImageField::new('image')
                  ->setBasePath(Self::PRODUCTS_BASE_PATH)
                  ->setUploadDir(self::PRODUCTS_UPLOAD_DIR),
               
            BooleanField::new('status'),
        ];
    }

     public function configureCrud(Crud $crud): Crud
      {
          return $crud
            ->setDefaultSort(['datapro' =>'DESC']);
       }
    
}
