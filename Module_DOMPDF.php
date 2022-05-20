<?php
namespace GDO\DOMPDF;

use GDO\Core\GDO_Module;
use GDO\Core\GDT_Template;

/**
 * DOMPDF library wrapper.
 * 
 * @author gizmore
 * @version 7.0.0
 * @since 7.0.0
 */
final class Module_DOMPDF extends GDO_Module
{
	public int $priority = 40;
	public string $license = 'LGPLv2.1';
	
	public function thirdPartyFolders() : array { return ['/vendor/']; }
	
	public function includeDOMPDF() : void
	{
		$path = $this->filePath('vendor/autoload.php');
		if (is_file($path))
		{
			require_once $path;
		}
	}
	
	public function renderTemplateAsPDF(GDT_Template $template)
	{
		$html = $template->renderHTML();
		return $this->renderStringAsPDF($html);
	}
	
	public function renderHtmlAsPDF(string $html)
	{
		
	}
	
}
