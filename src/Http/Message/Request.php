<?php

namespace SenRouter\Http;

class Request
{

    /**
     * @return bool
     */
    public static function isGetMethod()
    {
        return self::getRequestMethod() === 'get';
    }

    /**
     * @return string
     */
    public static function getRequestMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     */
    public static function isPostMethod()
    {
        return self::getRequestMethod() === 'post';
    }

    /**
     * @return array
     */
    public static function getAllHttpMethod()
    {
        return [
            'get',
            'post',
            'put',
            'patch',
            'delete',
            'update'
        ];
    }

    /**
     * @return mixed
     */
    public static function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     *
     */
    public function __contruct()
    {

    }

}