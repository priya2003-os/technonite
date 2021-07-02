<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtisteController extends AbstractController
{
    /**
     * @Route("/artistes", name="artiste")
     * @Route("/artistes/categorie/{id}", name="artiste_categoryById")
     */
    public function index(CategorieRepository $categorieRepository, ArtisteRepository $artisteRepository, $id = null): Response
    {
        // dd($id);
        
        
        $categories = $categorieRepository->findAll();
        // dd($categories);
        if($id === null){
            $artistes = $artisteRepository->findAll();
        }else{
            $artistes = $artisteRepository->findBy(['categori' => $id]);
            // $artistes = $artisteRepository->findArtistesForCategory($id);
            // dd($artistes);
        }
        // dd($artistes);
        $categoryColorName = [
            'Mélodique' => 'primary',
            'Industrielle' => 'secondary',
            'Groovy' => 'success',
            'Deep' => 'info',
            'Détroit' => 'warning',
        ];
        foreach($categories as $category){
            $category->color = $categoryColorName[$category->getName()];
           
        }
        
        // dd($categories);
        return $this->render('artiste/artiste.html.twig', [
            'categories' => $categories,
            'artistes' => $artistes,
        ]);
    }
    /**
     * @Route("/artistes/category/{id}", name="category", requirements={"id"="\d+"})
     */
    public function indexByCategory($id, CategorieRepository $categorieRepository, ArtisteRepository $artisteRepository): Response
    {
        // $id = $categorie->getId();
        $categories = $categorieRepository->findAll();
        $artistes = $artisteRepository->findArtistesForCategory($id);
        $categoryColorName = [
            'Mélodique' => 'primary',
            'Industrielle' => 'secondary',
            'Groovy' => 'success',
            'Deep' => 'info',
            'Détroit' => 'warning',
        ];
        foreach ($categories as $category) {
            $category->color = $categoryColorName[$category->getName()];
        }
        return $this->render('artiste/index.html.twig', [
            'artistes' => $artistes,
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/artiste/view/{id}", name="artiste_view", requirements={"id"="\d+"})
     */
    public function view(Artiste $artiste, ArtisteRepository $artisteRepository): Response
    {      
        $artisteId = $artiste->getId();
        $artiste = $artisteRepository->find($artisteId);

        return $this->render('artiste/view.html.twig', [
            'artiste' => $artiste,
        ]);
    }
}
