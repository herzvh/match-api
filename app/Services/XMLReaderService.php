<?php


namespace App\Services;


class XMLReaderService
{
    public function readToArray($fileName) {
        $xmlString = file_get_contents(public_path($fileName));
        $xmlObject = simplexml_load_string($xmlString);

        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true);

        return $phpArray;
    }

}
