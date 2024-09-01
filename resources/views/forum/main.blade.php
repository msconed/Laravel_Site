<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes.head')
@csrf
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg" />
        <div
            class="relative min-h-screen flex flex-col items-center selection:bg-[#FF2D20] selection:text-white">
            
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    @include('includes.header')


                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
                        <div id="docs-card"
                            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">


                            <div class="relative flex items-center gap-6 lg:items-end">
                                    <div class="pt-3 sm:pt-5 lg:pt-0">
                                        @foreach ($arr as $categories)
                                            <h2 class="text-xl font-semibold text-black dark:text-white">{{ $categories[0]['name'] }}</h2>
                                            <p class="mt-4 text-sm/relaxed">
                                                @foreach ($categories[1] as $subCategories)
                                                    <p><a href="/forum/{{$categories[0]['category_id']}}/{{$subCategories['sub_category_id']}}">{{ $subCategories['name'] }}</a> </p>
                                                    <p style="margin-left: 50px;">{{ $subCategories['description'] }} </p>
                                                    <hr>
                                                @endforeach                                                              
                                        @endforeach
                                        </p>
                                    </div>
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function closeModal()
        {

            const modal = document.getElementById('modal'); if (modal) { modal.remove(); }
        }

        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }


        
    document.addEventListener('mousemove', function(event) {
        var rect = document.getElementById('proflie-menu').getBoundingClientRect();
        var toggleMenu = document.getElementById('proflie-menu');
        var profileIcon = document.getElementById('proflie-icon');

        
        // Рассчитываем расстояние до границ элемента toggleMenu
        var distanceTop = event.clientY - rect.top;
        var distanceBottom = rect.bottom - event.clientY;
        var distanceLeft = event.clientX - rect.left;
        var distanceRight = rect.right - event.clientX;

        // Находим расстояние
        var minDistanceMenu = Math.min(distanceTop, distanceBottom, distanceLeft, distanceRight);
        //

        // Рассчитываем расстояние до границ элемента toggleMenu
        var distanceTop = event.clientY - rect.top;
        var distanceBottom = rect.bottom - event.clientY;
        var distanceLeft = event.clientX - rect.left;
        var distanceRight = rect.right - event.clientX;

        // Находим расстояние
        var minDistanceIcon = Math.min(distanceTop, distanceBottom, distanceLeft, distanceRight);


        if (minDistanceMenu < -80 && toggleMenu.classList.contains('active'))
        {     
            toggleMenu.classList.toggle("active");
        }
        

    });
        
</script>
</body>

</html>