<?php
namespace GDO\DOMPDF\Test;

use GDO\Tests\TestCase;
use function PHPUnit\Framework\assertTrue;
use GDO\DOMPDF\Module_DOMPDF;
use GDO\Core\GDO_Module;
use function PHPUnit\Framework\assertStringContainsString;

/**
 * Test DOMPDF library integration.
 * 
 * @author gizmore
 */
final class DomPdfTest extends TestCase
{
	public function testInclude()
	{
		$module = Module_DOMPDF::instance();
		assertTrue($module instanceof GDO_Module);
		$module->includeDOMPDF();
	}
	
	public function testHelloWorld()
	{
		$module = Module_DOMPDF::instance();
		$html = <<<EOT
<!DOCTYPE html>
<html>
<body>
Hello PDF World!
</body>
</html>
EOT;
		$pdf = $module->renderHtmlAsPDF($html);
		assertStringContainsString('startxref', $pdf, 'Test if basic html can be rendered as PDF.');
	}
	
}
