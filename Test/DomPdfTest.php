<?php
namespace GDO\DOMPDF\Test;

use GDO\Core\GDO_Module;
use GDO\DOMPDF\Module_DOMPDF;
use GDO\Tests\TestCase;
use function PHPUnit\Framework\assertStringContainsString;
use function PHPUnit\Framework\assertTrue;

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
		$module->includeVendor();
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
