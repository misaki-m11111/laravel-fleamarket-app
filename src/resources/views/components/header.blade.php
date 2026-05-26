<header class="header">
    <div class="header__inner">
        <a href="/" class="header__logo">
            <img src="{{ asset('images/logos/logo.png') }}" alt="COACHTECH">
        </a>

        @unless (request()->is('login') || request()->is('register'))
            <form action="/" method="GET" class="header__search">
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">
            </form>

            <nav class="header__nav">
                @auth
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="header__button">ログアウト</button>
                    </form>

                    <a href="/mypage" class="header__link">マイページ</a>
                    <a href="/sell" class="header__sell">出品</a>
                @else
                    <a href="/login" class="header__link">ログイン</a>
                    <a href="/mypage" class="header__link">マイページ</a>
                    <a href="/sell" class="header__sell">出品</a>
                @endauth
            </nav>
        @endunless
    </div>
</header>
