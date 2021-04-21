<?php

namespace CmdrSharp\NetBox\Tests\Dcim;

use CmdrSharp\NetBox\Dcim\Site;
use CmdrSharp\NetBox\Tests\NetBoxTestCase;

class SiteTest extends NetBoxTestCase
{
    /** @test */
    public function can_get_all_sites()
    {
        $sites = Site::all();
        $sitesBody = json_decode($sites->getBody());

        $this->assertEquals(200, $sites->getStatusCode());
        $this->assertIsNumeric($sitesBody->count);
    }

    /** @test */
    public function can_get_one_site()
    {
        $site = Site::get(1);
        $siteBody = json_decode($site->getBody());

        $this->assertEquals(200, $site->getStatusCode());
        $this->assertEquals(1, $siteBody->id);
    }

    /** @test */
    public function can_create_site_via_mass_assignment()
    {
        $site = new Site([
            'name' => 'PHPUnit Site 1',
            'slug' => 'phpunit-site-1',
            'status' => 'staging',
            'description' => 'Test Case',
        ]);

        $result = $site->create();
        $resultBody = json_decode($result->getBody());

        $this->assertEquals(201, $result->getStatusCode());
        $this->assertObjectHasAttribute('id', $resultBody);

        return $resultBody->id;
    }

    /** @test */
    public function can_create_site_via_fluid_setters()
    {
        $result = (new Site())->setName('PHPUnit Site 2')
            ->setSlug('PHPUnit Site 2', true)
            ->setStatus('staging')
            ->setDescription('Test Case')
            ->create();

        $resultBody = json_decode($result->getBody());

        $this->assertEquals(201, $result->getStatusCode());
        $this->assertObjectHasAttribute('id', $resultBody);

        return $resultBody->id;
    }

    /**
     * @test
     * @depends can_create_site_via_mass_assignment
     */
    public function can_get_site_by_name()
    {
        $query = Site::whereName('PHPUnit Site 1');
        $results = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertObjectHasAttribute('count', $results);
        $this->assertEquals(1, $results->count);
    }

    /**
     * @test
     * @depends can_create_site_via_mass_assignment
     * @depends can_create_site_via_fluid_setters
     * @param int $site1
     * @param int $site2
     */
    public function can_delete_sites(int $site1, int $site2)
    {
        $deleteOne = Site::delete($site1);
        $deleteTwo = Site::delete($site2);

        $this->assertEquals(204, $deleteOne->getStatusCode());
        $this->assertEquals(204, $deleteTwo->getStatusCode());
    }
}