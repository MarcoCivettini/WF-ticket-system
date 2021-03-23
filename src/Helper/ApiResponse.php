<?php
namespace App\Helper;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiResponse extends Response
{
    public function __construct($item, int $statusCode, $header = ['Content-Type' => 'application/json'])
    {
        $this->content = $this->serializeObjectToJson($item);
        $this->status = $statusCode;
        $this->$header = $header;

    }

    private function serializeObjectToJson($item): string
    {
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        // Serialize your object in Json
        $jsonObject = $serializer->serialize($item, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return $jsonObject;
    }
}
