<?php

namespace AppBundle\Service;

interface ExportAsFormatInterface
{
    public function createExports(array $dataExport, string $path): array;
}
