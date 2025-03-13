<?php
/*     fisrt 10 hour fixed 
bus truck genset   200 /40 (per hour) 
Cars regular        60/10 (per hour)
Cars tenants        40/10 (per hour)
Cars senior pwd     40/10 (per hour)
Cars pasay          0/0 (per hour)

Mot regular         30/0 (per hour)
Mot tenants         20/0 (per hour)
Mot senior pwd      20/0 (per hour)
Mot pasay           0/0 (per hour)

Loss bus class3         600/0 (per day)
Loss car regular        300/0 (per day)
Loss car senior pwd     200/0 (per day)
Loss mot regular        200/0 (per day)
Loss mot senior pwd     140/0 (per day)

reserved car pass       150/0 (per day)

comp car pass           0/0 (per day)
drop off                0/0 (per hour)
*/
$OR_NUMBER=1000000;
$PICC_rate= array(
			'cars regular'=> array( 2, 1, 53.57, 6.43,60, 1),
			'mot regular'=> array(1, 1, 26.79, 3.21, 30, 1),
			'BUS/truck'=> array(3, 1, 178.57, 21.43, 200, 1),
			'cars tenants'=> array(2, 1, 35.71, 4.29, 40, 1),
			'cars senior_pwd'=> array( 2, 1, 40, 0, 40, 1),
			'cars pasay'=> array( 2, 1, 0, 0, 0, 1),
			'mot tenants'=> array( 1, 1, 17.86, 2.14, 20, 1),
			'mot senior_pwd'=> array( 1, 1, 20, 0, 0, 1),
			'mot pasay'=> array( 1, 1, 0, 0, 0, 1),
			'loss class3'=> array( 3, 1, 535.71, 64.29, 600, 1),
			'loss regular_car'=> array( 2, 1, 267.86, 32.14, 300, 1),
			'loss senior_car'=> array( 2, 1, 200, 0, 0, 1),
			'loss regular_mot'=> array( 1, 1, 178.57, 21.43, 200, 1),
			'loss senior_mot'=> array( 1, 1, 140, 0, 0, 1),
			'over class3'=> array( 3, 1, 357.14, 42.86, 400, 1),
			'over regular_car'=> array( 2, 1, 178.57, 21.43, 200, 1),
			'over tenant_car'=> array( 2, 1, 160.71, 19.29, 180, 1),
			'over senior_car'=> array( 2, 1, 140, 0, 0, 1),
			'over regular_mot'=> array( 1, 1, 89.29, 10.71, 100, 1),
			'over tenant_mot'=> array( 1, 1, 71.43, 8.27, 80, 1),
			'over senior_mot'=> array( 1, 1, 70, 0, 0, 1),
			'reserve car pass'=> array( 2, 1, 133.93, 16.07, 150, 1),
			'comp car pass'=> array( 2, 1, 0, 0, 0, 1)
		   );

?>