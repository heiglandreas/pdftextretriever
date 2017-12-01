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

namespace Org_Heigl\PdfTextRetriever;

use Org\Heigl\Geo\Dimension;
use Org\Heigl\Geo\Point;
use Org_Heigl\PdfTextRetriever\Object\Glyph;

class TextObjectParser
{
    private $fontMap;

    public function __construct(FontWidthMap $fontMap)
    {
        $this->fontMap = $fontMap;
    }

    public function parse(string $textObject) : GlyphList
    {
        $list = new GlyphList();

        if (! preg_match('/(\[.*?\]|\(.*?\))\sTj/is', $textObject, $streamResult)) {
            return $list;
        }

        if (! preg_match('/\/([^\s]+)\s+(\d+)\s+Tf/is', $textObject, $fontResult)) {
            return $list;
        }

        $matrix = null;
        if (preg_match('/([\d\.]+)\s+([\d\.]+)\s+Td/is', $textObject, $coordinateResult)) {
            $matrix = [1, 0, 0, 1, $coordinateResult[1], $coordinateResult[2]];
        }
        if (preg_match('/([\d\.]+)\s+([\d\.]+)\s+([\d\.]+)\s+([\d\.]+)\s+([\d\.]+)\s+([\d\.]+)\s+Tm/is', $textObject, $coordinateResult)) {
            $matrix = [
                $coordinateResult[1],
                $coordinateResult[2],
                $coordinateResult[3],
                $coordinateResult[4],
                $coordinateResult[5],
                $coordinateResult[6],
            ];
        }
        if (null === $matrix) {
            return $list;
        }

        $font = $fontResult[1];
        $size = $fontResult[2];


        if (0 === strpos($streamResult[1], '[')) {
            $streamResult[1] = trim(substr($streamResult[1], 1, strlen($streamResult[1]) - 2));
        }

        foreach (explode(') ', $streamResult[1]) as $item) {

            if (false === strpos($item, ' (')) {
                $item = '0 (' . $item;
            }

            list($offset, $chars) = explode(' (', $item);

            $length = mb_strlen($chars);
            $off = 0.0;
            for ($i = 0; $i < $length; $i++) {
                $char = mb_substr($chars, $i, 1);
                $off = $off + 0.001 * $offset;
                $offX = $matrix[0] * $off + $matrix[2] * $off + $matrix[4];
                $offY = $matrix[1] * 0 + $matrix[3] * 0 + $matrix[5];
                $charWidth = 0.001 * $this->fontMap->getCharWidth($char, $font);
                $list->append(new Glyph($char, $font, $size, Point::factory($offX + $offset, $offY), new Dimension($charWidth, $size), 1.0, 'black'));
                $off = $off + $charWidth;
            }
        }

        return $list;

    }


}
