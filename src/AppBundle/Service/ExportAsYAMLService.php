<?php

namespace AppBundle\Service;

use Symfony\Component\Yaml\Yaml;

class ExportAsYAMLService implements ExportAsFormatInterface
{
    public function createExports(array $dataExport, string $path): array
    {
        $today = date("Y-m-d h:i:sa");
        $fileName = "$path/export-$today-.yaml";
        $yaml = Yaml::dump($dataExport);

        file_put_contents($fileName, $yaml);

        return array($fileName);
    }
}
