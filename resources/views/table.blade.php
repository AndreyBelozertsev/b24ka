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
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <main>
            <section class="container">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <div>
                                <p>Сафаров Каюмарс</p>
                            </div>
                            <table
                            class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <thead
                                class="border-b border-neutral-200 bg-white font-medium dark:border-white/10 dark:bg-body-dark">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Показатель</th>
                                    <th scope="col" class="px-6 py-4">Результат</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                class="border-b border-neutral-200 bg-black/[0.02] dark:border-white/10">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">План по продажам</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ number_format('3500000', 0, '', ' ') }}</td>
                                </tr>
                                <tr
                                class="border-b border-neutral-200 bg-white dark:border-white/10 dark:bg-body-dark">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">2</td>
                                    <td class="whitespace-nowrap px-6 py-4">Jacob</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
