<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])

	<title>Расчет вознаграждения за продажи</title>
</head>


<body class="bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Расчет вознаграждения за продажи</h1>
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Период - {{ $period}}</h2>
        @foreach ($users as $user)
            <div class="mb-10">
                <div class="mb-6">
                    <p class="text-lg text-gray-600">ФИО сотрудника: <span class="font-medium text-gray-800">{{ $user['name'] }}</span></p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b text-left text-gray-700 font-medium">Наименование</th>
                                <th class="py-2 px-4 border-b text-left text-gray-700 font-medium">Результат</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-gray-600">План по продажам</td>
                                <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ number_format($user['plan'], 0, '', ' ') }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-gray-600">
                                    Ставка
                                    <p class="text-sm text-gray-400">Выплачивается при условии отработки всех дней</p>
                                </td>
                                <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ number_format($user['salary'], 0, '', ' ') }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-gray-600">Получено лидов за период (шт)</td>
                                <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ $user['deal_receive'] }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-gray-600">Получено лидов за период (руб)</td>
                                <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ number_format($user['summ_receive'], 0, '', ' ') }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-gray-600">Продаж за период (шт)</td>
                                <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ $user['deal_success'] }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-gray-600">Продаж за период (руб)</td>
                                <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ number_format($user['summ_success'], 0, '', ' ') }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-gray-600">% выполнения плана</td>
                                <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ round($user['plan_percent'], 2) }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-gray-600">% конверсии</td>
                                <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ round($user['conversion'], 2) }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-gray-600">Расчет премиальной части</td>
                                <td class="py-2 px-4 border-b text-gray-800 font-medium">
                                    @foreach ($user['sallary_count']['calculation_details'] as $detail)
                                        <p>{{ $detail }}</p>
                                    @endforeach
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-gray-600">Сумма премиальной части</td>
                                <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ $user['sallary_count']['salary'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b text-gray-600">Всего получено лидов</td>
                        <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ $total_deal_receive }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b text-gray-600">Всего продаж (шт)</td>
                        <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ number_format($total_deal_success, 0, '', ' ') }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b text-gray-600">Всего продаж (руб)</td>
                        <td class="py-2 px-4 border-b text-gray-800 font-medium">{{ number_format($total_summ, 0, '', ' ') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
    <script src="//api.bitrix24.com/api/v1/"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            BX24.init(function () {
                console.log('bx24.js initialized', BX24.isAdmin());
            });
        });
    </script>
</body>
</html>