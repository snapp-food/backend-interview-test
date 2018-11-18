<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RestaurantController
 *
 * @Route("/restaurant", name="restaurant_")
 */
class RestaurantController extends AbstractController
{
    /**
     * @Route("", methods={"GET"}, name="index")
     *
     * @param RestaurantRepository $repository
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(RestaurantRepository $repository, Request $request)
    {
        $paginator = $repository->paginate($request->query->get('page', 1), $request->query->get('size', 20));

        return $this->json($paginator);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="show")
     * @param Restaurant $restaurant
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(Restaurant $restaurant)
    {
        return $this->json($restaurant);
    }

    /**
     * @Route("", methods={"POST"}, name="create")
     * @param Request $request
     * @param RestaurantRepository $restaurantRepository
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request, RestaurantRepository $restaurantRepository)
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurantRepository->save($restaurant);

            return $this->json($restaurant);
        }

        return $this->json($this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", methods={"PUT"}, name="update")
     *
     * @param Restaurant $restaurant
     * @param RestaurantRepository $restaurantRepository
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(Restaurant $restaurant, RestaurantRepository $restaurantRepository, Request $request)
    {
        $form = $this->createForm(RestaurantType::class, $restaurant, [
            'method' => 'PUT'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurantRepository->save($restaurant);

            return $this->json($restaurant);
        }

        return $this->json($this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete")
     *
     * @param Restaurant $restaurant
     * @param RestaurantRepository $restaurantRepository
     *
     * @return Response
     */
    public function delete(Restaurant $restaurant, RestaurantRepository $restaurantRepository)
    {
        $restaurantRepository->remove($restaurant);

        return new Response(null,Response::HTTP_NO_CONTENT);
    }
}
