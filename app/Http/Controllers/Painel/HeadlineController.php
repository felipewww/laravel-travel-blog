<?php

namespace App\Http\Controllers\Painel;
use App\Headline;
use App\Http\Controllers\Controller;
use Doctrine\DBAL\Driver\PDOException;
use Illuminate\Http\Request;

class HeadlineController extends Controller  {
    public function deleteHeadline(Request $request){

        $res = ['status' => false];
        $reg = Headline::find($request->hl_id);

        try{
            $reg->delete();
            $res['status'] = true;
        } catch (\PDOException $e){
//            dd($e->getTrace());
            $msg = $e->getMessage();

            $erros= [
                '0' => [
                    'msg' => 'Erro desconhecido. Entre em contato com o administrador'
                ],

                '1' => [
                    'msg' => 'Este Headline está sendo usado na Homepage e por isso não pode ser deletado.'
                ]
            ];

            //fk constraint
            if ( $e->getCode() == '23000' )
            {
                if ( strpos($msg, 'homefixeds') )
                {
                    $erro = 1;
                }
                else
                {
                    $erro = 0;
                }
            }
            //Desconhecido
            else
            {
                $erro = 0;
            }

            $res['msg'] = $erros[$erro]['msg'];
//            dd($res);
            return json_encode($res);
        }
        return json_encode($res);

//        dd($reg->Headline()->detach());
//        dd($request->all());
    }
}