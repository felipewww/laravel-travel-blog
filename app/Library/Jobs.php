<?php

namespace App\Library;

use Illuminate\Http\Request;
use League\Flysystem\Exception;

trait Jobs {

    public function postAction(Request $request)
    {
        if (!$request->action) {
            trigger_error('DevOps! input[name="action" value="methodName"] is missing', E_USER_ERROR);
        }

        if (!method_exists($this, $request->action)) {
            trigger_error('DevOps! O método "'.$request->action.'()" não existe em "'.get_class($this).'"', E_USER_ERROR);
        }

        $action = $request->action;
        return $this->$action($request);
    }

    /*
     * Por enquanto a função é idêntica, mas, pode ser que um dia mude.
     * */
    public function apiAction(Request $request)
    {
        return $this->postAction($request);
    }
}