 <section id="menu-sidebar">
        <div class="user-info">
            <div class="foto" style="background: #000"></div>
            <div class="info">Bem vindo, <a href="#">{{ Auth::user()->name }}</a></div>
        </div>

        <div class="menu scrollbar-inner">
            <ul>
                <li class="modulo">
                    <span>
                        <span class="flaticon-arrow"></span>
                        <a class="menu-item-text" href="/painel">Home</a>
                    </span>
                </li>

                <li class="modulo">
                    <span class="has-submenu">
                        <span class="flaticon-terminal"></span>
                        <span class="menu-item-text">Sistema</span>
                    </span>
                    <ul>
                        <li><a href="#"><span class="flaticon-avatar"></span>Usuarios</a></li>
                        <li>
                            <span class="has-submenu"><span class="flaticon-technology-1"></span>Developer</span>
                            <ul>
                                <li><a href="#">Documentação</a></li>
                                <li><a href="#">Disparo de e-mails</a></li>
                                <li><a href="#">Sistema em Manutenção</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="modulo">
                    <span>
                        <span class="flaticon-puzzle"></span>
                        <span class="menu-item-text"><a href="/painel/mundo/paises">Estrutura</a></span>
                    </span>
                </li>

                <li class="modulo">
                    <span class="has-submenu"><span class="flaticon-interface"></span>
                        <span class="menu-item-text">Blog</span>
                    </span>
                    <ul>
                        <li><a href="/painel/blog/post"><span class="flaticon-feather-pen"></span>Novo Post</a></li>
                        <li><a href="/painel/blog/posts"><span class="flaticon-feather-pen"></span>Posts</a></li>
                        <li><a href="/painel/blog/posts"><span class="flaticon-feather-pen"></span>Autores</a></li>
                    </ul>
                </li>

                <li class="modulo">
                    <span class="has-submenu"><span class="flaticon-shop"></span>
                        <span class="menu-item-text">Serviços</span>
                    </span>
                    <ul>
                        <li><a href="/painel/servicos/servico"><span class="flaticon-shop"></span>Novo Serviço</a></li>
                        <li><a href="/painel/servicos"><span class="flaticon-shop"></span>Serviços</a></li>
                    </ul>
                </li>

                <li class="modulo">
                    <span class="has-submenu"><span class="flaticon-shop"></span>
                        <span class="menu-item-text">Interesses</span>
                    </span>
                    <ul>
                        <li><a href="/painel/servicos/servico"><span class="flaticon-shop"></span>Novo Interesse</a></li>
                        <li><a href="/painel/servicos"><span class="flaticon-shop"></span>Interesses</a></li>
                    </ul>
                </li>

                <li class="modulo">
                    <span>
                        <span class="flaticon-arrow"></span>
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