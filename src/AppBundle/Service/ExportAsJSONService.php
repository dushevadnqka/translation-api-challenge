<?php

namespace AppBundle\Service;

class ExportAsJSONService implements ExportAsFormatInterface
{
    public function createExports(array $dataExportItems, string $path): array
    {
        $files = array();
        $today = date("Y-m-d h:i:sa");

        foreach ($dataExportItems as $item) {
            $languageIso = $item['isoCode'];

            $fileName = "$path/export-$today-$languageIso-lang.json";

            file_put_contents($fileName, json_encode($item));

            array_push($files, $fileName);
        }

        return $files;
    }
}
