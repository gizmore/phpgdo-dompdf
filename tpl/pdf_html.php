<?php
namespace GDO\DOMPDF\tpl;
use GDO\DOMPDF\GDT_PDF;
/** @var $field GDT_PDF **/
?>
<!DOCTYPE html>
<html>
 <head>
  <title><?=$field->renderTitle()?></title>
 </head>
 <body>
  <?=$field->renderPDF()?>
 </body>
</html>
