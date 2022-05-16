<?php
namespace App\Service;

use App\Entity\Product;
use App\Entity\Comment;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CommentService{

    private $manager;
    private $flash;
  
    public function __construct(EntityManagerInterface $manager , FlashBagInterface $flash)
    {
        $this->manager = $manager;
        $this->flash = $flash;
    }
    public function persistComment(Comment $comment ,Product $product = null): Void
    {
        $comment->setIsPublished(false)
                ->setProduct($product)
                ->setDatecomment(new DateTime('now'));
        
        $this->manager->persist($comment);
        $this->manager->flush();
        $this->flash->add('Success','Votre Comment est bien envoyé, merci.')   ;     
  
    }
}
