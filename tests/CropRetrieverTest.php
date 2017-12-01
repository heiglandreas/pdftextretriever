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

namespace Org_Heigl\PdfTextRetrieverTest;

use Mockery as M;
use Org\Heigl\Geo\Dimension;
use Org\Heigl\Geo\Point;
use Org\Heigl\Geo\Rectangle;
use Org_Heigl\PdfTextRetriever\CropRetriever;
use Org_Heigl\PdfTextRetriever\GlyphList;
use Org_Heigl\PdfTextRetriever\Object\Glyph;
use PHPUnit\Framework\TestCase;

class CropRetrieverTest extends TestCase
{

    public function test__construct()
    {
        $glyphList = M::mock(GlyphList::class);
        $receiver = new CropRetriever($glyphList);

        $this->assertAttributeSame($glyphList, 'glyphList', $receiver);
    }

    public function testGetGlyphsWithinRectangle()
    {
        $glyphList = new GlyphList();
        $glyphList->append(new Glyph(
            'a',
            'foo',
            12.0, Point::factory(12, 12),
            new Dimension(12, 12),
            1.0,
            'a'
        ));
        $receiver = new CropRetriever($glyphList);

        $this->assertEquals(1, $receiver->getGlyphsWithinRectangle(Rectangle::factory(30, 10, 10, 30))->count());
        $this->assertEquals(0, $receiver->getGlyphsWithinRectangle(Rectangle::factory(20, 10, 10, 30))->count());
        $this->assertEquals(0, $receiver->getGlyphsWithinRectangle(Rectangle::factory(30, 20, 10, 30))->count());
        $this->assertEquals(0, $receiver->getGlyphsWithinRectangle(Rectangle::factory(30, 10, 20, 30))->count());
        $this->assertEquals(0, $receiver->getGlyphsWithinRectangle(Rectangle::factory(30, 10, 10, 20))->count());
    }
}
