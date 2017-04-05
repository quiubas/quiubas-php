<?php

namespace Quiubas;

class Base
{
    /**
     * @param array $params Parameters
     */
    public static function action($params)
    {
        return Network::post(static::$base, $params);
    }

    /**
     * @param string $id ID
     */
    public static function get($id = false, $params = array())
    {
        if (gettype($id) === 'array') {
            $params = $id;
            $id = false;
        }

        return Network::get(array(static::$action, array( 'id' => $id ) ), $params);
    }

    /**
     * @param string $id ID
     * @param array $params Parameters
     */
    public static function delete($id = false, $params = array())
    {
        if (gettype($id) === 'array') {
            $params = $id;
            $id = false;
        }

        return Network::delete(
            array(static::$action, array('id' => $id)),
            $params
        );
    }

    /**
     * @param string $id ID
     * @param array $params Parameters
     */
    public static function update($id = false, $params = array())
    {
        if (gettype($id) === 'array') {
            $params = $id;
            $id = false;
        }

        return Network::put(
            array(static::$action, array('id' => $id)),
            $params
        );
    }

    /**
     * @param array $params Parameters
     */
    public static function getAll($params = array())
    {
        return Network::get(static::$base, $params);
    }
}
