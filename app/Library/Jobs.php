<?php

namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
//use Intervention\Image\Image;

//use Intervention\Image\Image;

//use Intervention\Image\Image;
//use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
// use Intervention\Image;

trait Jobs {
    public $json_meta = [];
    public $vars = [];
    public $model;
    public $reg;
//    use InterventionImageExtensions;

    public function getReg($from, $id){
        $this->model    = new $from();
        $this->reg      = $this->model->find($id)->first();
    }

    public static function uploadImage($image, $path, $paramns = []){
        $i = new InterventionImageExtensions();
        return $i->uploadImage($image, $path, $paramns);
//        InterventionImageExtensions::_uploadImage($image, $paramns);
    }

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
        $request->action = $request->action.'AjaxAction';
        return $this->postAction($request);
    }

    /*
     * Converter string para URL Amigável
     * */
    function toAscii($str, $replace=array(), $delimiter='-') {
        $str = preg_replace('/[`^~,\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $str));
        $str = preg_replace('/ /', '_', $str);
        $str = strtolower($str);

        return $str;
    }

    public static function _toAscii($str, $replace=array(), $delimiter='-') {
        $str = preg_replace('/[`^~,\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $str));
        $str = preg_replace('/ /', '_', $str);
        $str = strtolower($str);

        return $str;
    }

    /*
     * Armazenar varáveis PHP importantes em JSON e passar para uma metatag da tela renderizada
     * */
    public function json_meta(array $data)
    {
        //Verificação inicial, se ainda não houver nada, converter para json vazio.
        if (is_array($this->json_meta)) {
            $this->json_meta = json_encode($this->json_meta);
        }

        $currData = json_decode($this->json_meta, true);

        foreach ($data as $k => $v){
            $currData[$k] = $v;
        }

        $this->json_meta = json_encode($currData);
        $this->vars['json_meta'] = $this->json_meta;
    }
}