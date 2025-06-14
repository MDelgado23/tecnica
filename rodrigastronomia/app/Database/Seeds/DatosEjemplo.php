<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatosEjemplo extends Seeder
{
    public function run()
    {
         $this->db->table('usuarios')->insertBatch([
            [
                'nombre' => 'Rodrigo Admin',
                'email'  => 'admin@rodri.com',
                'celnum' => '1111111111',
                'rol'    => 'admin'
            ],
            [
                'nombre' => 'Juana Cliente',
                'email'  => 'juana@gmail.com',
                'celnum' => '2222222222',
                'rol'    => 'cliente'
            ],
            [
                'nombre' => 'Carlos Cliente',
                'email'  => 'carlos@gmail.com',
                'celnum' => '3333333333',
                'rol'    => 'cliente'
            ]
        ]);

        $this->db->table('cursos')->insertBatch([
             [
                'nombre' => 'Pastelería Básica',
                'descripcion' => 'Curso de repostería inicial.',
                'precio' => 5000,
                'detalles' => 'Incluye materiales',
                'imagen' => 'https://www.mausi.com/wp-content/uploads/2020/07/Lemon-Pie-Pasteleri%CC%81a-1.jpg',
                'modalidad' => 'Presencial',
                'duracion' => '2 meses'
            ],
            [
                'nombre' => 'Cocina Internacional',
                'descripcion' => 'Aprendé platos de todo el mundo.',
                'precio' => 7500,
                'detalles' => 'Se entrega recetario digital y certificado',
                'imagen' => 'https://www.recetasnestle.com.ar/sites/default/files/2022-02/que-es-la-comida-internacional.jpg',
                'modalidad' => 'Virtual',
                'duracion' => '8 clases'
            ],
            [
                'nombre' => 'Panadería Artesanal',
                'descripcion' => 'Hacé pan como un profesional.',
                'precio' => 6500,
                'detalles' => 'Incluye prácticas con masa madre',
                'imagen' => 'https://panpillon.com/wp-content/uploads/2024/05/Panaderia-Artesanal.jpg',
                'modalidad' => 'Presencial',
                'duracion' => '4 semanas'
            ],
            [
                'nombre' => 'Cocina Vegana',
                'descripcion' => 'Recetas saludables y sin origen animal.',
                'precio' => 7200,
                'detalles' => 'Recetario digital incluido. Sin productos de origen animal.',
                'imagen' => 'https://www.wekookmarketing.com/wp-content/uploads/2023/03/cocina-vegetariana-2023.png',
                'modalidad' => 'Virtual',
                'duracion' => '6 clases'
            ],
            [
                'nombre' => 'Decoración de Tortas',
                'descripcion' => 'Técnicas modernas y clásicas.',
                'precio' => 6800,
                'detalles' => 'Incluye uso de manga, fondant y aerógrafo',
                'imagen' => 'https://i.ytimg.com/vi/eqFZy-fWHuE/sddefault.jpg',
                'modalidad' => 'Presencial',
                'duracion' => '1 mes'
            ],
            [
                'nombre' => 'Cocina para Principiantes',
                'descripcion' => 'Ideal para quienes empiezan.',
                'precio' => 4800,
                'detalles' => 'No se requieren conocimientos previos',
                'imagen' => 'https://cocina-familiar.com/wp-content/uploads/2023/04/recetas-faciles-para-principiantes.jpg',
                'modalidad' => 'Virtual',
                'duracion' => '4 clases'
            ],
            [
                'nombre' => 'Pastas Caseras',
                'descripcion' => 'Fideos, salsas y más.',
                'precio' => 6200,
                'detalles' => 'Incluye clases prácticas y recetario',
                'imagen' => 'https://www.laespanolaaceites.com/wp-content/uploads/2019/05/pasta-fresca-casera-1080x671.jpg',
                'modalidad' => 'Presencial',
                'duracion' => '3 semanas'
            ],
            [
                'nombre' => 'Barismo Profesional',
                'descripcion' => 'El arte del café.',
                'precio' => 7000,
                'detalles' => 'Cata y práctica con espresso y latte art',
                'imagen' => 'https://www.argentinaproduct.com/ckfinder/userfiles/files/blog/barista.png',
                'modalidad' => 'Virtual',
                'duracion' => '5 clases'
            ],
            [
                'nombre' => 'Cocina Mediterránea',
                'descripcion' => 'Sabores del mar y la tierra.',
                'precio' => 7700,
                'detalles' => 'Incluye ingredientes de temporada y recetario',
                'imagen' => 'https://imag.bonviveur.com/mediterranea.jpg',
                'modalidad' => 'Presencial',
                'duracion' => '6 clases'
            ],
            [
                'nombre' => 'Heladería Artesanal',
                'descripcion' => 'Elaboración desde cero.',
                'precio' => 6900,
                'detalles' => 'Técnicas con y sin máquina de helado',
                'imagen' => 'https://heladin.com/wp-content/uploads/2018/10/obrador-helado-artesanal.jpg',
                'modalidad' => 'Presencial',
                'duracion' => '3 semanas'
            ]
        ]);
    }
}
