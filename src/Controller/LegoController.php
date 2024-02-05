<?php

namespace App\Controller;

/* indique l'utilisation du bon bundle pour gérer nos routes */
use stdClass;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Lego;
use App\Service\CreditsGenerator;

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

    // #[Route('/creator')]
    // public function creator(): Response
    // {
    //     // only shoe the templates where $legoItem['collection'] == 'Creator'
    //     $creator = array_filter($this->legos, function($legoItem) {
    //         return $legoItem->getCollection() == 'Creator';
    //     });
    //     return $this->render('lego.html.twig', [
    //         'legos' => $creator,
    //     ]);
    // }

    // #[Route('/star_wars')]
    // public function star_wars(): Response
    // {
    //     // only shoe the templates where $legoItem['collection'] == 'star_wars'
    //     $star_wars = array_filter($this->legos, function($legoItem) {
    //         return $legoItem->getCollection() == 'Star Wars';
    //     });
    //     return $this->render('lego.html.twig', [
    //         'legos' => $star_wars,
    //     ]);
    // }

    // #[Route('/creator_expert')]
    // public function creator_expert(): Response
    // {
    //     // only shoe the templates where $legoItem['collection'] == 'creator_expert'
    //     $creator_expert = array_filter($this->legos, function($legoItem) {
    //         return $legoItem->getCollection() == 'Creator Expert';
    //     });
    //     return $this->render('lego.html.twig', [
    //         'legos' => $creator_expert,
    //     ]);
    // }

    #[Route('/{collection}', 'filter_by_collection', requirements: ['collection' => 'creator|star_wars|creator_expert'])]
    public function filter($collection): Response
    {
        $filter = array_filter($this->legos, function($legoItem) use ($collection) {
            $collection = ucwords(str_replace('_', ' ', $collection));
            return $legoItem->getCollection() == $collection;
        });
        return $this->render('lego.html.twig', [
            'legos' => $filter,
        ]);
    }

    #[Route('/credits', 'credits')]
    public function credits(CreditsGenerator $credits): Response
    {
        return new Response($credits->getCredits());
    }

}