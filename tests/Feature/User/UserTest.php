<?php

namespace Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class UserTest extends TestCase
{
    use DatabaseMigrations;
    
    protected $url;
    
    /**
     * @test
     */
    public function CanBeAuthTest()
    {
        $user = [ 'email' => 'teste@email.com', 'password' => '123mudar' ];
        User::factory()->create( [ 'email' => 'teste@email.com' ] );
        $response = $this->post( $this->url . "/v1/auth/token", $user );
        $response->assertOk();
        $response->assertJsonStructure( [ 'token' ] );
    }
    
    /**
     * @test
     */
    public function CantBeAuthTest()
    {
        User::factory()->create( [ 'email' => 'teste@email.com' ] );
        $response = $this->post( $this->url . "/v1/auth/token", [ 'email' => 'errado@email.com', 'password' => '123mudar' ] );
        $response->assertStatus( 400 );
        $response->assertJson( [ 'message' => 'Dados incorretos' ] );
    }
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->url = env( 'APP_URL' );
    }
}
