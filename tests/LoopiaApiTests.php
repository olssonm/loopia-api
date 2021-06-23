<?php namespace Olssonm\LoopiaApi;

use Olssonm\LoopiaApi\Client;

use PHPUnit\Framework\TestCase;

class LoopiaApiTests extends TestCase {

    protected $data;

    public function setUp(): void
    {
        $this->data = $_SERVER['test_data'];

        // $data[1] (username) and $data[2] (password) always need to be set
        if (!isset($this->data['username']) || !isset($this->data['password'])) {
            throw new \Exception("Use username and password as arguments for phpunit", 1);
        }

        parent::setUp();
    }

    /* @test */
    public function test_bad_credentials()
    {
        $response = (new Client('username', 'password'))->getDomains()->getResponse();

        $this->assertIsArray($response);
        $this->assertEquals('AUTH_ERROR', $response[0]);
    }

    /* @test */
    public function test_bad_domain()
    {
        $response = (new Client($this->data['username'], $this->data['password']))->getDomain('example.com')->getResponse();

        $this->assertIsString($response);
        $this->assertEquals('UNKNOWN_ERROR', $response);
    }

    /* @test */
    public function test_get_domains()
    {
        $response = (new Client($this->data['username'], $this->data['password']))->getDomains()->getResponse();

        $this->assertIsArray($response);
        $this->assertGreaterThan(0, $response);
    }

    /* @test */
    public function test_get_domains_multiline()
    {
        $client = new Client($this->data['username'], $this->data['password']);
        $client->getDomains();
        $response = $client->getResponse();

        $this->assertIsArray($response);
        $this->assertGreaterThan(0, $response);
    }

    /* @test */
    public function test_get_zone_records()
    {
        // Arguments; username password domain recordsubdomain, example:
        // username password example.com @
        $response = (new Client($this->data['username'], $this->data['password']))->getZoneRecords($this->data['domain'], $this->data['flag'])->getResponse();

        $this->assertIsArray($response);
        $this->assertGreaterThan(0, $response);
        $this->assertArrayHasKey('rdata', $response[0]);
        $this->assertArrayHasKey('record_id', $response[0]);
    }

    /* @test */
    public function test_update_name_servers()
    {
        $response = (new Client($this->data['username'], $this->data['password']))
            ->updateDNSServers($this->data['domain'], ['ns1.loopia.se', 'ns2.loopia.se'])
            ->getResponse();

        $this->assertIsString($response);
        $this->assertEquals('OK', $response);
    }
}
