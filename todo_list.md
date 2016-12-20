##### Todo List | Pra Viajar

###### Propostas

-[ ] É possível fazer uma leitura de qualquer cidade do mundo pela [API do google](https://developers.google.com/places/web-service/) caso
não tenhamos nenhum post sobre determinado local. Ou seja, podemos trzer fotos, pontos turísticos e outras informações do google, além de Clime (temperatura, vento, humidade...), horário e informações sobre aeroportos

###### Backend

-[ ] Criar tags para pesquisa e SEO (ex: Nova Iorque = new iorque, new york...)
-[ ] Será necessário criar um submitall() para enviar todos os forms da tela via AJAX. Atualmente cada botões submit pertence a um bloco
-[ ] Criar validação de forms no backend, inclusive para requisições ajax
-[ ] [Criar estrutura multilanguage com app->locale](http://stackoverflow.com/questions/25082154/how-to-create-multilingual-translated-routes-in-laravel)
> [este artigo](http://stackoverflow.com/questions/19249159/best-practice-multi-language-website) é bem interessante sobre tradução, inclusive usando laravel. Na terceira resposta, alguem fala sobre Thomas Bley e criação de caches (arquivos PHP estáticos) para evitar consultas no banco e execução de funções a cada acesso

###### Frontend
-[ ] Criar coloração diferente para validação de checkboxes...apenas input e select configurados em _Forms.js

#### WorldEstructure 

###### Model

-[ ] Criar many-to-many de CityHasHeadline


-[x] <span style="color: green">Criar campo de latitude e longitude da estrutura mundial</span>

-[ ] Criar registros de estrutura mundial a partir do GEONAMES.ORG
###### View
-[ ] opção de criar pais e estados na cração de cidades...


#### Places Model
-[ ] Adicionar uma tabela de views, para controlar data e horário de cada view do local para futura exibição em gráfico

###### Dúvidas Laravel
-[ ] Qual a melhor forma de enviar o POST da controller para model com FKs. Esta certo o que fiz em \Painel\Country();?
-[ ] Como funciona a Facade Redirect::class? Escreve um js na tela? exemplo em PDOExceptions


