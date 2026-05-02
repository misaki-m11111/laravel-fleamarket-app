<header class="header">
    <div class="header__inner">
        <a href="/" class="header__logo">
            <img src="{{ asset('images/logo.png') }}" alt="COACHTECH">
        </a>

        @unless(request()->is('login') || request()->is('register'))
            <form action="/" method="GET" class="header__search">
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="なにをお探しですか？"
                >
            </form>

            <nav class="header__nav">
                @auth
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit">ログアウト</button>
                    </form>

                    <a href="/mypage">マイページ</a>
                    <a href="/sell" class="header__sell">出品</a>
                @else
                    <a href="/login">ログイン</a>
                    <a href="/sell">出品</a>
                @endauth
            </nav>
        @endunless
    </div>
</header>