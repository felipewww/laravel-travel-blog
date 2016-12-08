 <section id="menu-sidebar">
        <div class="user-info">
            <div class="foto" style="background: #000"></div>
            <div class="info">Bem vindo, <a href="#">{{ Auth::user()->name }}</a></div>
        </div>

        <div class="menu">
            <ul>
                <li class="modulo">
                    <span class="has-submenu"><span class="flaticon-terminal"></span>Sistema</span>
                    <ul>
                        <li><a href="#"><span class="flaticon-avatar"></span>Usuarios</a></li>
                        <li>
                            <span class="has-submenu"><span class="flaticon-technology-1"></span>Robots</span>
                            <ul>
                                <li>
                                    <span><span class="flaticon-paper-plane"></span>Disparo de e-mails</span>
                                    <ul>
                                        <li><a href="#">E-mail de Cadastro</a></li>
                                        <li><a href="#">E-mail de Cobrança</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Sistema em Manutenção</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="modulo">
                    <span class="has-submenu"><span class="flaticon-puzzle"></span>Estrutura</span>
                    <ul>
                        <li><a href="/painel/estrutura/Cidades"><span class="flaticon-city"></span>Cidades</a></li>
                        <li><a href="/painel/estrutura/interesses"><span class="flaticon-star"></span>Interesses</a></li>
                    </ul>
                </li>

                <li class="modulo">
                    <span class="has-submenu"><span class="flaticon-interface"></span>Blog</span>
                    <ul>
                        <li><a href="/painel/blog/posts"><span class="flaticon-feather-pen"></span>Posts</a></li>
                        <li><a href="/painel/blog/post"><span class="flaticon-feather-pen"></span>Novo Post</a></li>
                    </ul>
                </li>

                <li class="modulo">
                    <span class="has-submenu"><span class="flaticon-shop"></span>Serviços</span>
                    <ul>
                        <li><a href="/painel/servicos"><span class="flaticon-shop"></span>Serviços</a></li>
                        <li><a href="/painel/servicos/servico"><span class="flaticon-shop"></span>Novo Serviços</a></li>
                    </ul>
                </li>

                <li class="modulo">
                    <span>
                        <span class="flaticon-shop"></span>
                        <a href="{{ url('/painel/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sair
                        </a>
                        <form id="logout-form" action="{{ url('/painel/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </span>
                </li>
            </ul>
        </div>
    </section>