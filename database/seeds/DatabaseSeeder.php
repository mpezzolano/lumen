<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //insertamos las películas
		$this->call('MovieTableSeeder');

        //mostramos el mensaje de que las películas se han insertado correctamente
        $this->command->info('Movies table seeded!');

        Model::reguard();
    }
}


class MovieTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('movies')->insert(
            array(
                array(
                    'director' => 'Kyle Balda, Pierre Coffin',
                    'title' => 'Los Minions',
                    'sinopsis' => 'Minions Stuart, Kevin and Bob are recruited by Scarlet Overkill, a super-villain who, alongside her inventor husband Herb, hatches a plot to take over the world.',
                    'created_at' => '2015-07-03 00:00:00'
                ),
                array(
                    'director' => 'Brad Bird',
                    'title' => 'Tomorrowland',
                    'sinopsis' => "Una niña encuentra un pin que la traslada a otro lugar en el tiempo y el espacio en 'Tomorrowland: El mundo del mañana'. Casey, el personaje de Britt Robertson, investigará el origen del pin y dará con un genio, interpretado por George Clooney, que ha perdido la esperanza. Pero Casey puede ser lo que habían estado esperando, y decide mostrarle lo que es Tomorrowland: un lugar en el que las mentes más brillantes buscan la salvación de la humanidad. Brad Bird dirige 'Tomorrowland: El mundo del mañana', después de triunfar con 'Los Increíbles' o 'Misión Imposible: Protocolo Fantasma'.",
                    'created_at' => '2015-05-06 00:00:00'
                )
            )
        );
    }
}
