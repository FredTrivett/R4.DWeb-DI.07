<?php

namespace App\Controller;

/* indique l'utilisation du bon bundle pour gérer nos routes */
use stdClass;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Lego;
use App\Repository\LegoRepository;
use App\Service\CreditsGenerator;
use Doctrine\ORM\EntityManagerInterface;

class LegoController extends AbstractController
{
   private $legos;
        
   public function __construct(LegoRepository $legoRepository)
   {
       $this->legos = $legoRepository;
   }

   #[Route('/' )]
     public function home(): Response
     {  
        $legos = $this->legos->findAll();
        return $this->render('lego.html.twig', [
            'legos' => $legos,
        ]);

        
     } 
     #[Route('/{collection}', name: 'filter_by_collection', requirements: ['collection' => 'creator|star_wars|creator_expert'])]
     public function filter(string $collection): Response
     {
         $legos = $this->legos->findAll(); // Récupère tous les objets Lego
         $collectionFormatted = ucwords(str_replace('_', ' ', $collection)); // Formate le nom de la collection
     
         // Filtre les objets Lego par collection
         $filteredLegos = array_filter($legos, function ($lego) use ($collectionFormatted) {
             return $lego->getCollection() === $collectionFormatted;
         });
     
         return $this->render('lego.html.twig', [
             'legos' => $filteredLegos,
         ]);
     }
     

    #[Route('/credits', 'credits')]
    public function credits(CreditsGenerator $credits): Response
    {
        return new Response($credits->getCredits());
    }
}


     //  #[Route('/test')]
    // public function test(EntityManagerInterface $entityManager): Response
    // {

    //     $l = new Lego(1234);
    //     $l->setName("un beau Lego");
    //     $l->setCollection("Lego espace");
    //     $l->setDescription("Un superbe Lego de l'espace");
    //     $l->setPrice(99.99);
    //     $l->setPieces(1000);
    //     $l->setBoxImage("https://www.lego.com/cdn/cs/set/assets/blt3e3f3d2d3d3d3d3d/LEGO-STAR-WARS-AT-AT-75313-BOX-01-SQ.png?fit=bounds&format=webply&quality=80&width=1600&height=1600&dpr=1");
    //     $l->setLegoImage("https://www.lego.com/cdn/cs/set/assets/blt3e3f3d2d3d3d3d3d/LEGO-STAR-WARS-AT-AT-75313-BOX-01-SQ.png?fit=bounds&format=webply&quality=80&width=1600&height=1600&dpr=1");

    //     $entityManager->persist($l);
    //     $entityManager->flush();

    //     return new Response('Saved new product with id '.$l->getId());
    // }

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