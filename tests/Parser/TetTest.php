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

namespace Org_Heigl\PdfTextRetrieverTest\Parser;

use Org_Heigl\PdfTextRetriever\Parser\Tet;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class TetTest extends TestCase
{

    public function test__construct()
    {
        $parser = new Tet(new \TET());

        $this->assertAttributeInstanceOf('TET', 'tet', $parser);
    }

    public function testParse()
    {
        $parser = new Tet(new \TET());

        $file = __DIR__ . '/../_assets/on1801hes-s14-15-Polyamorie.pdf';

        $result = $parser->parse(new  SplFileInfo($file), 1);

        $this->assertEquals(2326, $result->count());
    }

    /** @expectedException \Org_Heigl\PdfTextRetriever\Exception\UnableToOpenFile */
    public function testThatParsingAnInvalidFileThrowsAnException()
    {
        $parser = new Tet(new \TET());

        $file = __FILE__;

        $parser->parse(new  SplFileInfo($file), 1);
    }
}
