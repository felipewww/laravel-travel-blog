<?php

namespace App\Library;
use Intervention\Image\Facades\Image;

class InterventionImageExtensions {

    public $image;
    public $orientation;
    public $paramns;

    /*
     * If send $path without "/" at last character, its dont work.
     * */
    private function verifyPath(&$path)
    {
        $lastChar = substr($path, -1);

        if ($lastChar !== '/'){
            $path .= '/';
        }
    }

    public function uploadImage($image, $path, $paramns = [])
    {
        //Colocar pregmatch pois o laravel retorna nome com a extensão
        $name = Jobs::_toAscii( preg_replace('/\..+$/', '', $image->getClientOriginalName()) );

        $this->verifyPath($path);

        $maxWidth = $paramns['max-width'] ?? 600;
        $paramns['max-width'] = $maxWidth;
        $this->paramns = $paramns;

        $this->image = Image::make($image);

        $this->orientation = ( $this->image->width() > $this->image->height() ) ? 'h' : 'v';

        //Shape
        if ( isset($paramns['shape']) ) { $this->imageShape($paramns['shape']); }

        //Maximum width
        if ($this->image->width() > $maxWidth) { $this->image->widen($maxWidth); }

        //Save...
        //$filename  = $paramns['filename'] ?? '';
        $filename = $name.'_'.rand(1,100).'_'.time().'.'.$image->getClientOriginalExtension();

        $finalPath = public_path($path . $filename);
        $this->image->save($finalPath);

        $this->image->fullpath = $path.$filename;
        return $this->image;
    }

    private function imageShape()
    {
        $shape = $this->paramns['shape'];

        if ($shape == 'square')
        {
            //Se for horizontal, recortar LATERAIS
            if ($this->orientation == 'h')
            {
                $height = $this->image->height();
                $this->image->crop($height, $height);
            }
            //Se não... é VERTICAL, recortar TOP e BOTTOM
            else
            {
                $width  = $this->image->width();
                $this->image->crop($width, $width);
            }
        }
    }
}