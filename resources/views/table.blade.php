<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Заголовок страницы -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Расчет заработной платы</h1>
        
        <!-- Подзаголовок "Период" -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Период</h2>
        
        <!-- ФИО сотрудника -->
        <div class="mb-6">
            <p class="text-lg text-gray-600">ФИО сотрудника: <span class="font-medium text-gray-800">Иванов Иван Иванович</span></p>
        </div>
        
        <!-- Таблица с расчетами -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border-b text-left text-gray-700 font-medium">Наименование</th>
                        <th class="py-2 px-4 border-b text-left text-gray-700 font-medium">Результат</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Строка 1 -->
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b text-gray-600">План по продажам</td>
                        <td class="py-2 px-4 border-b text-gray-800 font-medium">3 500 000</td>
                    </tr>
                    <!-- Строка 2 -->
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b text-gray-600">Факт продаж</td>
                        <td class="py-2 px-4 border-b text-gray-800 font-medium">2 500 000</td>
                    </tr>
                    <!-- Строка 3 -->
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b text-gray-600">План по конверсии</td>
                        <td class="py-2 px-4 border-b text-gray-800 font-medium">40%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
