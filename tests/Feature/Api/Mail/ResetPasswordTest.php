<?php

namespace Tests\Feature\Api\Mail;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_can_reset_password_with_valid_data()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('old_password')
        ]);

        $newPassword = 'new_password123';
        $data = [
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
            'token' => 'valid_token_123'
        ];

        // Act
        $response = $this->postJson('/api/reset-password', $data);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Senha redefinida com sucesso'
            ]);

        // Verificar se a senha foi realmente alterada
        $user->refresh();
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    /** @test */
    public function it_fails_when_email_is_missing()
    {
        // Arrange
        $data = [
            'password' => 'new_password123',
            'password_confirmation' => 'new_password123',
            'token' => 'valid_token_123'
        ];

        // Act
        $response = $this->postJson('/api/reset-password', $data);

        // Assert
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Dados inválidos'
            ])
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_fails_when_email_is_invalid()
    {
        // Arrange
        $data = [
            'email' => 'invalid-email',
            'password' => 'new_password123',
            'password_confirmation' => 'new_password123',
            'token' => 'valid_token_123'
        ];

        // Act
        $response = $this->postJson('/api/reset-password', $data);

        // Assert
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Dados inválidos'
            ])
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_fails_when_email_does_not_exist()
    {
        // Arrange
        $data = [
            'email' => 'nonexistent@example.com',
            'password' => 'new_password123',
            'password_confirmation' => 'new_password123',
            'token' => 'valid_token_123'
        ];

        // Act
        $response = $this->postJson('/api/reset-password', $data);

        // Assert
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Dados inválidos'
            ])
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_fails_when_password_is_missing()
    {
        // Arrange
        $user = User::factory()->create(['email' => 'test@example.com']);

        $data = [
            'email' => $user->email,
            'password_confirmation' => 'new_password123',
            'token' => 'valid_token_123'
        ];

        // Act
        $response = $this->postJson('/api/reset-password', $data);

        // Assert
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Dados inválidos'
            ])
            ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function it_fails_when_password_is_too_short()
    {
        // Arrange
        $user = User::factory()->create(['email' => 'test@example.com']);

        $data = [
            'email' => $user->email,
            'password' => '123',
            'password_confirmation' => '123',
            'token' => 'valid_token_123'
        ];

        // Act
        $response = $this->postJson('/api/reset-password', $data);

        // Assert
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Dados inválidos'
            ])
            ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function it_fails_when_password_confirmation_does_not_match()
    {
        // Arrange
        $user = User::factory()->create(['email' => 'test@example.com']);

        $data = [
            'email' => $user->email,
            'password' => 'new_password123',
            'password_confirmation' => 'different_password',
            'token' => 'valid_token_123'
        ];

        // Act
        $response = $this->postJson('/api/reset-password', $data);

        // Assert
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Dados inválidos'
            ])
            ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function it_fails_when_token_is_missing()
    {
        // Arrange
        $user = User::factory()->create(['email' => 'test@example.com']);

        $data = [
            'email' => $user->email,
            'password' => 'new_password123',
            'password_confirmation' => 'new_password123'
        ];

        // Act
        $response = $this->postJson('/api/reset-password', $data);

        // Assert
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Dados inválidos'
            ])
            ->assertJsonValidationErrors(['token']);
    }

    /** @test */
    public function it_handles_database_exceptions_gracefully()
    {
        // Arrange
        $user = User::factory()->create(['email' => 'test@example.com']);

        $data = [
            'email' => $user->email,
            'password' => 'new_password123',
            'password_confirmation' => 'new_password123',
            'token' => 'valid_token_123'
        ];

        // Simular erro de banco de dados
        $this->mock(User::class, function ($mock) {
            $mock->shouldReceive('where')->andReturnSelf();
            $mock->shouldReceive('first')->andThrow(new \Exception('Database error'));
        });

        // Act
        $response = $this->postJson('/api/reset-password', $data);

        // Assert
        $response->assertStatus(500)
            ->assertJson([
                'success' => false,
                'message' => 'Erro interno do servidor: Database error'
            ]);
    }

    /** @test */
    public function it_returns_404_when_user_not_found_after_validation()
    {
        // Este teste é mais complexo porque precisaríamos mockar o User::where
        // mas deixo aqui como exemplo de como testar cenários específicos
        $this->markTestSkipped('Teste complexo que requer mock específico');
    }
}