<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/css/user.css', 'resources/css/room.css', 'resources/css/messages.css', 'resources/js/app.js'])
</head>
<body>
    @yield('body')
    <script>
        function toggleMenu(roomId) {
            const menu = document.getElementById('menu-' + roomId);
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.room-menu')) {
                document.querySelectorAll('.room-menu-dropdown').forEach(el => el.style.display = 'none');
            }
        });
    </script>
</body>
</html>
