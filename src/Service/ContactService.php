<?php
namespace APP\Service\Contact;

use App\Entity\Contact;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;


class ContactSer
{
  private $manager;
  private $flash;

  public function __construct(EntityManagerInterface $manager , FlashBagInterface $flash)
  {
      $this->manager = $manager;
      $this->flash = $flash;
  }

  public function persistContact(Contact $contact): Void
  {
      $contact->setIsSend(false)
              ->setCreatedAt(new DateTime('now'));
      
      $this->manager->persist($contact);
      $this->manager->flush();
      $this->flash->add('Success', 'Votre message est bien envoyé, merci.')   ;     



  }





}