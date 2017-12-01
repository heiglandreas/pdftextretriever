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

namespace Org_Heigl\PdfTextRetriever\Object;

use Org\Heigl\Geo\Dimension;
use Org\Heigl\Geo\Point;
use Org\Heigl\Geo\Rectangle;

class Glyph
{
    private $font;

    private $size;

    private $ll;

    private $rect;

    private $alpha;

    private $fillcolor;

    private $glyph;

    public function __construct(
        string $glyph,
        string $font,
        float $size,
        Point $ll,
        Dimension $rect,
        float $alpha,
        string $fillcolor
    ) {
        $this->glyph = $glyph;
        $this->font = $font;
        $this->size = $size;
        $this->ll = $ll;
        $this->rect = $rect;
        $this->alpha = $alpha;
        $this->fillcolor = $fillcolor;
    }


    public function getGlyph() : string
    {
        return $this->glyph;
    }

    public function getLowerLeft() : Point
    {
        return $this->ll;
    }

    public function getDimension() : Dimension
    {
        return $this->rect;
    }

    public function getBoundingBox() : Rectangle
    {
        return Rectangle::factory(
            $this->ll->getY() + $this->rect->getHeight(),
                $this->ll->getX(),
            $this->ll->getY(),
            $this->ll->getX() + $this->rect->getWidth()
            );
    }
}
