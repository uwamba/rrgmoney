<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Models\StockAccount;


class StockAccountTest extends TestCase
{


    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    use RefreshDatabase;

    public function testStoringData()
    {
        // Assuming you have a model called 'User', replace this with your own model
        $user = StockAccount::create([
            'name' => 'John Doe',
            'currency' => 'RW',
            'description' => 'descriptions',
            'created_by' => '1',
            'modified_by' => '2',
        ]);

        // Assert that the user was stored in the database
        $this->assertDatabaseHas('stock_accounts', [
            'name' => 'John Doe',
        ]);
    }
    use RefreshDatabase;
    /** @test */
    public function getAccountList()
    {

        $user = User::factory()->create();
        $StockAccount = StockAccount::factory()->count(1)->create();
        $data = $StockAccount->toArray();
        $response = $this->actingAs($user)
        ->withSession(['banned' => false])
        ->get('StockAccount/index');
        //$response->dump();
        $response->assertStatus(200);

        $response
         ->assertJson(fn (AssertableJson $json) =>
        $json->has(1)
             ->first(fn (AssertableJson $json) =>
                $json->where('id', 2)
                     ->etc()
             )
    );

    }
}
