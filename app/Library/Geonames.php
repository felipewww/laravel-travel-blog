<?php

namespace Lib;

class Geonames {
    public $teste = array('teste'=>true);
    protected $username = 'praviajar';

    public function getCountries()
    {
        $curl = curl_init("http://api.geonames.org/countryInfo?username=$this->username&type=full");
        $response = curl_exec($curl);
        curl_close($curl);

        //$response = json_decode($response, true);
        //print_r($response[0]);

        $response = new SimpleXMLElement($response);

        echo 'Contagem: '.count($response);
    }

    protected function download_page(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://api.geonames.org/countryInfo?username=$this->username&type=full");
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $retValue = curl_exec($ch);
        curl_close($ch);
        return $retValue;
    }

    public function another()
    {
        $sXML = $this->download_page();
        $oXML = new \SimpleXMLElement($sXML);

        $json = json_encode($oXML);
        //var_dump($oXML);
//        foreach($oXML->entry as $oEntry){
//            echo $oEntry->title . "\n";
//        }
    }

    public function csv()
    {
        $str = "atendimento@ygarape.com.br;turismo@canela.rs.gov.br;pbrito@travelace.com.br;dmendes@travelace.com.br;H6383-SL1@sofitel.com;bruno@tmccomunicacao.com.br;agarza@promotur.com.mx;estergalli@sedec.mt.gov.br;jb.gillot@cap-amazon.com;ana.severo@cap-amazon.com;erick.k@rendimento.com.br;waleska.feitosa@pontosmultiplus.com.br;simoni.rosa@pontosmultiplus.com.br;atsuji@segurviaje.com.br;claudia@acessooh.com.br;tatiana@acessooh.com.br;juliana@acessooh.com.br;danilo.castro@fcb.com;vivian.salazar@fcb.com;fernanda.vellutini@fcb.com;germano.oliveira@fcb.com;Camila.Gazzano@fcb.com;Nathalia.Oliveira@fcb.com;Rafaela.Silva@fcb.com;Lucca.Barbarisi@fcb.com;acais@fnazca.com.br;frodrigues@fnazca.com.br;etamashiro@fnazca.com.br;lgallizzi@fnazca.com.br;aroza@fnazca.com.br;tcustodio@fnazca.com.br;aweiss@fischeramerica.com.br;rmartins@fischeramerica.com.br;prosa@fischeramerica.com.br;CFiuza@fischeramerica.com.br;LBortolato@fischeramerica.com.br;Fernanda.Galdino@idealhks.com;leonardo.leoni@agenciaideal.com.br;luiz@lovaz.com.br;sheila.campos@mcgarrybowen.com.br;leticia.torres@mcgarrybowen.com.br;alan.viana@mcgarrybowen.com.br;solon.anjos@mcgarrybowen.com.br;juliana.spina@mcgarrybowen.com.br;karem.pugliesi@neogama.com.br;cibele.perandin@neogama.com.br;nicholas.furusato@neogama.com.br;izabel.asprino@ogilvy.com;marcelo.carvalhaes@ogilvy.com;juliana.soares@ogilvy.com;paulo.ferreira@ogilvy.com;renata.castro@ogilvy.com;pamela.araujo@ogilvy.com;daniele.bellini@ogilvy.com;priscilla.marcossi@rai.com.br;scheila.santos@rai.com.br;bruno.bernardo@rai.com.br;vera@rinocom.com.br;Ana.Costa@wunderman.com;almir.pereira@agenciawe.com.br;carlos.chagas@agenciawe.com.br;amanda.vansan@agenciawe.com.br;mauricio.torres@agenciawe.com.br;luani.macri@agenciawe.com.br;brunno.froes@agenciawe.com.br;Camila.Felix@yr.com;thiago.martinez@yr.com;marcello.bolla@yr.com;Rafael.Leal@yr.com;patricia.russo@yr.com;andrea.veronezi@publicis.com.br;raquel.mattoso@publicis.com.br;karina.lima@publicis.com.br;nathalia.rodrigues@publicis.com.br;mariane.franzim@publicis.com.br;leonardo.montuori@publicis.com.br;camila.donice@publicis.com.br;edera.bonato@jwt.com;vanessa.pupato@jwt.com;priscila.dias@jwt.com;mqlopes@cinemark.com.br;bbertellini@cinemark.com.br;cibele.coelho@eugenio.com.br;marcelo.henrique@eugenio.com.br;rodrigo.tamer@ldc.agency;kelly.cotta@ldc.agency;bruna.simoes@ldc.agency;pamalfi@vctbrasil.com;sergio@opy.com.br;caroline.saraiva@grupocolombo.com.br;elisangela.nascimento@grupocolombo.com.br;juliana.gil@manserv.com.br;bruno.scaravelli@mega.com.br;marketing@barbacoa.com.br;tarsila.leite@telelok.com.br;marinasalgado@cvc.com.br;talbe@porte.com.br;julio-arantes@auroraalimentos.com.br; gabriela.duque@totvs.com.br; thiago.soares@totvs.com.br; cristiano@t12.com.br; leonardo.nahum@santaclara.sc; patricia.angelis@santaclara.sc; comunicacao@ogochi.com.br; marketing@harborhoteis.com.br;  midia@ggedesign.com.br; marketing@harborhoteis.com.br; midia@ggedesign.com.br; midiarenner@paim.com.br; midia@grupogpac.com.br; midia.paim@paim.com.br; 'Marcos' <marcos@damulticom.com.br>; marketingarezzo@arezzo.com.br; magali@agenciamatriz.com.br; magali@agenciamatriz.com.br; manu@vervecom.com.br; mochoa@escritoriodoperu.com.br; monique.ristow@amctextil.com.br; midia@3mosqueteiros.com; midia@archote.com.br; midia@e21.com.br; midia3@bronx.com.br; midia@imam.ag; midia.poa@debrito.com.br; nadaireservas3@nadaiconforthotel.com.br; nicoli_barboza@beirario.com.br; 'Natalia Mejia Sanmiguel' <namejia@procolombia.co>; 'Natalia Marques' <nataliamarques.wmb@gmail.com>; nahara@protarget.com.br; natalia.morastica@wk.com; natalia@agenciagaudi.com.br; neusa.braz@repensecomunicacao.com.br; patricia.angelis@santaclara.sc; patricia.figueiredo@adag.com.br; paulo@zerocinco.com.br; paula.waskow@intercityhoteis.com.br; patricia.checco@marisolsa.com; patricia@pontadosganchos.com.br; paula.comercial@dalmobile.com.br; paulo.brazil@slavierohoteis.com.br; pauloyvanalmeida@yara.com; paula.santos@morya.com.br; Pedro Santana (pedro.santana@a2c.com.br); 'pedro.botelho@pestana.com'; Pedro@rinocom.com.br; pilar@rinocom.com.br; poliana@vivascom.com.br; quimmi@agenciamatriz.com.br; raiane.tondo@miolo.com.br; robson@sagracom.com.br; raissa.bittar@arezzo.com.br; racon.com.br; 'Raphaella Requião Bicca' (raphaella.requiao@restaurantemadero.com.br); rafael@dezcomunicacao.com.br; rafael@escape.ppg.br; vitrineglobal@vitrineglobal.com; renata.zon@incortel.com.br; Renato Rodrigues Rita (renato@decanter.com.br); Ricardo Marques de Oliveira (ricardomarques@auroraalimentos.com.br); romina.decintra@genommalab.com; rubeniacasacivil@gmail.com; thais.somensi@miolo.com.br; thais.hipolito@vivascomunicacao.com.br; 'Thamirez Lopes' <thamirez.lopes@vivascomunicacao.com.br>; thiago@sinergiapublicidade.com.br; thaise@daraujo.com; tulio@blu.com.br; Thielle (thielle@safeweb.com.br); thiago.penna@mvagencia.com.br; renata.zon@incortel.com.br; Renato Rodrigues Rita (renato@decanter.com.br); Ricardo Marques de Oliveira (ricardomarques@auroraalimentos.com.br); romina.decintra@genommalab.com; rubeniacasacivil@gmail.com; thais.somensi@miolo.com.br; thais.hipolito@vivascomunicacao.com.br; 'Thamirez Lopes' <thamirez.lopes@vivascomunicacao.com.br>; thiago@sinergiapublicidade.com.br; thaise@daraujo.com; tulio@blu.com.br; Thielle (thielle@safeweb.com.br); thiago.penna@mvagencia.com.brvitrineglobal@vitrineglobal.com; Vanessa Quinsani (vanessa@sistemadez.com); 'Vanessa  Sallas' <vsallas@bluetree.com.br>; 'Velasquez, Alvaro (BOG-MBW)' <Alvaro.Velasquez@mbww.com>; Vivian Bueno (vivian.bueno@propague.com.br); virginiakt@pontadosganchos.com.br; zetola@heads.com.br; ranny@mg2.ppg.br; rafael@oracon.com.br; 'Raphaella Requião Bicca' (raphaella.requiao@restaurantemadero.com.br); rafael@dezcomunicacao.com.br; rafael@escape.ppg.br;quimmi@agenciamatriz.com.br; raiane.tondo@miolo.com.br; robson@sagracom.com.br; raissa.bittar@arezzo.com.br; rsantacruz@riu.com;  Rafael (rtakeshita@cpbgroup.com); rolf@greengrass.com.br; ranny@mg2.ppg.br; rafael@oracon.com.br; 'Raphaella Requião Bicca' (raphaella.requiao@restaurantemadero.com.br); rafael@dezcomunicacao.com.br; rafael@escape.ppg.br; vitrineglobal@vitrineglobal.com; renata.zon@incortel.com.br; Renato Rodrigues Rita (renato@decanter.com.br); Ricardo Marques de Oliveira (ricardomarques@auroraalimentos.com.br); romina.decintra@genommalab.com; rubeniacasacivil@gmail.com; thais.somensi@miolo.com.br; thais.hipolito@vivascomunicacao.com.br; 'Thamirez Lopes' <thamirez.lopes@vivascomunicacao.com.br>; thiago@sinergiapublicidade.com.br; thaise@daraujo.com; tulio@blu.com.br; Thielle (thielle@safeweb.com.br); thiago.penna@mvagencia.com.br;daniela.delucas@vinicolaaurora.com.br; daniele.machado@propague.com.br; 'Daniel Muro' (daniel@damulticom.com.br); 'Daniela Azancoth' (daniela.azancoth@amctextil.com.br); dnascimento@cpbgroup.com; dearaujo@weg.net; denise.calvo@xtudocomunicacao.com.br; dejane@tempobrasil.net; Deniria Nobre - Neovox (deniria@neovox.com.br); Deisy.Sanchez@umww.com; 'Denise - VISIT FLORIDA' <darencibia@visitflorida.org>; denise.poa@morya.com.br; dennis.grassi@paim.com.br; diego.pamplona@ems.com.br; diciane@rba.com.br; douglas.farland@agenciaduplo.com.br; 'Edgar Ignácio' <eignacio@mktbt.com>; eveline.wendland@agenciaescala.com.br; 'Everton Araujo' <everton@damulticom.com.br>; 'estefania@protarget.com.br'; 'emerson@sarteschi.com.br'; 'emendes@refcomunicacao.com.br'; erjimenez@atp.gob.pa; erick.k@rendimento.com.br; 'estefania@protarget.com.br'; Danilo Huvos (OGOCHI)' (estilo4@ogochi.com.br); 'Marina Rossignati (OGOCHI)' (estilo3@ogochi.com.br); franciane@bullet.com.br; Fernanda Weisheimer - www.433.ag (fernandaw@433.ag); felipezetola@heads.com.br; flavia.oncins@3ds.com; flavia.oncins@3ds.com; flavia.ayala@samsonite.com; flavia@explicita.com.br; gustavo@buggyecia.com; gisele@t12.com.br; Gabriela Priante Duque (gabriela.duque@totvs.com.br); gabriel@loucosporchurros.com.br; gabriela.coinca@intercityhoteis.com.br; gisele@t12.com.br; gpompiani@cpbgroup.com; gerad@santur.sc.gov.br; gislaine.jardim@marisolsa.com; gislene@sinergiapublicidade.com.br; glauci@onewg.com.br; Gomes, Andre Vinicius Siqueira (andre.gomes@merck.com); guilherme.valim@agenciabistro.com; guilherme.alves@pearson.com; guilherme@agencia85.com.br; henrique.carvalho@agenciaduplo.com.br; heloisa@decanter.com.br; Isma (isma@fazcomunicacao.com.br); Izabela Nóbrega (izabela@fazcomunicacao.com.br); israel@censi.com.br; ISABELY KARINE CAVALCANTI DE BRITO (isabely.cavalcanti@recife.pe.gov.br); igor.souza@klin.com.br; Indiara.schultz@sotaquepropaganda.com.br; iris.estella@sotaquepropaganda.com.br; izabele.pesinato@atout-france.fr; izadora@altermark.com.br; jimmy@bai-visas.com; Julio-arantes@auroraalimentos.com.br; juliana.azevedo@br.pwc.com; Julieta (midia@flexcomunicacao.com.br); julianabastos@sagracom.com.br; juliana.nagle@samsonite.com; Jungle Atendimento (atendimento@agenciajungle.com.br); daniela.delucas@vinicolaaurora.com.br; daniele.machado@propague.com.br; 'Daniel Muro' (daniel@damulticom.com.br); 'Daniela Azancoth' (daniela.azancoth@amctextil.com.br); dnascimento@cpbgroup.com; dearaujo@weg.net; denise.calvo@xtudocomunicacao.com.br; dejane@tempobrasil.net; Deniria Nobre - Neovox (deniria@neovox.com.br); Deisy.Sanchez@umww.com; 'Denise - VISIT FLORIDA' <darencibia@visitflorida.org>; denise.poa@morya.com.br; dennis.grassi@paim.com.br; diego.pamplona@ems.com.br; diciane@rba.com.br; douglas.farland@agenciaduplo.com.br; 'Edgar Ignácio' <eignacio@mktbt.com>; eveline.wendland@agenciaescala.com.br; 'Everton Araujo' <everton@damulticom.com.br>; 'estefania@protarget.com.br'; 'emerson@sarteschi.com.br'; 'emendes@refcomunicacao.com.br'; erjimenez@atp.gob.pa; erick.k@rendimento.com.br; 'estefania@protarget.com.br'; Danilo Huvos (OGOCHI)' (estilo4@ogochi.com.br); 'Marina Rossignati (OGOCHI)' (estilo3@ogochi.com.br); franciane@bullet.com.br; Fernanda Weisheimer - www.433.ag (fernandaw@433.ag); felipezetola@heads.com.br; flavia.oncins@3ds.com; flavia.oncins@3ds.com; flavia.ayala@samsonite.com; flavia@explicita.com.br; gustavo@buggyecia.com; gisele@t12.com.br; Gabriela Priante Duque (gabriela.duque@totvs.com.br); gabriel@loucosporchurros.com.br; gabriela.coinca@intercityhoteis.com.br; gisele@t12.com.br; gpompiani@cpbgroup.com; gerad@santur.sc.gov.br; gislaine.jardim@marisolsa.com; gislene@sinergiapublicidade.com.br; glauci@onewg.com.br; Gomes, Andre Vinicius Siqueira (andre.gomes@merck.com); guilherme.valim@agenciabistro.com; guilherme.alves@pearson.com; guilherme@agencia85.com.br; henrique.carvalho@agenciaduplo.com.br; heloisa@decanter.com.br; Isma (isma@fazcomunicacao.com.br); Izabela Nóbrega (izabela@fazcomunicacao.com.br); israel@censi.com.br; ISABELY KARINE CAVALCANTI DE BRITO (isabely.cavalcanti@recife.pe.gov.br); igor.souza@klin.com.br; Indiara.schultz@sotaquepropaganda.com.br; iris.estella@sotaquepropaganda.com.br; izabele.pesinato@atout-france.fr; izadora@altermark.com.br; jimmy@bai-visas.com; Julio-arantes@auroraalimentos.com.br; juliana.azevedo@br.pwc.com; Julieta (midia@flexcomunicacao.com.br); julianabastos@sagracom.com.br; juliana.nagle@samsonite.com; Jungle Atendimento (atendimento@agenciajungle.com.br); karen.akemi@restaurantemadero.com.br; karla@tm4.com.br; karina.rhis@outletpremium.com.br; karla.barbosa@agenciaduplo.com.br; karyn.velho@lamoda.com.br; kika@agenciatig.com.br; kamila.santos@agenciaescala.com.br; karina.rodrigues@oracon.com.br; kosiba@heads.com.br";
        $t = explode(';',$str);

        foreach ($t as $key => &$mail)
        {
            $pos = strpos($mail,'(');
            if ($pos) {
                $posFinal = strpos($mail,')');

                $newMail = substr($mail, ($pos+1), -1);
                echo 'Key '.$key.' recotar de '.$pos.' até '.$posFinal.' - '.$newMail."\n";
                $mail = $newMail;
                //var_dump($t[$key]);
            }
        }

        foreach ($t as $key => &$mail)
        {
            $pos1 = strpos($mail,'(');
            $pos2 = strpos($mail,')');
            $pos3 = strpos($mail,'<');
            $pos4 = strpos($mail,'>');
            $pos5 = strpos($mail,"'");

            if ($pos1 || $pos2 || $pos3 || $pos4 || $pos5)
            {
                unset($t[$key]);
                echo 'Excluir registro '.$key.' - '.$mail."\n";
            }

            $mail = trim($mail);
        }

        $fp = fopen($_SERVER['DOCUMENT_ROOT']."myText.csv","w+");
        foreach ($t as $mail)
        {
//            $content = $mail.',';
//            fwrite($fp,$content);
            fputcsv($fp, [$mail]);
        }
        fclose($fp);
    }
}