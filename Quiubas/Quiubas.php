<?php

namespace Quiubas;

class Quiubas
{
    /**
     * @param string Library Version
     */
    public static $lib_version = '1.0.3';

    // @var string The Quiubas API key to be used for requests.
    public static $api_key;

    // @var string The Quiubas API private to be used for requests.
    public static $api_private;

    // @var string The base URL for the Quiubas API.
    public static $base_url = 'https://rest.quiubas.com';

    // @var string The version of the Quiubas API to use for requests.
    public static $version = '1.0';

    // @var string Object Response
    public static $object_response = true;

    /**
     * @param string $api_key The API key
     * @param string $api_private The API private
     */
    public static function setAuth($api_key, $api_private)
    {
        self::$api_key = $api_key;
        self::$api_private = $api_private;
    }

    /**
     * @return array The API key and private used for requests.
     */
    public static function getAuth()
    {
        return array(
            'api_key' => self::$api_key,
            'api_private' => self::$api_private,
        );
    }

    /**
     * @return string The API version used for requests.
     */
    public static function getVersion()
    {
        return self::$version;
    }

    /**
     * @param string $version The API version to use for requests.
     */
    public static function setVersion($version)
    {
        self::$version = $version;
    }

    /**
     * @return string The API base URL.
     */
    public static function getBaseURL()
    {
        return self::$base_url;
    }

    /**
     * @param string $version The API base URL.
     */
    public static function setBaseURL($base_url)
    {
        self::$base_url = $base_url;
    }

    /**
     * @param string $version The API version to use for requests.
     */
    public static function format($path, $vars = array())
    {
        $parsed_vars = array();

        foreach ($vars as $k => $v) {
            $parsed_vars['{' . $k . '}'] = urlencode($v);
        }

        return strtr($path, $parsed_vars);
    }

    /**
     * @param boolean $status Set response as object
     */
    public static function setObjectResponse($status)
    {
        self::$object_response = $status;
    }

    /**
     * @return boolean Response status
     */
    public static function getObjectResponse()
    {
        return self::$object_response;
    }
}
