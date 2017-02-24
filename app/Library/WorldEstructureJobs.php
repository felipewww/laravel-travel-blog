<?php

namespace App\Library;

use App\City;
use App\Continent;
use App\Country;
use App\Estate;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

trait WorldEstructureJobs {

    /*Do not add public $vars here! USE JOBS TRAIT! */

    public function getEstructureBreadcrumb($from, $id)
    {
        if ($id instanceof Request)
        {
            $this->getEstructureBreadcrumbScreenJson($from, $id->all());
        }
        else
        {
            if ($from == 'city') {

                if ($id instanceof City) {
                    $city = $id;
                }else{
                    $city = City::select('name','id','estates_id')->where('id',$id)->first();
                }

                $this->vars['breadcrumb']['city'] = $city;

                $this->vars['breadcrumb']['estate'] =
                    \App\Estate::select('id', 'countries_id', 'name')
                        ->where('id', $city->estates_id)
                        ->first()->getAttributes();

                $this->vars['breadcrumb']['estate'] =
                    \App\Estate::select('id', 'countries_id', 'name')
                        ->where('id', $city->estates_id)
                        ->first()->getAttributes();

                $this->vars['breadcrumb']['country'] =
                    \App\Country::select('id', 'continents_id', 'name')
                        ->where('id', $this->vars['breadcrumb']['estate']['countries_id'])
                        ->first()->getAttributes();

                $this->vars['breadcrumb']['continent'] =
                    \App\Continent::select('id', 'name')
                        ->where('id', $this->vars['breadcrumb']['country']['continents_id'])
                        ->first()->getAttributes();
            }else if($from == 'country'){
                $this->vars['breadcrumb']['country'] = $this->reg;

                $this->vars['breadcrumb']['continent'] =
                    Continent::select('id', 'name')
                        ->where('id', $this->vars['breadcrumb']['country']['continents_id'])
                        ->first()->getAttributes();
            }
        }
    }

    private function getEstructureBreadcrumbScreenJson($from, $data)
    {
        $this->vars['breadcrumb']['continent'] = Continent::where('id', $data['country']['continents_id'])->first()->getAttributes();
        $this->vars['breadcrumb']['country'] = Country::where('id', $data['country']['id'])->first()->getAttributes();

        if ($from == 'city')
        {
            $this->vars['breadcrumb']['city'] = [
                'name' => $data['city']['name'],
                'id' => $data['city']['geonameId'],
            ];

            $this->vars['breadcrumb']['estate'] = [
                'name' => $data['estate']['name'],
                'id' => $data['estate']['geonameId'],
            ];
        }
    }
}