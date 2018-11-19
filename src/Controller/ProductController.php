<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Restaurant;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 *
 * @Route("/restaurant/{restaurant}/product", name="product_", requirements={"restaurant"="\d+"})
 */
class ProductController extends AbstractController
{
    /**
     * @Route("", methods={"GET"}, name="index")
     *
     * @param ProductRepository $productRepository
     * @param Restaurant $restaurant
     * @param Request $request
     *
     * @return Response
     */
    public function index(ProductRepository $productRepository, Restaurant $restaurant, Request $request)
    {
        $paginator = $productRepository->paginateByRestaurant(
            $restaurant,
            $request->query->get('page', 1),
            $request->query->get('size', 20)
        );

        return $this->json($paginator, 200, [], ['groups' => ['product.list']]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="show")
     *
     * @param ProductRepository $productRepository
     * @param Restaurant $restaurant
     * @param $id
     *
     * @return Response
     */
    public function show(ProductRepository $productRepository, Restaurant $restaurant, $id)
    {
        $product = $productRepository->findOneBy(['restaurant' => $restaurant, 'id' => $id]);

        if (!$product) {
            throw new NotFoundHttpException();
        }

        return $this->json($product, 200, [], ['groups' => ['product.detail', 'restaurant.list']]);
    }

    /**
     * @Route("", methods={"POST"}, name="create")
     *
     * @param Request $request
     * @param Restaurant $restaurant
     * @param ProductRepository $productRepository
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request, Restaurant $restaurant, ProductRepository $productRepository)
    {
        $product = new Product();
        $product->setRestaurant($restaurant);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product);

            return $this->json($product, 200, [], ['groups' => ['product.detail', 'restaurant.list']]);
        }

        return $this->json($this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", methods={"PUT"}, name="update", requirements={"id"="\d+"})
     *
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param Restaurant $restaurant
     *
     * @return Response
     */
    public function update(Request $request, ProductRepository $productRepository, Restaurant $restaurant, $id)
    {
        $product = $productRepository->findOneBy(['restaurant' => $restaurant, 'id' => $id]);

        if (!$product) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(ProductType::class, $product, [
            'method' => 'PUT'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product);

            return $this->json($product, 200, [], ['groups' => ['product.detail', 'restaurant.list']]);
        }

        return $this->json($this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete")
     *
     * @param Restaurant $restaurant
     * @param ProductRepository $productRepository
     * @param $id
     *
     * @return Response
     */
    public function delete(Restaurant $restaurant, ProductRepository $productRepository, $id)
    {
        $product = $productRepository->findOneBy(['restaurant' => $restaurant, 'id' => $id]);

        if (!$product) {
            throw new NotFoundHttpException();
        }

        $productRepository->delete($product);

        return new Response(null,Response::HTTP_NO_CONTENT);
    }
}
