<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Summary;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class SummaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $book_id = Book::factory()->create()->id;
        
        return [
            'livro_id'      => $book_id,
            'indice_pai_id' => fake()->numberBetween( 1, 10 ) % 3 == 0 ? Summary::factory()->create( [ 'livro_id' => $book_id ] )->id : null,
            'titulo'        => fake()->name(),
            'pagina'        => fake()->numberBetween( 1, 100 ),
        ];
    }
    
    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state( fn( array $attributes ) => [
            'email_verified_at' => null,
        ] );
    }
}
