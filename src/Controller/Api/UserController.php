<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/users", methods={ "GET" })
     */
    public function listUsers() {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $users = $repository->findAll();

        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($users, 'json');

        return new Response($reports);
    }

    /**
     * @Route("/api/users", methods={ "POST" })
     */
    public function createUser(Request $request) {
        $user = new User();

        $manager = $this->getDoctrine()->getManager();
        // Get the data of request.
        $data = json_decode($request->getContent(), true);

        // Create form without csrf protection.
        $form = $this->createForm(UserType::class, $user, array("csrf_protection" => false));
        $form->handleRequest($request)
            ->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            // If the request is valide, save the new User.
            $manager->persist($user);
            $manager->flush();

            $serializer = $this->container->get('serializer');
            $reports = $serializer->serialize($user, 'json');

            // Return the created User.
            return new Response($reports);
        }

        // Else return an error.
        $response = new JsonResponse(array("message" => "Attribute(s) missing !"));
        $response->setStatusCode(400);
        return $response;
    }

    /**
     * @Route("/api/user/{userId}", methods={ "GET" }, requirements={"userId"="\d+"})
     */
    public function readUser($userId) {
        $repository = $this->getDoctrine()->getRepository(User::class);

        // Find the User with id $userId.
        $user = $repository->find($userId);

        // Parse Object to jsonString.
        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($user, 'json');

        return new Response($reports);
    }

    /**
     * @Route("/api/user/{userId}", methods={ "PUT" }, requirements={"userId"="\d+"})
     */
    public function updateUser($userId) {
        return "Not implemented yet.";
    }

    /**
     * @Route("/api/user/{userId}", methods={ "DELETE" }, requirements={"userId"="\d+"})
     */
    public function deleteUser($userId) {
        return "Not implemented yet.";
    }
}
