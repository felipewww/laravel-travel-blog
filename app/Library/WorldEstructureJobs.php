<?php

namespace App\Library;

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
                $model = new \App\City();
                $this->vars['breadcrumb']['city'] = $model->find($id)->getAttributes();

                $this->vars['breadcrumb']['estate'] =
                    \App\Estate::select('id', 'countries_id', 'name')
                        ->where('id', $this->vars['breadcrumb']['city']['estates_id'])
                        ->first()->getAttributes();

                $this->vars['breadcrumb']['country'] =
                    \App\Country::select('id', 'continents_id', 'name')
                        ->where('id', $this->vars['breadcrumb']['estate']['countries_id'])
                        ->first()->getAttributes();

                $this->vars['breadcrumb']['continent'] =
                    \App\Continent::select('id', 'name')
                        ->where('id', $this->vars['breadcrumb']['country']['continents_id'])
                        ->first()->getAttributes();
            } else if ($from == 'estate') {
                $model = new \App\Estate();
                $local = $model->find($id)->getAttributes();

                $this->vars['breadcrumb']['country'] =
                    \App\Country::select('id', 'continents_id', 'name')
                        ->where('id', $local['countries_id'])
                        ->first()->getAttributes();

                $this->vars['breadcrumb']['continent'] =
                    \App\Continent::select('id', 'name')
                        ->where('id', $this->vars['breadcrumb']['country']['continents_id'])
                        ->first()->getAttributes();
            } else if ($from == 'country') {
                $model = new \App\Country();
                $local = $model->find($id)->getAttributes();

                $this->vars['breadcrumb']['continent'] =
                    \App\Continent::select('id', 'name')
                        ->where('id', $local['continents_id'])
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