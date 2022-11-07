<?php

namespace Tests\Unit;

use App\Models\Pelicula;
use PHPUnit\Framework\TestCase;

/*
 * Por convención, todas las clases de tests deberían tener el sufijo "Test".
 *
 * Dentro de la clase, vamos a crear los tests a razón de un método por test.
 * Los métodos que contienen un test, por convención, deben empezar con el prefijo "test".
 *
 * En Laravel, se acostumbra usar nombres de métodos de tests con "snake_case", en vez de "camelCase".
 * Esta particular convención es solo de Laravel (no de testing en php en general), así que es más
 * simple ignorarla. Lo importante es ser consistentes.
 *
 * Lo que sí es importante, es que los nombres de los métodos sean lo más descriptivos posible de lo que
 * están verificando. Sin importar que quede un nombre bastante largo.
 */
class CarritoItemTest extends TestCase
{
    /*
     * Como primer test, vamos a probar que podemos instanciar la clase CarritoItem con una Pelicula.
     * Normalmente, no haríamos un test como este, ya que no tiene mucho sentido verificar que pueda
     * instanciar una clase. Eso es parte del propio lenguaje de php.
     */
    public function test_puedo_instanciar_la_clase_carritoitem_con_solo_una_pelicula()
    {
        // Los tests se componen de hasta, típicamente, tres partes:
        // 1. Definición de valores y configuración del entorno.
        // 2. Ejecución del método a testear.
        // 3. Verificación de expectativas/verificaciones ("assertions").

        // 1. Definimos los valores.
        $id = 1;
        $pelicula = new Pelicula;
        $pelicula->pelicula_id = $id;

        // 2. Ejecutamos el método a testear.
        $ci = new \App\Cart\CarritoItem($pelicula);

        // 3. Verificaciones usando los métodos de assert*.
        // Verificamos que, en efecto, sea una instancia de CarritoItem.
        $this->assertInstanceOf(\App\Cart\CarritoItem::class, $ci);
        // Verificamos que el item sea una instancia de Película.
        $this->assertInstanceOf(Pelicula::class, $ci->getItem());
        // Verificamos que sea _exactamente_ (comparación entre objetos es por referencia) la misma película.
        // Para verificar con objetos por referencia, usamos assertSame().
        $this->assertSame($pelicula, $ci->getItem());
        // Verificamos que el id de la película sea 1.
        $this->assertEquals($id, $ci->getItem()->pelicula_id);
    }
}
