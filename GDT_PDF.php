<?php
namespace GDO\DOMPDF;

use GDO\Core\GDT_Template;
use GDO\Core\WithFields;
use GDO\File\GDO_File;
use GDO\File\GDT_File;
use GDO\UI\GDT_HTML;
use GDO\UI\WithDescription;
use GDO\UI\WithImage;
use GDO\UI\WithTitle;

/**
 * A PDF is a GDT_File with mime type and icon.
 * To generate PDFs, this GDT can be used as well. It has fields and it has an image for the logo.
 *
 * @version 7.0.0
 * @since 7.0.0
 * @author gizmore
 */
class GDT_PDF extends GDT_File
{

	#############
	### Const ###
	#############
	public const A4 = 'A4';
	public const PORTRAIT = 'portrait';
	public const LANDSCAPE = 'landscape';

	###########
	### GDT ###
	###########
	use WithImage;
	use WithTitle;
	use WithFields;
	use WithDescription;

	public string $size = self::A4;

	############
	### Size ###
	############
	public string $orientation = self::PORTRAIT;

	protected function __construct()
	{
		parent::__construct();
		$this->mime('application/pdf');
		$this->icon('pdf');
	}

	###################
	### Orientation ###
	###################

	public static function makeWithHTML(string $html)
	{
		return self::makeWith(GDT_HTML::make()->var($html));
	}

	public function size(string $size): self
	{
		$this->size = $size;
		return $this;
	}

	public function portrait(): self
	{
		return $this->orientation(self::PORTRAIT);
	}

	public function orientation(string $orientation): self
	{
		$this->orientation = $orientation;
		return $this;
	}

	############
	### File ###
	############

	public function landscape(): self
	{
		return $this->orientation(self::LANDSCAPE);
	}

	##############
	### Render ###
	##############

	public function toFile(string $filename = null): GDO_File
	{
		$filename = $filename ? $filename : ($this->renderTitle() . '.pdf');
		$content = $this->renderPDFFile();
		return GDO_File::fromString($filename, $content);
	}

	public function renderPDFFile(): string
	{
		$html = $this->renderPDFHTML();
		$pdf = Module_DOMPDF::instance()->renderHtmlAsPDF($html, $this->size, $this->orientation);
		return $pdf;
	}

	public function renderPDFHTML(): string
	{
		return GDT_Template::php('DOMPDF', 'pdf_html.php', ['field' => $this]);
	}

	###

	public function stream()
	{
		$html = $this->renderPDFHTML();
		$size = $this->size;
		$format = $this->orientation;
		$pdf = Module_DOMPDF::instance()->renderHtmlAsPDF($html, $size, $format);
		Module_DOMPDF::instance()->displayPdfString($pdf);
	}

}
