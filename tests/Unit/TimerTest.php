<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TimerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function startTest()
    {
        $user = factory(\App\Entities\User::class)->make();

        $response = $this->actingAs($user)
            ->post(route('timer.start'))
            ->assertStatus(200)
            ->assertJson([
                'ok' => true,
            ]);

        $response->assertStatus(200);

        $this->assertTrue(true);
    }
}
