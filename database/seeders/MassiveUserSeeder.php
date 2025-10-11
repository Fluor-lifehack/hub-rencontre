<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Country;
use App\Models\City;
use Illuminate\Database\Seeder;

class MassiveUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Ce seeder crée un grand nombre d'utilisateurs réalistes
     */
    public function run(): void
    {
        $this->command->info('Création de 1000 utilisateurs supplémentaires...');

        // Créer 500 utilisateurs supplémentaires avec des emails vraiment uniques
        for ($i = 0; $i < 500; $i++) {
            User::factory()->create([
                'email' => 'user_' . uniqid() . '_' . $i . '@example.com',
            ]);
        }

        $this->command->info('Création de profils spécifiques par région...');

        // Créer des profils spécifiques par région française
        $this->createRegionalProfiles();

        $this->command->info('Création de profils internationaux...');

        // Créer des profils internationaux
        $this->createInternationalProfiles();

        $this->command->info('Création terminée !');
    }

    private function createRegionalProfiles(): void
    {
        $france = Country::where('code', 'FR')->first();

        $regionalProfiles = [
            // Paris et région parisienne
            [
                'name' => 'Emma Moreau',
                'email' => 'emma.moreau@example.com',
                'city' => 'Paris',
                'profile' => [
                    'bio' => 'Parisienne pure souche, j\'adore ma ville et ses secrets. Je travaille dans la mode et j\'aime découvrir de nouveaux quartiers.',
                    'gender' => 'female',
                    'age' => 26,
                    'height' => 168,
                    'hobbies' => ['Mode', 'Art', 'Café', 'Musées', 'Shopping']
                ]
            ],
            [
                'name' => 'Lucas Bernard',
                'email' => 'lucas.bernard@example.com',
                'city' => 'Paris',
                'profile' => [
                    'bio' => 'Développeur dans une startup parisienne. J\'aime l\'innovation et les soirées entre amis dans les bars branchés.',
                    'gender' => 'male',
                    'age' => 29,
                    'height' => 182,
                    'hobbies' => ['Technologie', 'Startup', 'Bars', 'Sport', 'Gaming']
                ]
            ],

            // Lyon et région
            [
                'name' => 'Chloé Dubois',
                'email' => 'chloe.dubois@example.com',
                'city' => 'Lyon',
                'profile' => [
                    'bio' => 'Lyonnaise passionnée de gastronomie. Je travaille dans un restaurant étoilé et j\'adore cuisiner.',
                    'gender' => 'female',
                    'age' => 31,
                    'height' => 165,
                    'hobbies' => ['Cuisine', 'Gastronomie', 'Vins', 'Marchés', 'Restaurants']
                ]
            ],
            [
                'name' => 'Thomas Roux',
                'email' => 'thomas.roux@example.com',
                'city' => 'Lyon',
                'profile' => [
                    'bio' => 'Ingénieur dans l\'automobile. J\'aime les voitures et les sorties en montagne le weekend.',
                    'gender' => 'male',
                    'age' => 34,
                    'height' => 178,
                    'hobbies' => ['Automobile', 'Montagne', 'Randonnée', 'Mécanique', 'Sport']
                ]
            ],

            // Marseille et région
            [
                'name' => 'Aurélie Martin',
                'email' => 'aurelie.martin@example.com',
                'city' => 'Marseille',
                'profile' => [
                    'bio' => 'Marseillaise de cœur, j\'adore la mer et le soleil. Je pratique la voile et j\'aime les apéros en terrasse.',
                    'gender' => 'female',
                    'age' => 27,
                    'height' => 162,
                    'hobbies' => ['Mer', 'Voile', 'Plage', 'Apéro', 'Sport nautique']
                ]
            ],
            [
                'name' => 'Julien Petit',
                'email' => 'julien.petit@example.com',
                'city' => 'Marseille',
                'profile' => [
                    'bio' => 'Surfeur et photographe. Je capture la beauté de la Méditerranée et j\'adore les sports nautiques.',
                    'gender' => 'male',
                    'age' => 25,
                    'height' => 185,
                    'hobbies' => ['Surf', 'Photographie', 'Mer', 'Sport', 'Nature']
                ]
            ],

            // Toulouse
            [
                'name' => 'Camille Blanc',
                'email' => 'camille.blanc@example.com',
                'city' => 'Toulouse',
                'profile' => [
                    'bio' => 'Toulousaine passionnée d\'aéronautique. Je travaille chez Airbus et j\'aime l\'aviation.',
                    'gender' => 'female',
                    'age' => 28,
                    'height' => 170,
                    'hobbies' => ['Aéronautique', 'Aviation', 'Science', 'Voyage', 'Lecture']
                ]
            ],
            [
                'name' => 'Nicolas Garcia',
                'email' => 'nicolas.garcia@example.com',
                'city' => 'Toulouse',
                'profile' => [
                    'bio' => 'Ingénieur aérospatial. J\'aime l\'innovation technologique et les sorties en montagne.',
                    'gender' => 'male',
                    'age' => 32,
                    'height' => 180,
                    'hobbies' => ['Aérospatial', 'Montagne', 'Technologie', 'Sport', 'Musique']
                ]
            ],

            // Nice et Côte d'Azur
            [
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@example.com',
                'city' => 'Nice',
                'profile' => [
                    'bio' => 'Niçoise amoureuse de la Riviera. Je travaille dans le tourisme et j\'adore les festivals de la région.',
                    'gender' => 'female',
                    'age' => 30,
                    'height' => 164,
                    'hobbies' => ['Tourisme', 'Festivals', 'Mer', 'Culture', 'Art']
                ]
            ],
            [
                'name' => 'Alexandre Moreau',
                'email' => 'alexandre.moreau@example.com',
                'city' => 'Nice',
                'profile' => [
                    'bio' => 'Entrepreneur dans le digital. J\'aime l\'innovation et les soirées sur la Promenade des Anglais.',
                    'gender' => 'male',
                    'age' => 33,
                    'height' => 176,
                    'hobbies' => ['Entrepreneuriat', 'Digital', 'Innovation', 'Mer', 'Sport']
                ]
            ],

            // Nantes
            [
                'name' => 'Julie Rousseau',
                'email' => 'julie.rousseau@example.com',
                'city' => 'Nantes',
                'profile' => [
                    'bio' => 'Nantaise créative, je travaille dans le design. J\'aime l\'art contemporain et les machines de l\'île.',
                    'gender' => 'female',
                    'age' => 29,
                    'height' => 167,
                    'hobbies' => ['Design', 'Art contemporain', 'Créativité', 'Culture', 'Musées']
                ]
            ],
            [
                'name' => 'Maxime Durand',
                'email' => 'maxime.durand@example.com',
                'city' => 'Nantes',
                'profile' => [
                    'bio' => 'Développeur web passionné. J\'aime la tech et les sorties culturelles dans ma ville.',
                    'gender' => 'male',
                    'age' => 26,
                    'height' => 183,
                    'hobbies' => ['Développement', 'Tech', 'Culture', 'Musique', 'Sport']
                ]
            ],

            // Strasbourg
            [
                'name' => 'Claire Muller',
                'email' => 'claire.muller@example.com',
                'city' => 'Strasbourg',
                'profile' => [
                    'bio' => 'Strasbourgeoise bilingue, je travaille dans les institutions européennes. J\'aime la culture franco-allemande.',
                    'gender' => 'female',
                    'age' => 31,
                    'height' => 169,
                    'hobbies' => ['Europe', 'Langues', 'Culture', 'Voyage', 'Politique']
                ]
            ],
            [
                'name' => 'Florian Weber',
                'email' => 'florian.weber@example.com',
                'city' => 'Strasbourg',
                'profile' => [
                    'bio' => 'Juriste européen passionné. J\'aime le droit et les sorties dans les brasseries alsaciennes.',
                    'gender' => 'male',
                    'age' => 35,
                    'height' => 181,
                    'hobbies' => ['Droit', 'Europe', 'Brasseries', 'Culture', 'Lecture']
                ]
            ],

            // Bordeaux
            [
                'name' => 'Manon Leroy',
                'email' => 'manon.leroy@example.com',
                'city' => 'Bordeaux',
                'profile' => [
                    'bio' => 'Bordelaise amoureuse du vin. Je travaille dans le secteur viticole et j\'adore les dégustations.',
                    'gender' => 'female',
                    'age' => 28,
                    'height' => 166,
                    'hobbies' => ['Vin', 'Viticulture', 'Dégustation', 'Culture', 'Gastronomie']
                ]
            ],
            [
                'name' => 'Baptiste Simon',
                'email' => 'baptiste.simon@example.com',
                'city' => 'Bordeaux',
                'profile' => [
                    'bio' => 'Sommelier passionné. J\'aime découvrir de nouveaux vins et partager mes connaissances.',
                    'gender' => 'male',
                    'age' => 30,
                    'height' => 179,
                    'hobbies' => ['Vin', 'Sommelier', 'Dégustation', 'Gastronomie', 'Culture']
                ]
            ],

            // Lille
            [
                'name' => 'Léa Petit',
                'email' => 'lea.petit@example.com',
                'city' => 'Lille',
                'profile' => [
                    'bio' => 'Lilloise chaleureuse, j\'aime l\'accueil du Nord. Je travaille dans le commerce et j\'adore les braderies.',
                    'gender' => 'female',
                    'age' => 27,
                    'height' => 163,
                    'hobbies' => ['Commerce', 'Braderies', 'Culture', 'Amis', 'Shopping']
                ]
            ],
            [
                'name' => 'Quentin Martin',
                'email' => 'quentin.martin@example.com',
                'city' => 'Lille',
                'profile' => [
                    'bio' => 'Lillois sportif, je pratique le football et j\'aime les sorties entre amis dans les estaminets.',
                    'gender' => 'male',
                    'age' => 24,
                    'height' => 184,
                    'hobbies' => ['Football', 'Sport', 'Amis', 'Estaminets', 'Culture']
                ]
            ]
        ];

        foreach ($regionalProfiles as $userData) {
            $city = City::where('name', $userData['city'])->first();
            $profileData = $userData['profile'];
            unset($userData['city'], $userData['profile']);

            // Ajouter le mot de passe si pas déjà présent
            if (!isset($userData['password'])) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make('password');
            }

            // Générer un téléphone unique
            $userData['phone'] = '06 ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99);

            // Générer un email unique
            $userData['email'] = 'regional_' . uniqid() . '@example.com';

            $user = User::create($userData);

            Profile::create([
                'user_id' => $user->id,
                'country_id' => $france->id,
                'city_id' => $city->id,
                ...$profileData
            ]);
        }
    }

    private function createInternationalProfiles(): void
    {
        $belgium = Country::where('code', 'BE')->first();
        $switzerland = Country::where('code', 'CH')->first();
        $canada = Country::where('code', 'CA')->first();

        $internationalProfiles = [
            // Belgique
            [
                'name' => 'Emma Van Der Berg',
                'email' => 'emma.vanderberg@example.com',
                'country' => 'BE',
                'city' => 'Bruxelles',
                'profile' => [
                    'bio' => 'Bruxelloise polyglotte, je travaille dans les institutions européennes. J\'aime la culture et les musées.',
                    'gender' => 'female',
                    'age' => 29,
                    'height' => 168,
                    'hobbies' => ['Langues', 'Europe', 'Musées', 'Culture', 'Voyage']
                ]
            ],
            [
                'name' => 'Thomas De Vries',
                'email' => 'thomas.devries@example.com',
                'country' => 'BE',
                'city' => 'Anvers',
                'profile' => [
                    'bio' => 'Anversois dans le diamant, j\'aime l\'art et les sorties culturelles. Je pratique le vélo.',
                    'gender' => 'male',
                    'age' => 32,
                    'height' => 182,
                    'hobbies' => ['Diamant', 'Art', 'Culture', 'Vélo', 'Sport']
                ]
            ],

            // Suisse
            [
                'name' => 'Sophie Müller',
                'email' => 'sophie.muller@example.com',
                'country' => 'CH',
                'city' => 'Zurich',
                'profile' => [
                    'bio' => 'Zurichoise dans la finance, j\'aime la montagne et les sports d\'hiver. Je pratique le ski.',
                    'gender' => 'female',
                    'age' => 30,
                    'height' => 165,
                    'hobbies' => ['Finance', 'Montagne', 'Ski', 'Sport', 'Nature']
                ]
            ],
            [
                'name' => 'Marc Dubois',
                'email' => 'marc.dubois@example.com',
                'country' => 'CH',
                'city' => 'Genève',
                'profile' => [
                    'bio' => 'Genevois dans l\'horlogerie, j\'aime la précision et les sorties au lac. Je pratique la voile.',
                    'gender' => 'male',
                    'age' => 33,
                    'height' => 180,
                    'hobbies' => ['Horlogerie', 'Précision', 'Lac', 'Voile', 'Sport']
                ]
            ],

            // Canada
            [
                'name' => 'Marie Tremblay',
                'email' => 'marie.tremblay@example.com',
                'country' => 'CA',
                'city' => 'Montréal',
                'profile' => [
                    'bio' => 'Montréalaise bilingue, je travaille dans le cinéma. J\'aime l\'hiver et les festivals.',
                    'gender' => 'female',
                    'age' => 28,
                    'height' => 167,
                    'hobbies' => ['Cinéma', 'Festivals', 'Hiver', 'Culture', 'Art']
                ]
            ],
            [
                'name' => 'Jean-Pierre Gagnon',
                'email' => 'jeanpierre.gagnon@example.com',
                'country' => 'CA',
                'city' => 'Québec',
                'profile' => [
                    'bio' => 'Québécois passionné d\'histoire, je travaille dans le tourisme. J\'aime l\'hiver et le hockey.',
                    'gender' => 'male',
                    'age' => 31,
                    'height' => 185,
                    'hobbies' => ['Histoire', 'Tourisme', 'Hiver', 'Hockey', 'Sport']
                ]
            ]
        ];

        foreach ($internationalProfiles as $userData) {
            $country = Country::where('code', $userData['country'])->first();
            $city = City::where('name', $userData['city'])->first();
            $profileData = $userData['profile'];
            unset($userData['country'], $userData['city'], $userData['profile']);

            // Ajouter le mot de passe si pas déjà présent
            if (!isset($userData['password'])) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make('password');
            }

            // Générer un téléphone unique
            $userData['phone'] = '+33 6 ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99);

            // Générer un email unique
            $userData['email'] = 'international_' . uniqid() . '@example.com';

            $user = User::create($userData);

            Profile::create([
                'user_id' => $user->id,
                'country_id' => $country->id,
                'city_id' => $city->id,
                ...$profileData
            ]);
        }
    }
}
