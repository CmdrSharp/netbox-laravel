<?php

namespace CmdrSharp\NetBox\Tests\Ipam;

use CmdrSharp\NetBox\Ipam\Vlan;
use CmdrSharp\NetBox\Tests\NetBoxTestCase;

class VlanTest extends NetBoxTestCase
{
    /** @test */
    public function can_get_all_vlans()
    {
        $query = Vlan::all();
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertIsNumeric($body->count);
    }

    /** @test */
    public function can_create_vlan_via_mass_assignment()
    {
        $model = new Vlan([
            'vid' => '4000',
            'name' => 'PHPUnit VLAN 1',
            'status' => 'active',
            'description' => 'Test Case',
        ]);

        $query = $model->create();
        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /** @test */
    public function can_create_vlan_via_fluid_setters()
    {
        $query = (new Vlan())->setName('PHPUnit VLAN 2')
            ->setVid(4000)
            ->setStatus('active')
            ->setDescription('Test Case')
            ->create();

        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /**
     * @test
     * @depends can_create_vlan_via_mass_assignment
     * @param int $id
     */
    public function can_get_one_vlan(int $id)
    {
        $query = Vlan::get($id);
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertEquals($id, $body->id);
    }

    /**
     * @test
     * @depends can_create_vlan_via_mass_assignment
     */
    public function can_get_vlan_by_name()
    {
        $query = Vlan::whereName('PHPUnit VLAN 1');
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertObjectHasAttribute('count', $body);
        $this->assertEquals(1, $body->count);
    }

    /**
     * @test
     * @depends can_create_vlan_via_mass_assignment
     */
    public function can_get_vlan_by_vlan()
    {
        $query = Vlan::whereVlan(4000);
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertObjectHasAttribute('count', $body);
        $this->assertEquals(1, $body->count);
    }

    /**
     * @test
     * @depends can_create_vlan_via_mass_assignment
     * @depends can_create_vlan_via_fluid_setters
     * @param int $idOne
     * @param int $idTwo
     */
    public function can_delete_vlans(int $idOne, int $idTwo)
    {
        $deleteOne = Vlan::delete($idOne);
        $deleteTwo = Vlan::delete($idTwo);

        $this->assertEquals(204, $deleteOne->getStatusCode());
        $this->assertEquals(204, $deleteTwo->getStatusCode());
    }
}
