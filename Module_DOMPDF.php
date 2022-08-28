<?php
namespace GDO\DOMPDF;

use GDO\Core\GDO_Module;
use Dompdf\Dompdf;
use GDO\Core\GDT_Checkbox;
use Dompdf\Options;
use GDO\Core\WithComposer;
use GDO\Core\GDT_Method;
use GDO\Core\Application;

/**
 * DOMPDF library wrapper.
 * Can convert HTML2PDF.
 * Provides GDT_PDF.
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 7.0.0
 * @see GDT_PDF
 */
final class Module_DOMPDF extends GDO_Module
{
	use WithComposer;
	
	public int $priority = 25;
	public string $license = 'LGPLv2.1';
	
	##############
	### Module ###
	##############
	public function getDependencies() : array
	{
		return ['File'];
	}
	
	public function getFriendencies() : array
	{
		return ['IMagick']; # @TODO create an IMagick module to speedup DOMPDF and Module_File variant recoder.
	}
	
	##############
	### Config ###
	##############
	public function getConfig() : array
	{
		return [
			GDT_Checkbox::make('allow_php_pdf')->initial('1'),
			GDT_Checkbox::make('allow_remote_pdf')->initial('0'),
		];
	}
	public function cfgAllowPHP() : bool { return $this->getConfigValue('allow_php_pdf'); }
	public function cfgAllowRemote() : bool { return $this->getConfigValue('allow_remote_pdf'); }
	
	##############
	### DOMPDF ###
	##############
	public function getDOMPDF()
	{
		$this->includeVendor();
		$options = new Options();
		$options->set('isPhpEnabled', $this->cfgAllowPHP());
		$options->set('isRemoteEnabled', $this->cfgAllowRemote());
		$dompdf = new Dompdf($options);
		return $dompdf;
	}
	
	/**
	 * Main PDF rendering call.
	 */
	public function renderHtmlAsPDF(string $html, string $size=GDT_PDF::A4, string $orientation=GDT_PDF::PORTRAIT) : string
	{
		$dompdf = $this->getDOMPDF();
		$dompdf->loadHtml($html);
		$dompdf->setPaper($size, $orientation);
		$dompdf->render();
		return $dompdf->output();
	}
	
	public function displayPdfString(string $pdf) : string
	{
		if (Application::instance()->isUnitTests())
		{
			return $pdf;
		}
		hdr('Content-Type: application/pdf');
		echo $pdf;
		die(0);
	}
	
	public function renderMethodAsPDF(GDT_Method $method)
	{
		return $this->renderHtmlAsPDF($method->renderHTML());
	}
	
	public function renderFileAsPDF(GDT_PDF $pdf)
	{
		
	}

}
