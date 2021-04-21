<?php

namespace CmdrSharp\NetBox\Tests;

use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;

abstract class NetBoxTestCase extends TestCase
{
    /**
     * Set up the test case
     */
    public function setUp(): void
    {
        parent::setUp();

        Config::set('netbox.host', 'http://localhost:8000');
        Config::set('netbox.token', '1a8c363a274ce90a711236df4953ee279a10740a');
        Config::set('netbox.verify_peer', false);
    }
}