##### Todo List | Pra Viajar

19/01
-[ ] Criar tela de config da cidade (headlines, tags)
-[ ] Criar JS para galeria de fotos junto com contentTools (na view)

22/01 em diante
-[ ] Criar tela de cadastro do autor
-[ ] Criar tela de POST
-[ ] Criar tela de INTERESTS
-[ ] Criar tela de HOME (drag and drop)
-[ ] Criar tela de SERVIÇOS (PLACES) Dúvida!!! Como era mesmo
 o que a pri queria? O serviço pode ser um evento... ou seja, um serviço do serviço? era isso?
 (drag and drop)
-[ ] Setar mapa conforme LATLONG
-[ ] Personalizar TRIGGER_ERRORS (ex: Ao tentar ler config de uma cidade que
ainda não está no banco)

###### Coisas para confirmar quando subir o sistema para produção

-[ ] Verificar se tem permissão total para ler as pastas /public/geonames/* (onde estão todos os dados de WrodlEstructure)

###### Propostas

-[ ] É possível fazer uma leitura de qualquer cidade do mundo pela [API do google](https://developers.google.com/places/web-service/) caso
não tenhamos nenhum post sobre determinado local. Ou seja, podemos trzer fotos, pontos turísticos e outras informações do google, além de Clime (temperatura, vento, humidade...), horário e informações sobre aeroportos

###### Backend

-[ ] JSContentTools (CoffeScript) muito ruim com imageupload. Criar forma melhor com HandleFileSelect()
-[ ] Criar um seeder com nomes dos paises que deseja inserir... dessa forma, o sistema tentar ler todos os arquivos de estados e cidades daquele pais e ja registra no banco. Esse seeder pode inclusive ser outro arquivo TXT dos paises com posts ja criados em produção. penser nisso.
-[x] <span style="color: green">Criar tags para pesquisa e SEO (ex: Nova 
Iorque = new iorque, new york...)</span>
-[ ] Será necessário criar um submitAll() para enviar todos os forms de cada bloco da tela via AJAX. Atualmente cada botão submit pertence apenas a seu bloco
-[ ] Criar validação de forms no backend, inclusive para requisições ajax
-[ ] [Criar estrutura multilanguage com app->locale](http://stackoverflow.com/questions/25082154/how-to-create-multilingual-translated-routes-in-laravel)
> [este artigo](http://stackoverflow.com/questions/19249159/best-practice-multi-language-website) é bem interessante sobre tradução, inclusive usando laravel. Na terceira resposta, alguem fala sobre Thomas Bley e criação de caches (arquivos PHP estáticos) para evitar consultas no banco e execução de funções a cada acesso

###### Frontend
-[ ] Criar coloração diferente para validação de checkboxes...apenas input e select configurados em _Forms.js

#### WorldEstructure 

- [x] <span style="color: green">Ao criar uma tabela listando ESTADOS ou CIDADES, é feita 
a mesma comparação de existencia do registro no banco, se existir, o botão de ação é 
diferente. Criar uma função igual para estas ações. OK 18/01</span>
- [x] <span style="color: green">Separar reino unido em 4 países, mas manter o Reino Unido também cadastrado 17/01</span>
- [x] <span style="color: green">Mudar query de geonames->children para maxRows 200 17/01</span>
- [x] <span style="color: green">Criar função (mesmo que seja manual) para distrinchar 
estados que possuem CONDADOS. Ex: estados unidos, quando tentar ler as cidades de um 
estado, ele traz os condados... o certo seria ler CHILDREN destes condados. 
Acredito que inicialmente a melhor forma e fazer isso manual, colocando o ID do pais 
que possui esta estrutra em um array e fazendo ifelse OK 18/01</span>
- [ ] Criar uma tela de LOADING para ações via ajax. Principalmente GEONAMES que 
pode demorar um pouco
- [ ] Tratar erro ao tentar ler config de uma cidade que ainda não está no banco.
talvez, redirecionar para a tela de criação de post ao clicar em +CONFIG ou enviar
os dados da cidade via POST para a CityController poder exibir os dados. pensar nisso...

###### Model

-[x] <span style="color: green">Criar many-to-many de CityHasHeadline</span>
-[x] <span style="color: green">Criar campo de latitude e longitude da estrutura 
mundial</span>
-[x] <span style="color: green">Criar registros de estrutura mundial a partir do 
GEONAMES.ORG</span>

###### View
-[x] <span style="color: orange; text-decoration: line-through;">opção de criar pais 
e estados na cração de cidades...</span> <span style="font-size: 12px; color: #999;">Toda a criação 
de cidades ou estados deve vir do Geonames, tudo que não for carregado automaticamente 
de forma correta, deve se criar uma função, ex: Orlando e Londres não eram carregados, 
e tem funções específicas para isso</span>


#### Places Model
-[ ] Adicionar uma tabela de views, para controlar data e horário de cada view do local para futura exibição em gráfico

###### Dúvidas Laravel
-[ ] Qual a melhor forma de enviar o POST da controller para model com FKs. Esta certo o que fiz em \Painel\Country();?
-[ ] Como funciona a Facade Redirect::class? Escreve um js na tela? exemplo em PDOExceptions


