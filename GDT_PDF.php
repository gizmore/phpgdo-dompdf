<?php
namespace GDO\DOMPDF;

use GDO\File\GDT_File;
use GDO\Core\GDT_Template;
use GDO\Core\WithFields;
use GDO\UI\WithImage;
use GDO\UI\WithTitle;
use GDO\UI\WithDescription;
use GDO\File\GDO_File;
use GDO\UI\GDT_HTML;

/**
 * A PDF is a GDT_File with mime type and icon.
 * To generate PDFs, this GDT can be used as well. It has fields and it has an image for the logo.
 * 
 * @author gizmore
 * @version 7.0.0
 * @since 7.0.0
 */
class GDT_PDF extends GDT_File
{
	#############
	### Const ###
	#############
	const A4 = 'A4';
	const PORTRAIT = 'portrait';
	const LANDSCAPE = 'landscape';

	###########
	### GDT ###
	###########
	use WithImage;
	use WithTitle;
	use WithFields;
	use WithDescription;

	protected function __construct()
	{
		parent::__construct();
		$this->mime('application/pdf');
		$this->icon('pdf');
	}
	
	############
	### Size ###
	############
	public string $size = self::A4;
	public function size(string $size): static
	{
		$this->size = $size;
		return $this;
	}
	
	###################
	### Orientation ###
	###################
	public string $orientation = self::PORTRAIT;
	public function orientation(string $orientation): static
	{
		$this->orientation = $orientation;
		return $this;
	}
	public function portrait(): static
	{
		return $this->orientation(self::PORTRAIT);
	}
	public function landscape(): static
	{
		return $this->orientation(self::LANDSCAPE);
	}
	
	############
	### File ###
	############
	public function toFile(string $filename=null) : GDO_File
	{
		$filename = $filename ? $filename : ($this->renderTitle().'.pdf');
		$content = $this->renderPDFFile();
		return GDO_File::fromString($filename, $content);
	}
	
	##############
	### Render ###
	##############
	public function renderPDFFile() : string
	{
		$html = $this->renderPDFHTML();
		$pdf = Module_DOMPDF::instance()->renderHtmlAsPDF($html, $this->size, $this->orientation);
		return $pdf;
	}

	public function renderPDFHTML() : string
	{
		return GDT_Template::php('DOMPDF', 'pdf_html.php', ['field' => $this]);
	}
	
	public function stream()
	{
		$html = $this->renderPDFHTML();
		$size = $this->size;
		$format = $this->orientation;
		$pdf = Module_DOMPDF::instance()->renderHtmlAsPDF($html, $size, $format);
		Module_DOMPDF::instance()->displayPdfString($pdf);
	}
	
	###
	
	public static function makeWithHTML(string $html)
	{
		return self::makeWith(GDT_HTML::make()->var($html));
	}

}
