<?php

namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public $caller;
    public $selectColumns = '*';

    public function getReg($from, $id){

        if (empty($this->model)) {
            $this->model = new $from();
        }

        if (empty($this->reg)) {
            $this->reg = $this->model->select($this->selectColumns)->where('id', $id)->first();
            if ( !isset($this->vars['reg']) ) {
                $this->vars['reg'] = $this->reg;
            }
        }

        if (empty($this->caller)) {
            $this->caller = get_class($this->model);
        }
    }

    public static function uploadImage($image, $path, $paramns = []){
        $i = new InterventionImageExtensions();
        return $i->uploadImage($image, $path, $paramns);
    }

    public function createNullReg(){
        $this->reg = new \stdClass();
        $columns = DB::getSchemaBuilder()->getColumnListing($this->model->getTable());

        foreach ($columns as $col){
            $this->reg->$col = null;
        }
    }

    public function hasAction($request)
    {
        if ($request instanceof Request)
        {
            if ( !empty($request->all()) )
            {
                return $this->postAction($request);
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * @see searchtags_form.blade.php
     * Função executada no action. Isso porque várias telas possuem Tags.
     * */
    private function updateOrCreateTags($request)
    {
        $this->reg->search_tags    = $request->system;
        $this->reg->seo_tags       = $request->seo;
        $this->reg->save();

        return [
            'status' => true,
            'message' => [
                'text' => 'Tags atualizadas com sucesso!',
                'type' => 'success'
            ]
        ];
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

    /**
     * @deprecated
     * Converter string para URL Amigável
     * */
    function toAscii($str, $replace=array(), $delimiter='-') {
        $str = preg_replace('/[`^~,\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $str));
        $str = preg_replace('/ /', '_', $str);
        $str = strtolower($str);

        return $str;
    }

    public static function _toAscii($str, $replace=array(), $delimiter='-') {
        $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
        $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
        $str = str_replace($what, $by, $str);

        $str = preg_replace('/[`^~,\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $str));
        $str = preg_replace('/ /', '_', $str);
        $str = strtr($str, array('(' => '', ')' => ''));
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