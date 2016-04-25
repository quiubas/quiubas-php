<?php

namespace Quiubas;

class Network
{
    /**
     * @param string $path API Path
     * @param string $params Parameters
     */
    public static function get($path, $params = false)
    {
        return self::request($path, $params, 'GET');
    }
    public static function post($path, $params = false)
    {
        return self::request($path, $params, 'POST');
    }
    public static function delete($path, $params = false)
    {
        return self::request($path, $params, 'DELETE');
    }
    public static function put($path, $params = false)
    {
        return self::request($path, $params, 'PUT');
    }

    /**
     * @param array Message parameters
     */
    public static function request($path, $params = false, $method = 'GET', $curl_options = array())
    {
        if (gettype($path) === 'array') {
            $path = Quiubas::format(array_shift($path), array_pop($path));
        }

        $ch = curl_init();

        $url = self::formatBaseURL($path);

        if (substr_count($url, '/') === 2) {
            $url .= '/';
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($params !== false) {
            if ($method !== 'GET') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            } else {
                $url_len = (mb_strlen($url) - 1);
                if ($url[$url_len] !== '?') {
                    $url .= '?';
                }
                $url .= http_build_query($params, '', '&');
            }
        }

        $curl = curl_version();
        $ssl_version = isset($curl['ssl_version']) ? $curl['ssl_version'] : '';

        if (substr_compare($ssl_version, 'NSS/', 0, strlen('NSS/')) !== 0) {
            $cipher_list = array(
                'TLSv1'
            );
            curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
        }

        $auth = Quiubas::getAuth();
        curl_setopt($ch, CURLOPT_USERPWD, $auth['api_key'] . ':' . $auth['api_private']);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1) ;
        curl_setopt($ch, CURLOPT_USERAGENT, 'Quiubas-PHP/' . Quiubas::$lib_version);

        curl_setopt_array($ch, $curl_options);

        $data = curl_exec($ch);

        if (curl_errno($ch) !== 0) {
            throw new Exception(sprintf('There was an error trying communicating with Quiubas Server: #%d %s', curl_errno($ch), curl_error($ch)));
        }

        if (is_resource($ch) === true) {
            curl_close($ch);
        }

        $response = json_decode($data, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $error_msg = false;

            if (isset($response['error']) === true && $response['error'] !== false) {
                if (isset($response['errors']) === true) {
                    $error_msg = array();

                    foreach ($response['errors'] as $v) {
                        $error_msg[] = $v['message'];
                    }

                    $error_msg = implode("\r\n", $error_msg);
                } else {
                    $error_msg = $response['error'];
                }
            }

            unset($response['action'], $response['error'], $response['__debug']);

            if (isset($response['items']) === true) {
                $response = $response['items'];

                if (Quiubas::getObjectResponse() === true) {
                    foreach ($response as $k => $v) {
                        $response[$k] = (object) $v;
                    }
                }
            }

            if ($error_msg !== false) {
                throw new Exception($error_msg);
            } else {
                if (Quiubas::getObjectResponse() === true) {
                    return (object) $response;
                } else {
                    return $response;
                }
            }
        } else {
            throw new Exception(sprintf('There was an error parsing the response: #%d %s', json_last_error(), json_last_error_msg()));
        }
    }

    /**
     * @return string Base URL
     */
    public static function getBaseURL()
    {
        return (Quiubas::getBaseURL() . '/' .    Quiubas::$version . '/');
    }

    /**
     * @param string $path Formated base URL
     *
     * @return string Formated base URL
     */
    public static function formatBaseURL($path)
    {
        return self::getBaseURL() . $path;
    }
}
