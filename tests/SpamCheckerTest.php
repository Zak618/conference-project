<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Comment;
use App\SpamChecker;
use Blackfire\Client;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class SpamCheckerTest extends TestCase
{
    public function testSpamScoreWithInvalidRequest(): void
    {
        $comment = new Comment();
        $comment->setCreatedAtValue();
        $context = [];

        $client = new MockHttpClient([new MockResponse('invalid', ['response_headers' => ['x-akismet-debug-help: Invalid key']])]);
        $checker = new SpamChecker($client, 'abcde');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unable to check for spam: invalid (Invalid key).');
        $checker->getSpamScore($comment, $context);

    }
}
