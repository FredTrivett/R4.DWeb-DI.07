<?php

namespace App\Controller;

/* indique l'utilisation du bon bundle pour gérer nos routes */
use stdClass;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Lego;

class LegoController extends AbstractController
{
   private $legos;

   public function __construct()
   {
        $data = file_get_contents(__DIR__ . '/../data.json');
        $legoData = json_decode($data, true);
 
        $this->legos = [];
        foreach ($legoData as $legoItem) {
          $lego = new Lego($legoItem['collection'], $legoItem['id'], $legoItem['name']); // Create a new Lego object
          $lego->setDescription($legoItem['description']);
          $lego->setPrice($legoItem['price']);
          $lego->setPieces($legoItem['pieces']);
          $lego->setBoxImage($legoItem['images']['box']);
          $lego->setLegoImage($legoItem['images']['bg']);
          $this->legos[] = $lego;
        }
   }

   #[Route('/' )]
     public function home(): Response
     {
          return $this->render('lego.html.twig', [
          'legos' => $this->legos,
          ]);
     } 
}