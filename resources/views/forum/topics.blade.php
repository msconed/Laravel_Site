<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<?php use App\Http\Controllers\forumController; ?>
@include('includes.head')
@csrf
<body class="font-sans antialiased dark:bg-black dark:text-white/50">

    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">

        <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg" />
        <div class="relative min-h-screen flex flex-col items-center selection:bg-[#FF2D20] selection:text-white">

            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                @include('includes.header')


        <main class="mt-6">
            <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
                <div id="docs-card" class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                    <div class="forum-path">
                            <div><a href="/forum">Форум</a> > <a href="/forum">{{$categoryName}}</a> > <a href="{{$path}}">{{$SubCategoryName}}</a></div>
                            <div><button class="btun-v"
                                    hx-post="{{ url('new_topic') }}"
                                    hx-target="body"
                                    hx-swap="beforeend" 
                                    hx-vals='{"SubCategoryName": "{{$SubCategoryName}}", "categoryName": "{{$categoryName}}", "path2": {{$path2}}}'
                                    hx-include="[name='_token']"
                                    hx-on::before-request="closeModal()">
                            
                            Новый топик</button></div>
                    </div>

                                @foreach ($arr as $topic)
                                <div class="topics-container">
                                    <div class="topics-row">
                                    <a class="topics-url" href="/forum/{{$topic['category_id']}}/{{$topic['sub_category_id']}}/{{$topic['topic_id']}}">{{ $topic['header'] }}</a>
                                    
                                    <p class="topics-creator" >Автор: {{ forumController::getAuthorNameByID($topic['creator_id']) }}
                                    </div>
                                    <div class="topics-row"></div> <!--ToDo Статистика -->
                                    <div class="topics-row"></div> <!--ToDo последнее сообщение -->
                                    
                                </div>
                                
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>
        </main>

        @include('includes.footer')
    </div>
    </div>
    </div>
    <div id="toasts" style="position: fixed; z-index: 9999; inset: 16px; pointer-events: none;"></div>
    @include('includes.body_scripts')
</body>

</html>