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