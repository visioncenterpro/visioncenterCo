<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-06-10 07:16:21 --> 404 Page Not Found: Images/icons
User ---> Ivan Contreras ID (15) - ERROR - 2019-06-10 09:03:10 --> Severity: Notice --> Undefined variable: objPHPExcel C:\xampp\htdocs\VisionCenter\application\controllers\Production\Delivery\C_Delivery.php 697
User ---> Ivan Contreras ID (15) - ERROR - 2019-06-10 09:03:56 --> Severity: Notice --> Undefined variable: objPHPExcel C:\xampp\htdocs\VisionCenter\application\controllers\Production\Delivery\C_Delivery.php 697
User ---> Ivan Contreras ID (15) - ERROR - 2019-06-10 09:04:17 --> Severity: error --> Exception: Workbook already contains a worksheet named 'Worksheet'. Rename this worksheet first. C:\xampp\htdocs\VisionCenter\application\third_party\PHPExcel-1.8\Classes\PHPExcel.php 516
User ---> Ivan Contreras ID (15) - ERROR - 2019-06-10 09:22:30 --> Severity: Notice --> Undefined variable: objPHPExcel C:\xampp\htdocs\VisionCenter\application\controllers\Production\Delivery\C_Delivery.php 702
User ---> Ivan Contreras ID (15) - ERROR - 2019-06-10 17:16:07 --> Severity: Notice --> Undefined variable: objWorkSheet C:\xampp\htdocs\VisionCenter\application\controllers\Production\Delivery\C_Delivery.php 700
User ---> Ivan Contreras ID (15) - ERROR - 2019-06-10 17:18:27 --> Severity: Notice --> Undefined variable: delimiter C:\xampp\htdocs\VisionCenter\application\controllers\Production\Delivery\C_Delivery.php 713
User ---> Ivan Contreras ID (15) - ERROR - 2019-06-10 17:18:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ') GROUP BY AO.id_supplies' at line 1 - Invalid query: SELECT A.`order`,AO.*, SUM(AO.quantity_packaged) as total FROM access_order_package_supplies A  INNER JOIN access_order_package_supplies_detail AO ON  A.id_order_package_supplies = AO.access_order_package_supplies  WHERE A.`order` IN () GROUP BY AO.id_supplies
