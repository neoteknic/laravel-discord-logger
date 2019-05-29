<?php

namespace MarvinLabs\DiscordLogger\Tests\Discord;

use GuzzleHttp\Client as HttpClient;
use MarvinLabs\DiscordLogger\Discord\Client;
use MarvinLabs\DiscordLogger\Discord\Embed;
use MarvinLabs\DiscordLogger\Discord\Message;
use MarvinLabs\DiscordLogger\Tests\TestCase;

/** @group RequiresNetwork */
class ClientTest extends TestCase
{
    /** @var \MarvinLabs\DiscordLogger\Discord\Client */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client(new HttpClient(), config('logging.channels.discord.url'));
    }

    /** @test */
    public function can_send_a_simple_message()
    {
        $this->client->send(Message::make('This is a test'));
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function can_send_a_message_with_file()
    {
        $this->client->send(Message::make('This is a test with a file')->file('testing 1, 2, 3', 'example.txt'));
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function can_send_a_message_with_embeds()
    {
        $this->client->send(
            Message::make('This is a test with embeds')
                ->from('John Doe', 'http://lorempixel.com/100/100/people')
                ->embed(Embed::make()
                    ->title('This is a title', 'http://example.com')
                    ->color(0x345987)
                    ->author('Jane Dane', 'http://example.com/john', 'http://lorempixel.com/100/100/people')
                    ->image('http://lorempixel.com/300/100/nature'))
                ->embed(Embed::make()
                    ->color(0x789678)
                    ->thumbnail('http://lorempixel.com/200/200/cats')
                    ->description("`This is a sample code block\n\nAnd more code here`"))
                ->embed(Embed::make()
                    ->color(0xab7812)
                    ->footer('I am testing the footer', 'http://lorempixel.com/100/100/transport')
                    ->field('field-1', 'foo', true)
                    ->field('field-2', 'bar', true)
                    ->field('field-3', 'baz', false)));

        $this->expectNotToPerformAssertions();
    }
}