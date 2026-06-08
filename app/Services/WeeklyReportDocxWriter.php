<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMNode;
use RuntimeException;
use ZipArchive;

class WeeklyReportDocxWriter
{
    private const TEMPLATE_FILE = 'format Weekly Report .docx';
    private const WORD_NAMESPACE = 'http://schemas.openxmlformats.org/wordprocessingml/2006/main';

    public function write(string $path, array $payload): void
    {
        $templatePath = $this->templatePath();

        if (! is_file($templatePath)) {
            throw new RuntimeException('DOCX template not found: ' . $templatePath);
        }

        if (! copy($templatePath, $path)) {
            throw new RuntimeException('Unable to copy DOCX template.');
        }

        $zip = new ZipArchive();

        if ($zip->open($path) !== true) {
            throw new RuntimeException('Unable to open DOCX archive.');
        }

        $document = $this->loadXml($zip, 'word/document.xml');
        $this->rewriteDocument($document, $payload);
        $zip->addFromString('word/document.xml', $document->saveXML());

        $zip->addFromString('docProps/core.xml', $this->coreProps($payload));
        $zip->addFromString('docProps/app.xml', $this->appProps($payload));

        $zip->close();
    }

    public function assetDataUri(string $assetPath): ?string
    {
        $templatePath = $this->templatePath();

        if (! is_file($templatePath)) {
            return null;
        }

        $zip = new ZipArchive();

        if ($zip->open($templatePath) !== true) {
            return null;
        }

        $contents = $zip->getFromName($assetPath);
        $zip->close();

        if ($contents === false) {
            return null;
        }

        $mime = match (pathinfo($assetPath, PATHINFO_EXTENSION)) {
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            default => 'application/octet-stream',
        };

        return 'data:' . $mime . ';base64,' . base64_encode($contents);
    }

    protected function rewriteDocument(DOMDocument $document, array $payload): void
    {
        $payload['sections'] = array_values($payload['sections'] ?? []);

        $xp = new \DOMXPath($document);
        $xp->registerNamespace('w', self::WORD_NAMESPACE);

        $body = $xp->query('/w:document/w:body')->item(0);

        if (! $body instanceof DOMElement) {
            throw new RuntimeException('Invalid DOCX template: missing body.');
        }

        $bodyNodes = [];
        foreach ($body->childNodes as $node) {
            if ($node->nodeType === XML_ELEMENT_NODE) {
                $bodyNodes[] = $node;
            }
        }

        $titleIndexes = [];
        foreach ($bodyNodes as $index => $node) {
            if ($this->nodeText($node) === 'WEEKLY REPORT RSCHB') {
                $titleIndexes[] = $index;
            }
        }

        if ($titleIndexes === []) {
            throw new RuntimeException('Invalid DOCX template: section title not found.');
        }

        $sectionStart = $titleIndexes[0];
        $sectionEnd = $titleIndexes[1] ?? count($bodyNodes);
        $templateSection = array_slice($bodyNodes, $sectionStart, $sectionEnd - $sectionStart);

        $preamble = array_slice($bodyNodes, 0, $sectionStart);
        $sectPr = null;

        foreach (array_reverse($bodyNodes) as $node) {
            if ($node->localName === 'sectPr') {
                $sectPr = $node;
                break;
            }
        }

        while ($body->firstChild) {
            $body->removeChild($body->firstChild);
        }

        foreach ($preamble as $node) {
            $body->appendChild($node->cloneNode(true));
        }

        $sections = $payload['sections'];

        if ($sections === []) {
            $sections = [[
                'period_label' => 'N/A',
                'user' => '-',
                'summary' => [
                    'total_tasks' => 0,
                    'selesai' => 0,
                    'progress' => 0,
                    'kendala' => 0,
                ],
                'activities' => [],
                'issues' => [],
            ]];
        }

        foreach ($sections as $index => $section) {
            if ($index > 0) {
                $body->appendChild($this->pageBreakParagraph($document));
            }

            $clonedNodes = array_map(static fn (DOMNode $node) => $node->cloneNode(true), $templateSection);
            $this->fillSection($clonedNodes, $section);

            foreach ($clonedNodes as $node) {
                $body->appendChild($node);
            }
        }

        if ($sectPr instanceof DOMNode) {
            $body->appendChild($sectPr->cloneNode(true));
        }
    }

    protected function fillSection(array $nodes, array $section): void
    {
        $tables = array_values(array_filter($nodes, static fn (DOMNode $node) => $node instanceof DOMElement && $node->localName === 'tbl'));

        if (count($tables) < 4) {
            throw new RuntimeException('Invalid DOCX template: expected report tables are missing.');
        }

        $this->fillPeriodTable($tables[0], $section);
        $this->fillSummaryTable($tables[1], $section['summary'] ?? []);
        $this->fillActivityTable($tables[2], $section['activities'] ?? []);
        $this->fillIssueTable($tables[3], $section['issues'] ?? []);
    }

    protected function fillPeriodTable(DOMElement $table, array $section): void
    {
        $rows = $this->directChildren($table, 'tr');

        if (count($rows) < 2) {
            return;
        }

        $this->setCellText($this->directChildren($rows[0], 'tc')[1] ?? null, (string) ($section['period_label'] ?? '-'));
        $this->setCellText($this->directChildren($rows[1], 'tc')[1] ?? null, (string) ($section['user'] ?? '-'));
    }

    protected function fillSummaryTable(DOMElement $table, array $summary): void
    {
        $rows = $this->directChildren($table, 'tr');

        if (count($rows) < 2) {
            return;
        }

        $numbers = [
            (string) ($summary['total_tasks'] ?? 0),
            (string) ($summary['selesai'] ?? 0),
            (string) ($summary['progress'] ?? 0),
            (string) ($summary['kendala'] ?? 0),
        ];

        foreach ($numbers as $index => $value) {
            $this->setCellText($this->directChildren($rows[0], 'tc')[$index] ?? null, $value);
        }
    }

    protected function fillActivityTable(DOMElement $table, array $activities): void
    {
        $rows = $this->directChildren($table, 'tr');

        if ($rows === []) {
            return;
        }

        $headerRow = array_shift($rows);
        $templateRow = $rows[0] ?? $headerRow->cloneNode(true);

        foreach ($rows as $row) {
            $table->removeChild($row);
        }

        $activities = array_values($activities);

        if ($activities === []) {
            $activities = [[
                'no' => '-',
                'aktivitas' => '-',
                'status' => '-',
                'keterangan' => '-',
            ]];
        }

        foreach ($activities as $activity) {
            $row = $templateRow->cloneNode(true);
            $cells = $this->directChildren($row, 'tc');

            $this->setCellText($cells[0] ?? null, (string) ($activity['no'] ?? '-'));
            $this->setCellText($cells[1] ?? null, (string) ($activity['aktivitas'] ?? '-'));
            $this->setCellText($cells[2] ?? null, (string) ($activity['status'] ?? '-'));
            $this->setCellText($cells[3] ?? null, (string) ($activity['keterangan'] ?? '-'));

            $table->appendChild($row);
        }
    }

    protected function fillIssueTable(DOMElement $table, array $issues): void
    {
        $rows = $this->directChildren($table, 'tr');

        if ($rows === []) {
            return;
        }

        $headerRow = array_shift($rows);
        $templateRow = $rows[0] ?? $headerRow->cloneNode(true);

        foreach ($rows as $row) {
            $table->removeChild($row);
        }

        $issues = array_values($issues);

        if ($issues === []) {
            $issues = [[
                'no' => '-',
                'kendala' => '-',
                'solusi' => '-',
                'pic' => '-',
                'status' => '-',
            ]];
        }

        foreach ($issues as $issue) {
            $row = $templateRow->cloneNode(true);
            $cells = $this->directChildren($row, 'tc');

            $this->setCellText($cells[0] ?? null, (string) ($issue['no'] ?? '-'));
            $this->setCellText($cells[1] ?? null, (string) ($issue['kendala'] ?? '-'));
            $this->setCellText($cells[2] ?? null, (string) ($issue['solusi'] ?? '-'));
            $this->setCellText($cells[3] ?? null, (string) ($issue['pic'] ?? '-'));
            $this->setCellText($cells[4] ?? null, (string) ($issue['status'] ?? '-'));

            $table->appendChild($row);
        }
    }

    protected function pageBreakParagraph(DOMDocument $document): DOMElement
    {
        $paragraph = $document->createElementNS(self::WORD_NAMESPACE, 'w:p');
        $run = $document->createElementNS(self::WORD_NAMESPACE, 'w:r');
        $break = $document->createElementNS(self::WORD_NAMESPACE, 'w:br');
        $break->setAttributeNS(self::WORD_NAMESPACE, 'w:type', 'page');
        $run->appendChild($break);
        $paragraph->appendChild($run);

        return $paragraph;
    }

    protected function setCellText(?DOMElement $cell, string $text): void
    {
        if (! $cell instanceof DOMElement) {
            return;
        }

        $textNodes = [];
        foreach ($cell->getElementsByTagNameNS(self::WORD_NAMESPACE, 't') as $textNode) {
            $textNodes[] = $textNode;
        }

        if ($textNodes === []) {
            $paragraph = $cell->ownerDocument->createElementNS(self::WORD_NAMESPACE, 'w:p');
            $run = $cell->ownerDocument->createElementNS(self::WORD_NAMESPACE, 'w:r');
            $textNode = $cell->ownerDocument->createElementNS(self::WORD_NAMESPACE, 'w:t');
            $textNode->setAttributeNS('http://www.w3.org/XML/1998/namespace', 'xml:space', 'preserve');
            $textNode->nodeValue = $text;
            $run->appendChild($textNode);
            $paragraph->appendChild($run);
            $cell->appendChild($paragraph);
            return;
        }

        /** @var \DOMElement $first */
        $first = array_shift($textNodes);
        $first->nodeValue = $text;

        foreach ($textNodes as $textNode) {
            $textNode->nodeValue = '';
        }
    }

    protected function directChildren(DOMElement $node, ?string $localName = null): array
    {
        $children = [];

        foreach ($node->childNodes as $child) {
            if ($child->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            if ($localName !== null && $child->localName !== $localName) {
                continue;
            }

            $children[] = $child;
        }

        return $children;
    }

    protected function nodeText(DOMNode $node): string
    {
        return trim(preg_replace('/\s+/u', ' ', $node->textContent));
    }

    protected function loadXml(ZipArchive $zip, string $path): DOMDocument
    {
        $xml = $zip->getFromName($path);

        if ($xml === false) {
            throw new RuntimeException('Missing DOCX part: ' . $path);
        }

        $document = new DOMDocument();
        $document->preserveWhiteSpace = true;
        $document->formatOutput = false;

        if (! $document->loadXML($xml, LIBXML_NOBLANKS)) {
            throw new RuntimeException('Unable to parse DOCX part: ' . $path);
        }

        return $document;
    }

    protected function coreProps(array $payload): string
    {
        $generatedAt = $payload['generated_at'] ?? now();
        $generatedAt = $generatedAt instanceof \DateTimeInterface ? $generatedAt : now();
        $title = htmlspecialchars((string) ($payload['title'] ?? 'Weekly Report'), ENT_XML1 | ENT_COMPAT, 'UTF-8');
        $subject = htmlspecialchars((string) ($payload['subject'] ?? 'Weekly Report'), ENT_XML1 | ENT_COMPAT, 'UTF-8');
        $creator = htmlspecialchars((string) ($payload['author'] ?? 'System'), ENT_XML1 | ENT_COMPAT, 'UTF-8');
        $created = $generatedAt->format('Y-m-d\TH:i:s\Z');

        return <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <dc:title>{$title}</dc:title>
    <dc:subject>{$subject}</dc:subject>
    <dc:creator>{$creator}</dc:creator>
    <cp:lastModifiedBy>{$creator}</cp:lastModifiedBy>
    <dcterms:created xsi:type="dcterms:W3CDTF">{$created}</dcterms:created>
    <dcterms:modified xsi:type="dcterms:W3CDTF">{$created}</dcterms:modified>
</cp:coreProperties>
XML;
    }

    protected function appProps(array $payload): string
    {
        $title = htmlspecialchars((string) ($payload['title'] ?? 'Weekly Report'), ENT_XML1 | ENT_COMPAT, 'UTF-8');

        return <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">
    <Application>Weekly Report System</Application>
    <DocSecurity>0</DocSecurity>
    <ScaleCrop>false</ScaleCrop>
    <HeadingPairs>
        <vt:vector size="2" baseType="variant">
            <vt:variant><vt:lpstr>Title</vt:lpstr></vt:variant>
            <vt:variant><vt:i4>1</vt:i4></vt:variant>
        </vt:vector>
    </HeadingPairs>
    <TitlesOfParts>
        <vt:vector size="1" baseType="lpstr">
            <vt:lpstr>{$title}</vt:lpstr>
        </vt:vector>
    </TitlesOfParts>
    <Company>Weekly Report</Company>
    <LinksUpToDate>false</LinksUpToDate>
    <SharedDoc>false</SharedDoc>
    <HyperlinksChanged>false</HyperlinksChanged>
    <AppVersion>16.0000</AppVersion>
</Properties>
XML;
    }

    protected function templatePath(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . self::TEMPLATE_FILE;
    }
}
