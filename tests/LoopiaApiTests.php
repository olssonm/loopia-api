<?php namespace Olssonm\LoopiaApi;

use Olssonm\LoopiaApi\Client;

use PHPUnit\Framework\TestCase;

class LoopiaApiTests extends TestCase {

    protected $argv;

    public function setUp()
    {
        $this->argv = $_SERVER['argv'];

        // $argv[1] (username) and $argv[2] (password) always need to be set
        if (!isset($this->argv[2]) || !isset($this->argv[3])) {
            throw new \Exception("Use username ans password as arguments for phpUnit", 1);
        }

        parent::setUp();
    }

    /* @test */
    public function test_bad_credentials()
    {
        $response = (new Client('username', 'password'))->getDomains()->getResponse();

        $this->assertInternalType('array', $response);
        $this->assertEquals('AUTH_ERROR', $response[0]);
    }

    /* @test */
    public function test_bad_domain()
    {
        $response = (new Client($this->argv[2], $this->argv[3]))->getDomain('example.com')->getResponse();

        $this->assertInternalType('string', $response);
        $this->assertEquals('UNKNOWN_ERROR', $response);
    }

    /* @test */
    public function test_get_domains()
    {
        $response = (new Client($this->argv[2], $this->argv[3]))->getDomains()->getResponse();

        $this->assertInternalType('array', $response);
        $this->assertGreaterThan(0, $response);
    }

    /* @test */
    public function test_get_domains_multiline()
    {
        $client = new Client($this->argv[2], $this->argv[3]);
        $client->getDomains();
        $response = $client->getResponse();

        $this->assertInternalType('array', $response);
        $this->assertGreaterThan(0, $response);
    }

    /* @test */
    public function test_get_zone_records()
    {
        // Arguments; username password domain recordsubdomain, example:
        // username password example.com @
        $response = (new Client($this->argv[2], $this->argv[3]))->getZoneRecords($this->argv[4], $this->argv[5])->getResponse();

        $this->assertInternalType('array', $response);
        $this->assertGreaterThan(0, $response);
        $this->assertArrayHasKey('rdata', $response[0]);
        $this->assertArrayHasKey('record_id', $response[0]);
    }

    /* @test */
    public function test_update_name_servers()
    {
        $response = (new Client($this->argv[2], $this->argv[3]))
            ->updateDNSServers($this->argv[4], ['ns1.loopia.se', 'ns2.loopia.se'])
            ->getResponse();

        $this->assertInternalType('string', $response);
        $this->assertEquals('OK', $response);
    }

}
