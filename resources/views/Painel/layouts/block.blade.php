<section class="block">
    <header>
        <div class="title">
            <span>@yield('blockTitle')</span>
        </div>
        <div class="actions">
            @yield('selectedActions')
        </div>
        <div class="cleaner"></div>
    </header>

    <section class="content">
        @yield('blockContent')
    </section>
</section>