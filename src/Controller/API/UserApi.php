<?php
// api/src/Controller/CreateBookPublication.php

namespace App\Controller\API;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserApi extends AbstractController
{

    public function __construct()
    {
    }

    /**
     * @Route(
     *     name="get_user",
     *     path="/users/{id}/user",
     *     methods={"GET","OPTIONS"},
     *     defaults={
     *          "_api_resource_class"=User::class,
     *          "_api_collection_operation_name"="get"
     *     }
     * )
     * @param Task $data
     * @return JsonResponse
     */
    public function __invoke(User $data)
    {
        
        if ( $data != $this->getUser() && !$this->getUser()->hasRole('ROLE_ADMIN') ) {
            return new JsonResponse(json_encode(['messages' => "l'utilisateur n'est pas permis d'avoir cette information n'existe pas"]), 404);
        }
        
        // $this->bookPublishingHandler->handle($data);

        return $data;
    }
}