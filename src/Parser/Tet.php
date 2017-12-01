<?php
/**
 * Copyright (c) Andreas Heigl<andreas@heigl.org>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright Andreas Heigl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT-License
 * @since     30.11.2017
 * @link      http://github.com/heiglandreas/org.heigl.PdfTextRetriever
 */

namespace Org_Heigl\PdfTextRetriever\Parser;

use Org\Heigl\Geo\Dimension;
use Org\Heigl\Geo\Point;
use Org_Heigl\PdfTextRetriever\Exception\UnableToOpenFile;
use Org_Heigl\PdfTextRetriever\GlyphList;
use Org_Heigl\PdfTextRetriever\Object\Glyph;
use Org_Heigl\PdfTextRetriever\ParserInterface;
use Org_Heigl\PdfTextRetriever\TextContent;
use SplFileInfo;
use TET as PDFlibTet;

class Tet implements ParserInterface
{
    private $tet;

    public function __construct(PDFlibTet $tet)
    {
        $this->tet = $tet;
    }

    public function parse(SplFileInfo $pdf, int $page = null): GlyphList
    {
        $doc = $this->tet->open_document($pdf->getPathname(), '');

        if (-1 === $doc) {
            throw new UnableToOpenFile($pdf->getPathname());
        }

        $list = new GlyphList();

        $pageHandle = $this->tet->open_page($doc, $page, 'granularity=glyph');

        while($text = $this->tet->get_text($pageHandle)) {
            while ($result = $this->tet->get_char_info($pageHandle)) {
                $list->append(new Glyph(
                    $text,
                    $result->fontid,
                    $result->fontsize,
                    Point::factory($result->x, $result->y),
                    new Dimension($result->width, $result->height),
                    $result->alpha,
                    $result->colorid
                ));
            }
        }

        $this->tet->close_page($pageHandle);

        $this->tet->close_document($doc);

        return $list;
    }
}
