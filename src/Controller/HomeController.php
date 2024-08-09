<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_')]
class HomeController extends AbstractController
{

    #[Route('', name: 'home', methods: ['GET'])]
    public function index(ProductRepository $productRepository, Request $request): Response
    {

        $pagination = $productRepository->paginateProduct($request->query->getInt('page', 1));
        return $this->render('front/home/index.html.twig', [
            'products' => $pagination
        ]);
    }
    #[Route('details/{slug}', name: 'show', methods: ['GET'])]
    public function show(ProductRepository $repository, $slug)
    {
        $product = $repository->findOneWithCategory($slug);

        return $this->render('front/home/show.html.twig', ['product' => $product]);
    }
}
