@extends('Painel.layouts.app')

@section('content')
    <section class="block">
        <header>
            <div class="title">
                <span>Bloco Comum</span>
            </div>
            <div class="actions">
                <a href="#" class="button light-red waves-effect">cancelar</a>
                <a href="#" class="button light-blue waves-effect">editar</a>
            </div>
            <div class="cleaner"></div>
        </header>


        <section class="content">
            <form>
                <div class="w-50">
                    <label>
                        <span>Test Input:</span>
                        <input type="text" name="test" placeholder="Input de Teste">
                    </label>
                </div>

                <div class="w-50">
                    <label>
                        <span>Test Input:</span>
                        <input type="text" name="test" placeholder="Input de Teste">
                    </label>
                </div>
                <div class="cleaner"></div>

                <div class="w-33">
                    <label>
                        <span>Test Input:</span>
                        <input type="text" name="test" placeholder="Input de Teste">
                    </label>
                </div>

                <div class="w-33">
                    <label>
                        <span>Test Input:</span>
                        <input type="text" name="test" placeholder="Input de Teste">
                    </label>
                </div>
                <div class="w-33">
                    <label>
                        <span>Test Input:</span>
                        <input type="text" name="test" placeholder="Input de Teste">
                    </label>
                </div>
                <div class="cleaner"></div>

            </form>
        </section>
    </section>

    <section class="block">
        <header>
            <div class="title">
                <span>Exemplo de Tabela</span>
            </div>
            <div class  ="actions">
                <a href="#" class="button light-red waves-effect" onclick="Selectable.action('select_test', 'delete');">excluir selecionados</a>
            </div>
            <div class="cleaner"></div>
        </header>


        <section class="content">
            <!--
            id              = Tabela para ser encontrada pelos botoes de ACTION do selectable
            data-action     = URL de destino da requisicao ajax
            data-columnref  = Coluna de referencia para mensagens de aviso, confirmarcao e etc.
            -->
            <table class="selectable" id="select_test" data-action="/painel/home" data-columnref="2">
                <thead>
                <tr>
                    <th></th>
                    <th>id</th>
                    <th>título</th>
                    <th>views</th>
                    <th>referência</th>
                    <th>comentários</th>
                    <th>categoria</th>
                    <th>autor</th>
                    <th>data</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; while ($i < 5): ?>
                <tr>
                    <td><?= $i+1; ?></td>
                    <td class="hasTooltip" data-tooltip-str="teste"><a href="#">#123</a></td>
                    <td>A cidade de Sao Paulo</td>
                    <td>1.347</td>
                    <td>Ame. do Sul - Brasil - Sao Paulo</td>
                    <td>37 - 12</td>
                    <td>Pontos Turisticos</td>
                    <td>Felipe Barreiros</td>
                    <td>24 - 09 - 1988</td>
                </tr>
                <?php $i++; endwhile; ?>
                </tbody>
            </table>

<!--            --><?//= $ctrl->firstFormPages; ?>
firstFormPAge
            <div style="height: 30px"></div>

            <table>
                <thead>
                <tr>
                    <th></th>
                    <th>id</th>
                    <th>título</th>
                    <th>views</th>
                    <th>referência</th>
                    <th>comentários</th>
                    <th>categoria</th>
                    <th>autor</th>
                    <th>data</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; while ($i < 5): ?>
                <tr>
                    <td><?= $i+1; ?></td>
                    <td><a href="#">#123</a></td>
                    <td>A cidade de Sao Paulo</td>
                    <td>1.347</td>
                    <td>Ame. do Sul - Brasil - Sao Paulo</td>
                    <td>37 - 12</td>
                    <td>Pontos Turisticos</td>
                    <td>Felipe Barreiros</td>
                    <td>24 - 09 - 1988</td>
                </tr>
                <?php $i++; endwhile; ?>
                </tbody>
            </table>
<!--            --><?//= $ctrl->secondFormPages; ?>
            SecondFormPage
        </section>
    </section>

    <section class="block">
        <header>
            <div class="title">
                <span>MultActions Example</span>
            </div>
            <div class="actions">
                <span class="button light-red"><a href="#">cancelar</a></span>
                <span class="button light-blue"><a href="#">editar</a></span>
            </div>
            <div class="cleaner"></div>
        </header>


        <section class="content">
            <?php $i = 0; while($i < 3): ?>
            <div class="w-33 inside">
                <form>
                    <div class="w-50">24 - 09 - 1988</div>
                    <div class="w-50">Por: <strong>Felipe Barreiros</strong></div>

                    <div class="w-100 ">
                        <ul class="multaction">
                            <li data-tooltip-str="Editar" class="hasTooltip flaticon-fountain-pen" onclick="window.location.href = '/painel/home'"><!-- edit --></li>
                            <li data-tooltip-str="Inativar" class="hasTooltip flaticon-warning" onclick="home.teste(137)"><!-- inactive --></li>
                            <li data-tooltip-str="Excluir" class="hasTooltip flaticon-rubbish-bin"><!-- delete --></li>
                            <li data-tooltip-str="Ativar" class="hasTooltip flaticon-checked"><!-- active --></li>
                            <li data-tooltip-str="Expandir" class="hasTooltip flaticon-expand"><!-- expand --></li>
                        </ul>
                    </div>

                    <input type="hidden" name="id" value="1033">
                    <div class="cleaner"></div>
                </form>
            </div>
            <?php $i++; endwhile; ?>

            <div class="cleaner"></div>

        </section>
    </section>

    <section class="block">
        <header>
            <div class="title">
                <span>Select Option Example</span>
            </div>
            <div class="actions">
                <span class="button light-red"><a href="#">cancelar</a></span>
                <span class="button light-blue"><a href="#">editar</a></span>
            </div>
            <div class="cleaner"></div>
        </header>


        <section class="content">
            <form>
                <div class="w-100">
                    <label>
                        <span>Test Input:</span>
                        <input type="text" name="test" placeholder="Input de Teste">
                    </label>
                </div>

                <div class="w-33">
                    <label>
                        <span>Continente</span>
                        <select>
                            <option>America do norte</option>
                            <option>America do Sul</option>
                        </select>
                    </label>
                </div>

                <div class="w-50">
                    <label>
                        <span>Multiselect</span>
                        <select data-placeholder="Choose a Country..." style="width:350px;" multiple tabindex="3">
                            <option value=""></option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antarctica">Antarctica</option>
                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                        </select>
                    </label>
                </div>
                <div class="cleaner"></div>

            </form>
        </section>
    </section>
@endsection
