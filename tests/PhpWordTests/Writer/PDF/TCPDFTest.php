<?php

/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 *
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWordTests\Writer\PDF;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Writer\PDF;

/**
 * Test class for PhpOffice\PhpWord\Writer\PDF\TCPDF.
 *
 * @runTestsInSeparateProcesses
 */
class TCPDFTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test construct.
     */
    public function testConstruct(): void
    {
        $file = __DIR__ . '/../../_files/tcpdf.pdf';

        $phpWord = new PhpWord();
        $phpWord->setDefaultParagraphStyle(['spaceBefore' => 0, 'spaceAfter' => 0]);
        $section = $phpWord->addSection();
        $section->addText('Test 1');

        $rendererName = Settings::PDF_RENDERER_TCPDF;
        $rendererLibraryPath = realpath(PHPWORD_TESTS_BASE_DIR . '/../vendor/tecnickcom/tcpdf');
        Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
        $writer = new PDF($phpWord);
        $writer->save($file);

        self::assertFileExists($file);

        unlink($file);
    }

    /**
     * Test set/get abstract renderer options.
     */
    public function testSetGetAbstractRendererOptions(): void
    {
        $rendererName = Settings::PDF_RENDERER_TCPDF;
        $rendererLibraryPath = realpath(PHPWORD_TESTS_BASE_DIR . '/../vendor/tecnickcom/tcpdf');
        Settings::setPdfRenderer($rendererName, $rendererLibraryPath);
        Settings::setPdfRendererOptions([
            'font' => 'Arial',
        ]);
        $writer = new PDF(new PhpWord());
        self::assertEquals('Arial', $writer->getFont());
    }
}
