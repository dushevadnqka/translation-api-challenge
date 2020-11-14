<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Language;
use AppBundle\Exception\NotSupportedFileFormatExportException;
use AppBundle\Service\DownloadZipService;
use AppBundle\Service\ExportAsJSONService;
use AppBundle\Service\ExportAsYAMLService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;

/**
 *
 * @Rest\Prefix("api/v1/language")
 * @Rest\NamePrefix("api_v1_language_")
 * @Rest\RouteResource("Language")
 *
 */
class LanguageController extends FOSRestController
{
    const ALLOWED_EXPORT_TYPES = array('json', 'yaml');
    
    /**
     * @return JsonResponse
     *
     * @Rest\Get("/list", name="list_languages")
     *
     * @SWG\Response(
     *     response=200,
     *     description="This method... should...",
     * )
     * @SWG\Tag(name="language")
     */
    public function listAction(): JsonResponse
    {
        $languages = $this->getDoctrine()
            -> getRepository(Language::class)
            -> findAllAsArray();

        return new JsonResponse(
            $languages,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @param string $format
     * @return JsonResponse
     *
     * @Rest\Get("/export-language-translations/{format}", name="export_languages_translations")
     *
     * @SWG\Response(
     *     response=200,
     *     description="This method... should...",
     * )
     * @SWG\Tag(name="language")
     *
     */
    public function exportAction(string $format): BinaryFileResponse
    {
        if (!in_array($format, static::ALLOWED_EXPORT_TYPES)) {
            throw new NotSupportedFileFormatExportException("The requested format $format for export is not supported.");
        }

        $translations = $this->getDoctrine()
            ->getRepository(Language::class)
            ->findAllAsArray();

        if ($format === 'json') {
            $exportService = new ExportAsJSONService();
        } else {
            $exportService = new ExportAsYAMLService();
        }

        $exportsPath = $this->get('kernel')->getRootDir() . '/../web/exports';

        $zipService = new DownloadZipService($exportService, $exportsPath);
        $zipName = $zipService->createZip($translations);

        // @unlink($zipName); //in terms to want to remove file after download...

        return new BinaryFileResponse($zipName);
    }
}
