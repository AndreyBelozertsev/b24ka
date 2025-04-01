<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/app.css">
	<script
		src="https://code.jquery.com/jquery-3.6.0.js"
		integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
		crossorigin="anonymous"></script>

	<title>B24PhpSDK local-app demo</title>
</head>
<body class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <h2>Онлайн расчет заработной платы</h2>
            <?php 
            $users = [];
            $user = $B24->core->call('user.current')->getResponseData()->getResult();
            print_r($user);
            echo "<pre>";
            print_r($user['UF_DEPARTMENT']);
           // print_r($deals);

            echo "</pre>";
           if( isset($user['UF_DEPARTMENT']) && in_array([11, 13, 355, 349] , ) ) {
                $users = $B24->getUserScope()->get([], ['UF_DEPARTMENT' => 341]);
            }
            print_r($users);

            $args_success = [
                //'ASSIGNED_BY_ID' => $user['ID'],
                'ASSIGNED_BY_ID' => '49723',
                'STAGE_ID' => 'WON',
                'CATEGORY_ID' => 0,
                '>=CLOSEDATE' => $monthStart
            ];

            $args_receive = [
                //'ASSIGNED_BY_ID' => $user['ID'],
                'ASSIGNED_BY_ID' => '49723',
                '!@STAGE_ID' => ['5','6','7','16','17'],
                'CATEGORY_ID' => 0,
                '>=DATE_CREATE' => $monthStart
            ];
            $select = ['ID','TITLE', 'OPPORTUNITY','STAGE_ID'];
            //$select = [];
            $deal_receive = 0; 
            $deal_success = 0;   
            $summ_receive = 0;
            $summ = 0; 
            foreach($B24->getCRMScope()->deal()->batch->list(['ID' => 'ASC'],$args_receive,$select,10000) as $deal){
                $summ_receive += $deal->OPPORTUNITY;
                $deal_receive++;
            }
            foreach($B24->getCRMScope()->deal()->batch->list([],$args_success,$select,10000) as $deal){
                $summ_success += $deal->OPPORTUNITY;
                $deal_success++;
                // echo $deal->TITLE . ' - ' . $deal->OPPORTUNITY . "</br>";
            }
            echo "Кол-во полученных сделок: " . $deal_receive . "</br>";
            echo "Сумма полученных сделок: " . $summ_receive . "</br>";
            echo "Кол-во продаж: " . $deal_success . "</br>";
            echo "Сумма продаж: " . $summ_success . "</br>";
            echo "Конверсия: " . ($deal_success/$deal_receive)*100 . "</br>";
            ?>
            
            <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Amount</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            </table>

        </div>
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

