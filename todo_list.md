##### Todo List | Pra Viajar
- [x] <span style="color: green">Criar tela de config da cidade (headlines, tags). Permitir status ativo para página somente se houver region_content</span>
- [x] <span style="color: green">Finalizar tela de INTERESTS. Ok, falta editar o interesse e o globo de cores.</span>
- [x] <span style="color: green">Criar CRUD do POST</span>
- [x] <span style="color: green">Testar o conceito usado na criação de place_has_events, mantendo apenas o ID do evento como PK, para permitir que o evento só possa ser relacionado com uma cidade, mesmo em many to many,
isso ficará tipo um polimorfismo. Afinal event pode se relacionar com PLACE ou CITY. então, ou cria EVENT para city... com o ID de city, ou para place, com o ID de place em outra tabela de many to many. Se isso der certo, criar tambem a tabela para city_has_event</span>
- [x] <span style="color: green">Remover polimorfismo de HEADLINES e POSTS... o do laravel é ruim!</span>
- [x] <span style="color: green">Criar CRUD de PLACES</span>
- [x] <span style="color: green">Criar status para Places.</span> 
- [x] <span style="color: green">Criar galeria de fotos</span>
- [x] <span style="color: green">Criar POSTS do tipo LIST para PAISES e CIDADES. Lista será post sim!</span>
- [x] <span style="color: green">Finalizar HOME, drag and drop de tudo que possue headline. Verificar se esta buscando somente coisas ativas. Ex</span>
- [x] <span style="color: green">OK, mas não haverá post para paises. Padronizar POST (e criação de páginas, se der) igual Interests, PhotoGallery e etc. para poder usar Post/Páginas também em Países</span>
- [x] <span style="color: green">[CANCELADO]Cadastrar galeria de fotos para paises (interests não! virá da média de cidades)</span>
- [x] <span style="color: green">Cadastrar headlines para países</span>
- [ ] Galeria de fotos para cidade
- [ ] LatLong e mapa para PLACE
- [ ] Ao final... Criar campo de pesquisa por palavra, tags, places, cidades, interesses...

- [x] <span style="color: green">Exibir listagem de cidades e países cadastrados no banco (qtde de posts, status, qtde de headlines)</span>

#### DEFINIR PRIORIDADE
- [ ] Cadastro e agendamento de HOMES
- [ ] Cadastrar eventos (PLACES ou EVENTOS? EVENTOS!) com inicio e fim de exibição. Não é um subserviço, é um evento da cidade que pode ser relacionado a um PLACE

Editado em 03/02 - Previsão - 13-02
19/01
-[x] Criar tela de config do POST (headlines, tags).

22/01 em diante
- [x] <span style="color: green">Criar tela de cadastro do autor</span>
- [x] <span style="color: green">Criar tela de POST</span>
- [x] <span style="color: green">seed de post_Types e places esta identico</span>
- [ ] Finalizar tela de exibição dos posts cadastrados.
- [ ] Tem como fazer pesquisa de headline por ID na home?
- [x] Copiar o upload e recorte de imagem para os uploads
- [ ] Confirmar ao criar POSt para cidade não cadastrada, avisando que possivelmente esse psot não será muito visualizado.
- [x] <span style="color: green">Setar mapa conforme LATLONG</span>
- [x] <span style="color: green">Personalizar TRIGGER_ERRORS (ex: Ao tentar ler config de uma cidade que
ainda não está no banco)</span>
- [x] <span style="color: green">resolver a questão de enviar o POST para a mesma página do registro, se apertar F5, insere de novo.
DOCUMENTAÇÃO</span>
- [ ] permitir ativar/inativar posts via PAGINA DA CIDADE nos botoes multaction
- [x] <span style="color: green">2 formas de CRIAR uma cidade. via painel adm no botão "criar página" ou "criar post". No caso de criar post, se a cidade for inexsistente</span>
- [ ] Criar uma tela de cadastro de LAYOUT DE HOMEPAGE... isso deverá ficar no item DEVELOPEr do menu... só pode alterar um LAYOUT de uma home desde que a home ativa não esteja usando ele mesmo, dessa forma podemos adicioanr REGIONS a uma home ja existente, ao inves de criar nova.
###### Coisas para confirmar quando subir o sistema para produção

-[ ] Verificar se tem permissão total para ler as pastas /public/geonames/* (onde estão todos os dados de WrodlEstructure)
-[ ] Verificar se tem permissão total para ler Store/framework/view para que o Laravel possa dar um clear cache nas views
-[ ] layoutar página de erro 404
###### Propostas

-[ ] É possível fazer uma leitura de qualquer cidade do mundo pela [API do google](https://developers.google.com/places/web-service/) caso
não tenhamos nenhum post sobre determinado local. Ou seja, podemos trazer fotos, pontos turísticos e outras informações do google, além de Clime (temperatura, vento, humidade...), horário e informações sobre aeroportos

###### Backend

-[ ] JSContentTools (CoffeScript) muito ruim com imageupload. Criar forma melhor com HandleFileSelect()
-[ ] Criar um seeder com nomes dos paises que deseja inserir... dessa forma, o sistema tentar ler todos os arquivos de estados e cidades daquele pais e ja registra no banco. Esse seeder pode inclusive ser outro arquivo TXT dos paises com posts ja criados em produção. penser nisso.
-[x] <span style="color: green">Criar tags para pesquisa e SEO (ex: Nova 
Iorque = new iorque, new york...)</span>
-[ ] [CANCELADO] Será necessário criar um submitAll() para enviar todos os forms de cada bloco da tela via AJAX. Atualmente cada botão submit pertence apenas a seu bloco
-[ ] Criar validação de forms no backend, inclusive para requisições ajax
-[ ] [Criar estrutura multilanguage com app->locale](http://stackoverflow.com/questions/25082154/how-to-create-multilingual-translated-routes-in-laravel)
- [ ] Criar uma tela de LOADING para ações via ajax. Principalmente GEONAMES que 
pode demorar um pouco
> [este artigo](http://stackoverflow.com/questions/19249159/best-practice-multi-language-website) é bem interessante sobre tradução, inclusive usando laravel. Na terceira resposta, alguem fala sobre Thomas Bley e criação de caches (arquivos PHP estáticos) para evitar consultas no banco e execução de funções a cada acesso
###### Frontend
- [ ] Criar coloração diferente para validação de checkboxes...apenas input e select configurados em _Forms.js
- [x] <span style="color: green">Cadastrar editorias no banco - Arte e cultura, comer e beber, estilo de vida, roteiro, pra voce^(info), [pra viajar indica LISTA], [VIDEOS]</span>
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
- [x] <span style="color: green">Tratar erro ao tentar ler config de uma cidade que ainda não está no banco.
talvez, redirecionar para a tela de criação de post ao clicar em +CONFIG ou enviar
os dados da cidade via POST para a CityController poder exibir os dados. pensar nisso...</span>

###### Usuários

- [ ] Criar método para caso inativar um AUTHOR, trnasferir a autoria para outro... ou não? Se não... fica sem autor? Ou põe autoria do praviajar? 

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


