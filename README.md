# phpgdo-dompdf

DOMPDF library wrapper for GDOv7.
The first or second module using composer, which is discouraged.

## Installation

[Install](https://github.com/gizmore/phpgdo/blob/main/DOCS/GDO7_INSTALLATION.md) like any GDOv7 module.
Do not forget to run post install hooks.


## Usage

This module allows to renderHTML() or renderTemplate().

    $pdf1 = Module_DOMPDF::instance()->renderHtmlAsPDF("<body>hello world!</body>");
    $pdf2 = Module_DOMPDF::instance()->renderTemplateAsPDF($gdt_template);
    Module_DOMPDF::instance()->outputPDF($pdf2);
