# Pdf-Text-Retriever

## Retrieve texts from PDF-Files

This library allows you to retrieve texts from PDF-files. Not only the complete 
fulltext but also texts contained within any rectangle on a page of a pdf-file.

## Installation:

THis library is best installed using [composer](https://getcomposer.org).

```bash
composer require org_heigl/pdftextretriever
```

## Requirements:

Currently this library depends on the [TET-Extension](https://www.pdflib.com/products/tet/). 

I'm working on a dependency-free version of the library but that requires some 
more free time. Any help there is much appreciated!!

## Usage:

Get the text from within a rectangle on a page.
```php
$parser = new \Org_Heigl\PdfTextRetriever\Parser\Tet(new \TET());
$list = $parser->parse(
            new SplFileInfo($pathToFile), 
            $page
        );

$retriever = new \Org_Heigl\PdfTextRetriever\CropRetriever($list);
$newList = $retriever->getGlyphsWithinRectangle(
               \Org\Heigl\Geo\Rectangle::factory($top, $left, $bottom, $right)
           );

$concatenator = new \Org_Heigl\PdfTextRetriever\Concatenator($newList);
$textFromRectangle = $concatenator->concatenate();
```




