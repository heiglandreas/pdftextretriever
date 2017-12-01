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
 * @since     01.12.2017
 * @link      http://github.com/heiglandreas/org.heigl.PdfTextRetriever
 */

namespace Org_Heigl\PdfTextRetrieverTest;

use Mockery as M;
use Org_Heigl\PdfTextRetriever\Concatenator;
use Org_Heigl\PdfTextRetriever\GlyphList;
use Org_Heigl\PdfTextRetriever\Object\Glyph;
use PHPUnit\Framework\TestCase;

class ConcatenatorTest extends TestCase
{

    public function test__construct()
    {
        $list = M::mock(GlyphList::class);
        $concatenator = new Concatenator($list);

        self::assertAttributeSame($list, 'list', $concatenator);
    }

    public function testConcatenate()
    {
        $list = new GlyphList();

        $glyph = M::mock(Glyph::class);
        $glyph->shouldReceive('getGlyph')->andReturn('A');
        $list->append($glyph);
        $list->append($glyph);
        $list->append($glyph);
        $list->append($glyph);

        $concatenator = new Concatenator($list);


        $text = $concatenator->concatenate();

        $comparetext = 'AAAA';

        self::assertEquals($comparetext, $text);
    }
}
