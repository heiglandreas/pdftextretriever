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

use Org\Heigl\Geo\Rectangle;
use Org_Heigl\PdfTextRetriever\Object\Glyph;

class CropRetriever
{
    private $glyphList;

    public function __construct(GlyphList $glyphList)
    {
        $this->glyphList = $glyphList;
    }

    public function getGlyphsWithinRectangle(Rectangle $rectangle) : GlyphList
    {
        $newList = new GlyphList();
        foreach ($this->glyphList as $glyph) {
            if (! $this->isGlyphContainedInRectangle($glyph, $rectangle)) {
                continue;
            }

            $newList->append($glyph);
        }

        return $newList;
    }

    private function isGlyphContainedInRectangle(Glyph $glyph, Rectangle $rectangle) : bool
    {
        if ($glyph->getBoundingBox()->getBottom() < $rectangle->getBottom()) {
            return false;
        }

        if ($glyph->getBoundingBox()->getLeft() < $rectangle->getLeft()) {
            return false;
        }

        if ($glyph->getBoundingBox()->getRight() > $rectangle->getRight()) {
            return false;
        }

        if ($glyph->getBoundingBox()->getTop() > $rectangle->getTop()) {
            return false;
        }

        return true;
    }
}
