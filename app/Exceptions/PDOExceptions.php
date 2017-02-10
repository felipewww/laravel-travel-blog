<?php

namespace App\Exceptions;

use Doctrine\DBAL\Query\QueryException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Redirect;

class PDOExceptions {
    public static $exception;

    public static function render($e)
    {
        self::$exception    = $e;
        $view               = 'errors.PDOCustomExceptions';
        $code               =  $e->getPrevious()->geterrorCode();
        $methodName         = '_'.$code;

        if (method_exists(self::class, $methodName))
        {
            return response()->view($view, self::$methodName($code));

            //Go back with errors - Problem: Clear form
            //return Redirect::back()->withErrors(self::$methodName($code));
        }
        else
        {
            //return response()->view($view, self::defaultResponse($e->getCode()));
            return trigger_error('DevOps! '.$e->getMessage());
        }
    }

    /*
     * Integrity constraint violation
     * */
    protected static function _1062($code)
    {
        return array(
            'message'   => 'Houve um erro: Tentativa de inserir um registro ja existente.'.' | '.self::$exception->errorInfo[2],
            'code'      => $code,
            'exception' => self::$exception
        );
    }

    protected static function defaultResponse($code)
    {
        return array(
            'message'   => "PDO Exception code: \"$code\" não identificado. Entre em contato com o administrador",
            'code'      => $code,
            'exception' => self::$exception
        );
    }
}