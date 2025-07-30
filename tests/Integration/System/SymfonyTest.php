<?php

namespace App\Tests\Integration\System;

use DOMDocument;
use Symfony\Component\HttpClient\HttpClient;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpFoundation\Response;

#[TestDox('Tests of Symfony installation')]
class SymfonyTest extends TestCase
{
    #[TestDox('It serves the home page')]
    public function testIndexPage(): void
    {
        $client = HttpClient::create([
            'base_uri' => 'http://nginx/',
        ]);

        $response = $client->request('GET', '/');
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $html = $response->getContent();

        $document = new DOMDocument();
        // not ideal, but libxml can't handle the SVG in the Symfony logo
        $document->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR);

        $body = $document->getElementsByTagName('body')->item(0);
        $bodyText = trim($body->textContent);

        $this->assertStringContainsString('Hello world from Symfony', $bodyText);
        $this->assertStringContainsString('Mode: dev', $bodyText);
        $this->assertMatchesRegularExpression('/Instance ID: [0-9a-f]{12}/', $bodyText);
        $this->assertMatchesRegularExpression('/DB version: 10.*MariaDB/', $bodyText);
    }

    #[TestDox('It can run the console in a shell')]
    public function testSymfonyConsoleRuns(): void
    {
        $appRootDir = dirname(__DIR__, 3);

        exec("$appRootDir/bin/console --help", $output, $returnCode);

        $this->assertEquals(Command::SUCCESS, $returnCode);
    }
}
