<?php

namespace App\Library;

use App\City;
use App\Country;
use App\Place;
use App\PlacePhotos;
use App\Post;
use App\PostPhotos;

trait photoGallery {

//    public $galleryTable;
//    public static $caller;

    function __construct($from)
    {
        $this->caller = new $from();

        if ( !isset($this->vars['from']) ) {
            $this->vars['from'] = $from;
        }

        if ( !isset($this->reg) ) {
            throw new \Error('Obrigatório "$this->reg" para ler photoGallery');
        }

        if ( !isset($this->model) ) {
            throw new \Error('Obrigatório "$this->model" para ler photoGallery');
        }


        $this->vars['photoGallery'] = $this->reg->Photos()->orderBy('position')->get();
    }

    public function createOrUpdatePhotoGallery($request)
    {
        $photos = $request->photo;
        $i = 0;
        foreach ($photos as $photo)
        {
            ( isset($photo['id']) ) ? $this->updatePhotoGallery($i, $photo) : $this->createPhotoGallery($i, $photo, $request->fk_id);
            $i++;
        }

        return [
            'message' => [
                'type' => 'success', 'title' => 'Feito!', 'text' => 'Galeria de fotos atualizada com sucesso.'
            ]
        ];
    }

    public function updatePhotoGallery($pos, $photo)
    {
        $reg = $this->caller->Photos()->getRelated()->where('id', $photo['id'])->first();

        if ( isset($photo['img']) )
        {
            if (file_exists( public_path($reg->path)) ) {
                unlink( public_path($reg->path) );
            }

            $reg->path = self::uploadPhotoGalleryImage($photo['img'], self::getFolder())->fullpath;
            unset($photo['img']);
        }

        foreach ($photo as $attr => $val){
            $reg->$attr = $val;
        }
        $reg->position = $pos;

        $reg->save();
    }

    public function createPhotoGallery($pos, $photo, $fk_id)
    {
        $fk = $this->caller->Photos()->getForeignKey();

        $reg = $this->caller->Photos()->getRelated();
        $reg->position  = $pos;
        $reg->$fk       = $fk_id;
        $reg->path      = self::uploadPhotoGalleryImage($photo['img'], self::getFolder())->fullpath;
        unset($photo['img']);

        foreach ($photo as $attr => $val){
            $reg->$attr = $val;
        }

        $reg->save();
    }

    public function getFolder()
    {
        switch ($this->vars['from'])
        {
            case Post::class:
                $folder = 'postContent';
                break;

            case City::class:
                $folder = 'cidades';
                break;

            case Country::class:
                $folder = 'paises';
                break;

            case Place::class:
                $folder = 'places';
                break;

            default:
                throw new \Error('$from missing. Impossible to upload or create image.');
                break;
        }

        return $folder;
    }

    /*
 * Default de crop da imagem do sistema.
 * É possível sobrepor este método diretamente na controller.
 * */
    protected function uploadPhotoGalleryImage($img, $folder){
        return $img = Jobs::uploadImage($img, "Site/media/images/$folder/gallery",
            [
                'shape' => 'square',
                'max-width' => 400,
            ]
        );
    }
}