<?php

namespace GenderApi\Client\Downloader;

/**
 * Class FileGetContents
 * @package GenderApi\Client\Downloader
 */
class FileGetContents extends AbstractDownloader
{

    /**
     * @param string $url
     * @return bool|string
     * @throws NetworkErrorException
     */
    public function download($url)
    {
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => array(
                    'User-Agent: gender-api-client/1.0',
                    'Content-Type: application/json'
                ),
                'timeout' => 5
            ));
        $context = stream_context_create($options);

        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            $lastError = error_get_last();
            if (is_array($lastError) && isset($lastError['message'])) {
                throw new NetworkErrorException($lastError['message']);
            }
        }

        return $response;
    }
}