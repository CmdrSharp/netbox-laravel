<?php

namespace CmdrSharp\NetBox\Tests\Ipam;

use CmdrSharp\NetBox\Ipam\Prefix;
use CmdrSharp\NetBox\Tests\NetBoxTestCase;

class PrefixTest extends NetBoxTestCase
{
    /** @test */
    public function can_get_all_prefixes()
    {
        $query = Prefix::all();
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertIsNumeric($body->count);
    }

    /** @test */
    public function can_create_prefix_via_mass_assignment()
    {
        $model = new Prefix([
            'prefix' => '172.16.0.0/24',
            'is_pool' => false,
            'description' => 'Test Case',
            'status' => 'active'
        ]);

        $query = $model->create();
        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /** @test */
    public function can_create_prefix_via_fluid_setters()
    {
        $query = (new Prefix())->setPrefix('172.16.1.0/24')
            ->setPool(false)
            ->setDescription('Test Case')
            ->setStatus('active')
            ->create();

        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /**
     * @test
     * @depends can_create_prefix_via_mass_assignment
     * @param int $id
     */
    public function can_get_one_prefix(int $id)
    {
        $query = Prefix::get($id);
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertEquals($id, $body->id);
    }

    /**
     * @test
     * @depends can_create_prefix_via_mass_assignment
     */
    public function can_get_prefix_by_prefix()
    {
        $query = Prefix::wherePrefix('172.16.0.0/24');
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertObjectHasAttribute('count', $body);
        $this->assertEquals(1, $body->count);
    }

    /**
     * @test
     * @depends can_create_prefix_via_mass_assignment
     */
    public function can_get_prefix_by_contains()
    {
        $query = Prefix::whereContains('172.16.0.1');
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertObjectHasAttribute('count', $body);
        $this->assertEquals(1, $body->count);
    }

    /**
     * @test
     * @depends can_create_prefix_via_mass_assignment
     * @depends can_create_prefix_via_fluid_setters
     * @param int $idOne
     * @param int $idTwo
     */
    public function can_delete_prefixes(int $idOne, int $idTwo)
    {
        $deleteOne = Prefix::delete($idOne);
        $deleteTwo = Prefix::delete($idTwo);

        $this->assertEquals(204, $deleteOne->getStatusCode());
        $this->assertEquals(204, $deleteTwo->getStatusCode());
    }
}
