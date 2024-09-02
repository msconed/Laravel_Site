<header class="items-center gap-2 py-10">
    <div class="logo">
        <!-- <img src="https://lh3.googleusercontent.com/proxy/ZojNT7Ked2afYGWgWEO5-JMhlEawhK3_tUiT0-Xoc_pJOMXJexlXpcLRwz7C2k897PAn2pvNXVeSPm6-qI8Bx04Srm6hzm5KsiC3SmqdVuLD6eER1m8"
            width=100px height=auto> -->
            LOGO
            
    </div>

    
    <nav>
        <ul class="nav-links">
            
            <li>
                
                @if (Auth::check())
                    <li ><a href="{{ url('/') }}">{{ __('messages.homePage') }}</a></li>
                    <li ><a href="{{ url('/forum') }}">{{ __('messages.headerForum') }}</a></li>
            
                @endif
                    @if (session('language') == 'ru')
                        <li ><a href="{{ url('/change-locale-to-en') }}">EN</a></li>
                    @else
                        <li ><a href="{{ url('/change-locale-to-ru') }}">RU</a></li>
                    @endif
                    

                <div class="action">
                    <div class="profile" _="on click toggle .active on #proflie-menu" id="profile-icon">
                        <img src="/assets/images/user.jpg" /><a href="#">{{ __('messages.Profile') }}</a>
                    </div>
                    
                    <div class="menu" id="proflie-menu">

                        <h3>{{ Auth::user()->name ?? '' }}<br /><span>{{ Auth::user()->email ?? '' }}</span></h3>                        
                        <ul>
                            
                        @if (Auth::check())

                                <li><img src="/assets/svg/user_full.svg" /><a href="#">{{ __('messages.Profile') }}</a></li>
                                <li><img src="/assets/svg/user_edit.svg" /><a href="#">{{ __('messages.EditProfile') }}</a></li>
                                <li><img src="/assets/svg/user_settings.svg" /><a href="#">{{ __('messages.Settings') }}</a></li>
                                <li><img src="/assets/svg/user_remove.svg" />
                                <button class="btn-auth no-select" 
                                        hx-post="{{ url('logout') }}"
                                        hx-include="[name='_token']">
                                        <span>{{ __('messages.Logout') }}</span>
                                </button></li>
                            @else 
                            <li><img src="/assets/svg/user_add.svg" />
                               <button class="btn-auth no-select" 
                                    hx-post="{{ url('login-modal') }}"
                                    hx-target="body"
                                    hx-swap="beforeend" 
                                    hx-include="[name='_token']"
                                    hx-on::before-request="closeModal()">
                                    <span>{{ __('messages.Auth') }}</span>
                                </button></li>
                                <li><img src="/assets/svg/user_add.svg" />
                               <button class="btn-auth no-select" 
                                    hx-post="{{ url('signup-modal') }}"
                                    hx-target="body"
                                    hx-swap="beforeend" 
                                    hx-include="[name='_token']"
                                    hx-on::before-request="closeModal()">
                                    <span>{{ __('messages.Signup') }}</span>
                                </button></li>
                            @endif

                        </ul>
                    </div>
                </div>
            </l>
        </ul>

    </nav>


</header>