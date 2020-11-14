<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\TranslationKey;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use AppBundle\Exception\RequestMissingParamException;

/**
 *
 * Only one route is available for non-admin - list keys
 *
 * @Rest\Prefix("api/v1/translation-key")
 * @Rest\NamePrefix("api_v1_translation_key_")
 * @Rest\RouteResource("TranslationKey")
 *
 */
class TranslationKeyController extends FOSRestController
{
    const CREATE_KEY_SUCCESS_MESSAGE = "The Key was created Successfully!";
    const EDIT_KEY_SUCCESS_MESSAGE = "The Key was edited Successfully!";
    const DELETE_KEY_SUCCESS_MESSAGE = "The Key was deleted Successfully!";

    /**
     *
     * @return JsonResponse
     *
     * @Rest\Get("/list", name="list_translation_keys")
     *
     * @SWG\Response(
     *     response=200,
     *     description="This method... should...",
     * )
     *
     * @SWG\Tag(name="translation-key")
     */
    public function listAction(): JsonResponse
    {
        $translationKeys = $this->getDoctrine()
            ->getRepository(TranslationKey::class)
            ->findAllAsArray();

        return new JsonResponse(
            $translationKeys,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @Rest\Post("/create", name="create_translation_key")
     *
     * @SWG\Response(
     *     response=201,
     *     description="This method... should...",
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Validation errors, missing fields.",
     *
     * )
     *
     * @SWG\Tag(name="translation-key")
     */
    public function createAction(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('name', $data) || empty($data['name'])) {
            throw new RequestMissingParamException('The name field is required', JsonResponse::HTTP_BAD_REQUEST);
        }

        $service = $this->get('app.create_translation_service');
        $service->createKey($data['name']);

        return new JsonResponse(
            static::CREATE_KEY_SUCCESS_MESSAGE,
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @param TranslationKey $translationKey
     * @param Request $request
     * @return JsonResponse
     *
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @Rest\Put("/rename/{id}", name="rename_translation_key")
     *
     * @SWG\Response(
     *     response=200,
     *     description="This method... should...",
     * )
     *
     * @SWG\Response(
     *     response=404,
     *     description="Not found.",
     *
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Validation errors, missing fields.",
     *
     * )
     *
     * @SWG\Tag(name="translation-key")
     */
    public function renameAction(Request $request, TranslationKey $translationKey): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('name', $data) || empty($data['name'])) {
            throw new \Exception('The name field is required', JsonResponse::HTTP_BAD_REQUEST);
        }

        $translationKey->setName($data['name']);

        $this->getDoctrine()
            ->getRepository(TranslationKey::class)
            ->saveEntity($translationKey);

        return new JsonResponse(
            static::EDIT_KEY_SUCCESS_MESSAGE,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @param TranslationKey $translationKey
     * @return JsonResponse
     *
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @Rest\Delete("/delete/{id}", name="delete_translation_key")
     *
     * @SWG\Response(
     *     response=200,
     *     description="This method... should...",
     * )
     *
     * @SWG\Tag(name="translation-key")
     */
    public function deleteAction(TranslationKey $translationKey): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($translationKey);

        $em->flush();

        return new JsonResponse(
            static::DELETE_KEY_SUCCESS_MESSAGE,
            JsonResponse::HTTP_OK
        );
    }
}
