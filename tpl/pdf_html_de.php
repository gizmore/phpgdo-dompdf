<?php
namespace GDO\DOMPDF\tpl;
use GDO\DOMPDF\GDT_PDF;
use GDO\Core\GDT;
/** @var $field GDT_PDF **/
?>
<!DOCTYPE html>
<html>
 <head>
  <title><?=$field->renderTitle()?></title>
 </head>
 <body>
  <?=$field->renderMode(GDT::RENDER_PDF)?>
  <h6>Gerendert von Fineprint</h6>
  <footer>
<script type="text/php">
if (isset($pdf)) {
$text2 = "Seite 100 / 200";
$text = "Seite {PAGE_NUM} / {PAGE_COUNT}";
$date = \GDO\Date\Time::displayDate(date('Y-m-d H:i:s.v'));
$size = 9;
$font = $fontMetrics->getFont("Arial, Helvetica, sans-serif");
$width = $fontMetrics->get_text_width($text2, $font, $size);
$x = ($pdf->get_width() - $width);
$y = $pdf->get_height() - 17;
$pdf->page_text($x, $y, $text, $font, $size);
$pdf->page_text(20, $y, "Stand vom " . $date, $font, $size);
}
</script>
    </footer>
 </body>
</html>
