<?php

namespace SenRouter\Http;

use SimpleXMLElement;

class Response
{

    /**
     * @param $code
     */
    public static function withStatus($code)
    {
        http_response_code($code);
    }

    /**
     * @param $data
     * @return string
     */
    public static function withJson($data)
    {
        Response::withHeader('Content-Type', 'application/json');

        return json_encode($data, JSON_PRETTY_PRINT
            | JSON_HEX_QUOT | JSON_HEX_APOS);
    }

    /**
     * @param $name
     * @param $value
     */
    public static function withHeader($name, $value)
    {
        header("$name: $value");
    }

    /**
     * @param $data
     * @return string
     */
    public static function withXml($data)
    {
        Response::withHeader('Content-Type', 'application/xml');

        $xml = new SimpleXMLElement('<root/>');
        $fliped = array_flip($data);
        array_walk_recursive($fliped, array($xml, 'addChild'));
        return $xml->asXML();
    }

    /**
     * @param $value
     */
    public static function end($value)
    {
        die($value);
    }
}