<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Exception\RequestMissingParamException;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Translation;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Rest\Prefix("api/v1/translation")
 * @Rest\NamePrefix("api_v1_translation_")
 * @Rest\RouteResource("Translation")
 *
 */
class TranslationController extends FOSRestController
{
    const UPDATE_SUCCESS_MESSAGE_MANUAL = "The value of the translation was updated (manually)!";
    const UPDATE_SUCCESS_MESSAGE_MACHINE = "The value of the translation was updated (with machine)!";

    /**
     *
     * @return JsonResponse
     *
     * @Rest\Get("/list", name="list_translations")
     *
     * @SWG\Response(
     *     response=200,
     *     description="This method... should...",
     * )
     * @SWG\Tag(name="translation")
     *
     */
    public function listAction(): JsonResponse
    {
        $translations = $this->getDoctrine()
            ->getRepository(Translation::class)
            ->findAllAsArray();

        return new JsonResponse(
            $translations,
            JsonResponse::HTTP_OK
        );
    }

     /**
     * @param Translation $translation
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Put("/update-manual/{id}", name="update_translation_manual")
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
     * @SWG\Tag(name="translation")
     */
    public function updateAction(Request $request, Translation $translation): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('value', $data) || empty($data['value'])) {
            throw new RequestMissingParamException('The value field is required', JsonResponse::HTTP_BAD_REQUEST);
        }

        $translation->setValue($data['value']);

        $this->getDoctrine()
            ->getRepository(Translation::class)
            ->saveEntity($translation);

        return new JsonResponse(
            static::UPDATE_SUCCESS_MESSAGE_MANUAL,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @param Translation $translation
     * @return JsonResponse
     *
     * @Rest\Put("/update-machine/{id}", name="update_translation_machine")
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
     * @SWG\Tag(name="translation")
     */
    public function machineUpdateAction(Translation $translation): JsonResponse
    {
        $language = $translation->getLanguage()->getIsoCode();
        $translationKey = $translation->getTranslationKey()->getName();

        $service = $this->get('app.google_translate_client_service');
        $translationResult = $service->translate($language, $translationKey);

        $translation->setValue($translationResult);

        $this->getDoctrine()
            ->getRepository(Translation::class)
            ->saveEntity($translation);

        return new JsonResponse(
            static::UPDATE_SUCCESS_MESSAGE_MACHINE,
            JsonResponse::HTTP_OK
        );
    }
}
