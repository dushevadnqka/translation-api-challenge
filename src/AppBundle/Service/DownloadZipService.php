<?php

namespace AppBundle\Service;

use AppBundle\Service\ExportAsFormatInterface;
use ZipArchive;

class DownloadZipService
{
    private $exportAsFormatService;
    private $exportsPath;

    public function __construct(ExportAsFormatInterface $exportAsFormatService, string $exportsPath)
    {
        $this->exportAsFormatService = $exportAsFormatService;
        $this->exportsPath = $exportsPath;
    }
    
    public function createZip(array $data): string
    {
        $documents = $this->exportAsFormatService->createExports($data, $this->exportsPath);
        $files = array();

        foreach ($documents as $document) {
            array_push($files, $document);
        }

        // Create new Zip Archive.
        $zip = new ZipArchive();

        // The name of the Zip documents.
        $today = date("Y-m-d h:i:sa");
        $zipName = "$this->exportsPath/zip-export-$today-.zip";

        $zip->open($zipName, ZipArchive::CREATE);

        foreach ($files as $file) {
            $zip->addFromString(basename($file), file_get_contents($file));
        }

        $zip->close();

        return $zipName;
    }
}
