<?php

namespace Feature\User;

use App\Models\Summary;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class BookTest extends TestCase
{
    use DatabaseMigrations;
    
    protected $url;
    
    /**
     * @test
     */
    public function ListBookTest()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        Summary::factory()->count( 3 )->create();
        $response = $this->get( $this->url . "/v1/livros" );
        $response->assertOk();
        $response->assertJsonStructure( [
                                            [
                                                'id',
                                                'usuario_publicador_id',
                                                'titulo',
                                                'summaries' => [
                                                    [
                                                        'id',
                                                        'livro_id',
                                                        'indice_pai_id',
                                                        'titulo',
                                                        'pagina',
                                                        'subindices' => []
                                                    ]
                                                ]
                                            ]
                                        ] );
    }
    
    /**
     * @return array[]
     */
    public function bookProvider()
    {
        return [
            [
                [
                    "titulo"  => "exemplo",
                    "indices" => [
                        [
                            "titulo"     => "indice 1",
                            "pagina"     => 2,
                            "subindices" => [
                                [
                                    "titulo"     => "indice 1.1",
                                    "pagina"     => 3,
                                    "subindices" => []
                                ],
                                [
                                    "titulo"     => "indice 1.2",
                                    "pagina"     => 3,
                                    "subindices" => [
                                        [
                                            "titulo"     => "indice 1.2.1",
                                            "pagina"     => 3,
                                            "subindices" => []
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "titulo"     => "indice 2",
                            "pagina"     => 4,
                            "subindices" => [
                                [
                                    "titulo"     => "indice 2.1",
                                    "pagina"     => 3,
                                    "subindices" => []
                                ]
                            ]
                        ],
                        [
                            "titulo"     => "indice 3",
                            "pagina"     => 3,
                            "subindices" => []
                        ]
                    ]
                ]
            ]
        ];
    }
    
    /**
     * @dataProvider bookProvider
     * @test
     */
    public function StoreBookTest( $data )
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->post( $this->url . "/v1/livros", $data );
        $response->assertStatus( 201 );
        $response->assertJson( [ "message" => "Livro cadastrado com sucesso !" ] );
        $this->assertDatabaseHas( 'livros', [ "titulo" => "exemplo" ] );
    }
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->url = env( 'APP_URL' );
    }
}
