<?php

namespace CmdrSharp\NetBox\Tests\Ipam;

use CmdrSharp\NetBox\Ipam\IpAddress;
use CmdrSharp\NetBox\Tests\NetBoxTestCase;

class IpAddressTest extends NetBoxTestCase
{
    /** @test */
    public function can_get_all_ip_addresses()
    {
        $query = IpAddress::all();
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertIsNumeric($body->count);
    }

    /** @test */
    public function can_create_ip_address_via_mass_assignment()
    {
        $model = new IpAddress([
            'address' => '172.16.10.1',
            'status' => 'reserved',
            'description' => 'Test Case',
        ]);

        $query = $model->create();
        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /** @test */
    public function can_create_ip_address_via_fluid_setters()
    {
        $query = (new IpAddress())->setAddress('172.16.10.2')
            ->setStatus('reserved')
            ->setDescription('Test Case')
            ->create();

        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /**
     * @test
     * @depends can_create_ip_address_via_mass_assignment
     * @param int $id
     */
    public function can_get_one_prefix(int $id)
    {
        $query = IpAddress::get($id);
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertEquals($id, $body->id);
    }

    /**
     * @test
     * @depends can_create_ip_address_via_mass_assignment
     * @depends can_create_ip_address_via_fluid_setters
     * @param int $idOne
     * @param int $idTwo
     */
    public function can_delete_ip_addresses(int $idOne, int $idTwo)
    {
        $deleteOne = IpAddress::delete($idOne);
        $deleteTwo = IpAddress::delete($idTwo);

        $this->assertEquals(204, $deleteOne->getStatusCode());
        $this->assertEquals(204, $deleteTwo->getStatusCode());
    }
}