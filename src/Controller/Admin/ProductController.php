<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/product', name: 'admin_product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ProductRepository $repository, Request $request): Response
    {
        $pagination = $repository->paginateProduct($request->query->getInt('page', 1));

        return $this->render('admin/product/index.html.twig', [
            'products' => $pagination
        ]);
    }


    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'nouvel produit ajouté');
            return $this->redirectToRoute('app_admin_product_index');
        }
        return $this->render('admin/product/create.html.twig', [
            'productForm' => $form
        ]);
    }
    #[Route('/show/{slug}', name: 'show', methods: ['GET'])]
    public function show(Product $product, ProductRepository $repository, Request $request): Response
    {
        return $this->render('admin/product/show.html.twig', [
            'product' => $product
        ]);
    }
    #[Route('/show/{slug}/update', name: 'update', methods: ['GET', 'POST'])]
    public function update(Product $product, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            $this->addFlash('success', 'nouveau produit modifier');
            return $this->redirectToRoute('admin_product_index');
        }
        return $this->render('admin/product/update.html.twig', [
            'productFormUpdate' => $form
        ]);
    }
    #[Route('/show/{slug}/delete', name: 'delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em ,Product $product)
    {
        $em->remove($product);
        $em->flush();

        $this->addFlash('danger','Vous venez de supprimer un produit');
        return $this->redirectToRoute('admin_product_index');
    }
}
