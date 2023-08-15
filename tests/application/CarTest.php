<?php


use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class CarTest extends ApiTestCase
{
    public function testListing(): void
    {
        //Get list of cars
        $response = static::createClient()->request('GET', '/cars');
        $this->assertResponseIsSuccessful();
        $singleCarFromList = json_decode($response->getContent())[0];
        $this->assertSame('audi', $singleCarFromList->model);

        //Get one car only
        $response = static::createClient()->request('GET', "/car/{$singleCarFromList->id}");
        $this->assertResponseIsSuccessful();
        $singleCar = json_decode($response->getContent());
        $this->assertSame('audi', $singleCar->model);
    }

}
