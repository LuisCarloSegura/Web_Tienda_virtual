<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AutenticacionYPerfilTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Comprobar el modelo User y su clave primaria personalizada.
     */
    public function test_modelo_user_utiliza_id_usuario_como_clave_primaria(): void
    {
        $user = User::factory()->create([
            'nombre' => 'Carlos',
            'primer_apellido' => 'Ramírez',
            'segundo_apellido' => 'Pérez',
            'email' => 'carlos@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->assertEquals('id_usuario', $user->getKeyName());
        $this->assertNotNull($user->id_usuario);
    }

    /**
     * Test 2: Registro exitoso de usuario con validación y cifrado de contraseña.
     */
    public function test_registro_de_usuario_exitoso(): void
    {
        $datosRegistro = [
            'nombre' => 'Juan',
            'primer_apellido' => 'Pérez',
            'segundo_apellido' => 'Gómez',
            'email' => 'juan.perez@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ];

        $response = $this->post(route('registro.store'), $datosRegistro);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'nombre' => 'Juan',
            'primer_apellido' => 'Pérez',
            'segundo_apellido' => 'Gómez',
            'email' => 'juan.perez@example.com',
            'rol' => 'cliente',
        ]);

        $usuario = User::where('email', 'juan.perez@example.com')->first();
        $this->assertTrue(Hash::check('Password123!', $usuario->password));
    }

    /**
     * Test 3: Validación de unicidad y formato de email en registro.
     */
    public function test_registro_falla_con_email_duplicado_o_invalido(): void
    {
        User::create([
            'nombre' => 'Existe',
            'primer_apellido' => 'Usuario',
            'segundo_apellido' => 'Test',
            'email' => 'existente@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        // Email duplicado
        $responseDuplicado = $this->post(route('registro.store'), [
            'nombre' => 'Nuevo',
            'primer_apellido' => 'Lopez',
            'segundo_apellido' => 'Ruiz',
            'email' => 'existente@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);
        $responseDuplicado->assertSessionHasErrors(['email']);

        // Email formato inválido
        $responseFormato = $this->post(route('registro.store'), [
            'nombre' => 'Nuevo',
            'primer_apellido' => 'Lopez',
            'segundo_apellido' => 'Ruiz',
            'email' => 'correo-invalido-sin-arroba',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);
        $responseFormato->assertSessionHasErrors(['email']);
    }

    /**
     * Test 4: Inicio de sesión exitoso y fallido.
     */
    public function test_inicio_de_sesion_funcional_y_seguro(): void
    {
        $user = User::create([
            'nombre' => 'Ana',
            'primer_apellido' => 'Torres',
            'segundo_apellido' => 'Vega',
            'email' => 'ana@example.com',
            'password' => Hash::make('Secret123'),
        ]);

        // Credenciales incorrectas
        $responseFallido = $this->post(route('login.store'), [
            'email' => 'ana@example.com',
            'password' => 'WrongPassword',
        ]);
        $responseFallido->assertSessionHasErrors();
        $this->assertGuest();

        // Credenciales correctas
        $responseExitoso = $this->post(route('login.store'), [
            'email' => 'ana@example.com',
            'password' => 'Secret123',
        ]);
        $responseExitoso->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test 5: Cierre de sesión seguro (logout).
     */
    public function test_cierre_de_sesion_seguro(): void
    {
        $user = User::create([
            'nombre' => 'Luis',
            'primer_apellido' => 'Soto',
            'segundo_apellido' => 'Mora',
            'email' => 'luis@example.com',
            'password' => Hash::make('Password123'),
        ]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->post(route('logout'));
        $response->assertRedirect(route('dashboard'));
        $this->assertGuest();
    }

    /**
     * Test 6: Protección de ruta /mi-cuenta mediante middleware auth.
     */
    public function test_ruta_mi_cuenta_requiere_autenticacion(): void
    {
        $responseGet = $this->get(route('perfil.index'));
        $responseGet->assertRedirect(route('login'));

        $responsePut = $this->put(route('perfil.update'), [
            'nombre' => 'Test',
            'primer_apellido' => 'Test',
            'segundo_apellido' => 'Test',
            'email' => 'test@example.com',
        ]);
        $responsePut->assertRedirect(route('login'));
    }

    /**
     * Test 7: Carga exitosa de la vista Mi Cuenta para usuario autenticado.
     */
    public function test_usuario_autenticado_puede_ver_mi_cuenta(): void
    {
        $user = User::create([
            'nombre' => 'Maria',
            'primer_apellido' => 'Jimenez',
            'segundo_apellido' => 'Salas',
            'email' => 'maria@example.com',
            'password' => Hash::make('Password123'),
        ]);

        $response = $this->actingAs($user)->get(route('perfil.index'));

        $response->assertStatus(200);
        $response->assertSee('Mi Cuenta');
        $response->assertSee('Detalles de la cuenta');
        $response->assertSee('primer_apellido');
        $response->assertSee('segundo_apellido');
        $response->assertSee('Cerrar sesión');
    }

    /**
     * Test 8: Actualización de datos personales en Mi Cuenta (sin cambiar contraseña).
     */
    public function test_actualizar_datos_personales_exitosamente(): void
    {
        $user = User::create([
            'nombre' => 'Pedro',
            'primer_apellido' => 'Navarro',
            'segundo_apellido' => 'Chaves',
            'email' => 'pedro@example.com',
            'password' => Hash::make('OldPassword123'),
        ]);

        $response = $this->actingAs($user)->put(route('perfil.update'), [
            'nombre' => 'Pedro Antonio',
            'primer_apellido' => 'Navarro',
            'segundo_apellido' => 'Solano',
            'email' => 'pedro.nuevo@example.com',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id_usuario' => $user->id_usuario,
            'nombre' => 'Pedro Antonio',
            'primer_apellido' => 'Navarro',
            'segundo_apellido' => 'Solano',
            'email' => 'pedro.nuevo@example.com',
        ]);
    }

    /**
     * Test 9: Cambio de contraseña opcional exitoso en Mi Cuenta.
     */
    public function test_cambio_de_contrasena_exitoso_en_mi_cuenta(): void
    {
        $user = User::create([
            'nombre' => 'Sofia',
            'primer_apellido' => 'Vargas',
            'segundo_apellido' => 'Castro',
            'email' => 'sofia@example.com',
            'password' => Hash::make('PasswordActual123'),
        ]);

        $response = $this->actingAs($user)->put(route('perfil.update'), [
            'nombre' => 'Sofia',
            'primer_apellido' => 'Vargas',
            'segundo_apellido' => 'Castro',
            'email' => 'sofia@example.com',
            'password_actual' => 'PasswordActual123',
            'password' => 'NuevaPassword123',
            'password_confirmation' => 'NuevaPassword123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('NuevaPassword123', $user->password));
    }

    /**
     * Test 10: Fallo en cambio de contraseña cuando la contraseña actual es incorrecta o la confirmación no coincide.
     */
    public function test_cambio_de_contrasena_falla_con_contrasena_actual_incorrecta(): void
    {
        $user = User::create([
            'nombre' => 'Diego',
            'primer_apellido' => 'Mendoza',
            'segundo_apellido' => 'Rojas',
            'email' => 'diego@example.com',
            'password' => Hash::make('CorrectPassword123'),
        ]);

        // Contraseña actual errónea
        $response = $this->actingAs($user)->put(route('perfil.update'), [
            'nombre' => 'Diego',
            'primer_apellido' => 'Mendoza',
            'segundo_apellido' => 'Rojas',
            'email' => 'diego@example.com',
            'password_actual' => 'WrongCurrentPassword',
            'password' => 'NewPassword123',
            'password_confirmation' => 'NewPassword123',
        ]);

        $response->assertSessionHasErrors(['password_actual']);

        $user->refresh();
        $this->assertTrue(Hash::check('CorrectPassword123', $user->password));
    }
}
