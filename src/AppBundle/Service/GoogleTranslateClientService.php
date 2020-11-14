<?php

namespace AppBundle\Service;

use Google\Cloud\Translate\TranslateClient;
use AppBundle\Exception\GoogleTranslateServiceException;

class GoogleTranslateClientService
{
    public function translate(string $language, string $translationKey)
    {
        $translate = new TranslateClient();

        try {
            $result = $translate->translate($translationKey, [
                'target' => $language,
            ]);

            return $result['text'];
        } catch (\Exception $e) {
            throw new GoogleTranslateServiceException('Something with the Google Translation Service is not OK.');
        }
    }
}
