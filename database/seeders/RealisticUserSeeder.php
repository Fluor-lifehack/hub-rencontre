<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Conversation;
use App\Models\Country;
use App\Models\Message;
use App\Models\Photo;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Database\Seeder;

class RealisticUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Ce seeder crée des utilisateurs très réalistes avec des profils détaillés
     */
    public function run(): void
    {
        $this->command->info('Création d\'utilisateurs réalistes avec profils détaillés...');

        // Créer des utilisateurs avec des profils très réalistes
        $this->createRealisticUsers();

        $this->command->info('Création de photos pour les utilisateurs...');

        // Créer des photos pour tous les utilisateurs
        $this->createRealisticPhotos();

        $this->command->info('Création de matches réalistes...');

        // Créer des matches réalistes
        $this->createRealisticMatches();

        $this->command->info('Création de conversations réalistes...');

        // Créer des conversations réalistes
        $this->createRealisticConversations();

        $this->command->info('Création terminée !');
    }

    private function createRealisticUsers(): void
    {
        $france = Country::where('code', 'FR')->first();
        $paris = City::where('name', 'Paris')->first();
        $lyon = City::where('name', 'Lyon')->first();
        $marseille = City::where('name', 'Marseille')->first();
        $toulouse = City::where('name', 'Toulouse')->first();
        $nice = City::where('name', 'Nice')->first();
        $nantes = City::where('name', 'Nantes')->first();
        $strasbourg = City::where('name', 'Strasbourg')->first();
        $bordeaux = City::where('name', 'Bordeaux')->first();
        $lille = City::where('name', 'Lille')->first();

        $realisticUsers = [
            // Profils féminins variés
            [
                'name' => 'Amélie Rousseau',
                'email' => 'amelie.rousseau@example.com',
                'phone' => '06 12 34 56 78',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_certified' => true,
                'city' => $paris,
                'profile' => [
                    'bio' => 'Architecte d\'intérieur passionnée, je crée des espaces harmonieux et fonctionnels. J\'aime l\'art contemporain, les musées et les brunchs du dimanche. Je cherche quelqu\'un qui partage ma passion pour la beauté et l\'esthétique.',
                    'gender' => 'female',
                    'age' => 29,
                    'height' => 168,
                    'hobbies' => ['Architecture', 'Art contemporain', 'Musées', 'Design', 'Brunch', 'Voyage', 'Photographie'],
                ],
            ],
            [
                'name' => 'Camille Dubois',
                'email' => 'camille.dubois@example.com',
                'phone' => '06 23 45 67 89',
                'is_certified' => false,
                'city' => $lyon,
                'profile' => [
                    'bio' => 'Chef pâtissière créative, je transforme les ingrédients en œuvres d\'art comestibles. J\'adore cuisiner pour mes amis et découvrir de nouveaux restaurants. Je cherche quelqu\'un qui apprécie la bonne cuisine et les moments conviviaux.',
                    'gender' => 'female',
                    'age' => 26,
                    'height' => 162,
                    'hobbies' => ['Pâtisserie', 'Cuisine', 'Restaurants', 'Gastronomie', 'Amis', 'Créativité', 'Dégustation'],
                ],
            ],
            [
                'name' => 'Léa Martin',
                'email' => 'lea.martin@example.com',
                'phone' => '06 34 56 78 90',
                'is_certified' => true,
                'city' => $marseille,
                'profile' => [
                    'bio' => 'Médecin généraliste dévouée, j\'aime aider les autres et prendre soin de ma communauté. Je pratique le yoga pour me détendre et j\'adore les sorties en mer. Je cherche quelqu\'un de bienveillant et généreux.',
                    'gender' => 'female',
                    'age' => 32,
                    'height' => 165,
                    'hobbies' => ['Médecine', 'Yoga', 'Mer', 'Sport', 'Bien-être', 'Nature', 'Voyage'],
                ],
            ],
            [
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@example.com',
                'phone' => '06 45 67 89 01',
                'is_certified' => false,
                'city' => $toulouse,
                'profile' => [
                    'bio' => 'Ingénieure aérospatiale passionnée, je travaille sur des projets innovants dans l\'aviation. J\'aime la science, les défis techniques et les sorties en montagne. Je cherche quelqu\'un qui partage ma curiosité intellectuelle.',
                    'gender' => 'female',
                    'age' => 28,
                    'height' => 170,
                    'hobbies' => ['Aérospatial', 'Science', 'Montagne', 'Technologie', 'Innovation', 'Sport', 'Lecture'],
                ],
            ],
            [
                'name' => 'Emma Petit',
                'email' => 'emma.petit@example.com',
                'phone' => '06 56 78 90 12',
                'is_certified' => true,
                'city' => $nice,
                'profile' => [
                    'bio' => 'Professeure de français passionnée, j\'aime transmettre ma passion pour la littérature et les mots. Je pratique la danse et j\'adore les festivals culturels. Je cherche quelqu\'un de cultivé et ouvert d\'esprit.',
                    'gender' => 'female',
                    'age' => 30,
                    'height' => 164,
                    'hobbies' => ['Littérature', 'Danse', 'Culture', 'Festivals', 'Enseignement', 'Musique', 'Théâtre'],
                ],
            ],
            [
                'name' => 'Julie Moreau',
                'email' => 'julie.moreau@example.com',
                'phone' => '06 67 89 01 23',
                'is_certified' => false,
                'city' => $nantes,
                'profile' => [
                    'bio' => 'Designer graphique créative, je donne vie aux idées à travers le design. J\'aime l\'art contemporain, les expositions et les soirées entre amis. Je cherche quelqu\'un d\'artistique et créatif.',
                    'gender' => 'female',
                    'age' => 27,
                    'height' => 167,
                    'hobbies' => ['Design', 'Art contemporain', 'Expositions', 'Créativité', 'Amis', 'Culture', 'Musées'],
                ],
            ],
            [
                'name' => 'Manon Blanc',
                'email' => 'manon.blanc@example.com',
                'phone' => '06 78 90 12 34',
                'is_certified' => true,
                'city' => $strasbourg,
                'profile' => [
                    'bio' => 'Juriste européenne passionnée, je travaille sur des dossiers internationaux. J\'aime les langues, les voyages et les discussions intellectuelles. Je cherche quelqu\'un d\'ouvert sur le monde.',
                    'gender' => 'female',
                    'age' => 31,
                    'height' => 169,
                    'hobbies' => ['Droit', 'Europe', 'Langues', 'Voyage', 'Culture', 'Politique', 'Lecture'],
                ],
            ],
            [
                'name' => 'Chloé Simon',
                'email' => 'chloe.simon@example.com',
                'phone' => '06 89 01 23 45',
                'is_certified' => false,
                'city' => $bordeaux,
                'profile' => [
                    'bio' => 'Sommelière passionnée, je déguste et sélectionne les meilleurs vins. J\'adore les dégustations, les visites de domaines et les moments conviviaux. Je cherche quelqu\'un qui apprécie les bonnes choses.',
                    'gender' => 'female',
                    'age' => 29,
                    'height' => 166,
                    'hobbies' => ['Vin', 'Dégustation', 'Gastronomie', 'Culture', 'Voyage', 'Convivialité', 'Art'],
                ],
            ],
            [
                'name' => 'Aurélie Durand',
                'email' => 'aurelie.durand@example.com',
                'phone' => '06 90 12 34 56',
                'is_certified' => true,
                'city' => $lille,
                'profile' => [
                    'bio' => 'Commerçante dynamique, je gère ma propre boutique de mode. J\'aime la mode, les braderies et l\'accueil chaleureux du Nord. Je cherche quelqu\'un de chaleureux et authentique.',
                    'gender' => 'female',
                    'age' => 27,
                    'height' => 163,
                    'hobbies' => ['Mode', 'Commerce', 'Braderies', 'Culture', 'Amis', 'Shopping', 'Authenticité'],
                ],
            ],
            [
                'name' => 'Fanny Roux',
                'email' => 'fanny.roux@example.com',
                'phone' => '06 01 23 45 67',
                'is_certified' => false,
                'city' => $paris,
                'profile' => [
                    'bio' => 'Psychologue bienveillante, j\'aide les gens à mieux se comprendre. Je pratique la méditation et j\'adore la nature. Je cherche quelqu\'un de sensible et ouvert d\'esprit.',
                    'gender' => 'female',
                    'age' => 33,
                    'height' => 168,
                    'hobbies' => ['Psychologie', 'Méditation', 'Nature', 'Bien-être', 'Lecture', 'Voyage', 'Art'],
                ],
            ],

            // Profils masculins variés
            [
                'name' => 'Pierre Martin',
                'email' => 'pierre.martin@example.com',
                'phone' => '06 12 34 56 78',
                'is_certified' => true,
                'city' => $paris,
                'profile' => [
                    'bio' => 'Développeur full-stack passionné, je crée des applications innovantes. J\'aime la technologie, les startups et les sorties entre amis. Je cherche quelqu\'un qui partage ma passion pour l\'innovation.',
                    'gender' => 'male',
                    'age' => 29,
                    'height' => 182,
                    'hobbies' => ['Développement', 'Technologie', 'Startups', 'Innovation', 'Amis', 'Sport', 'Gaming'],
                ],
            ],
            [
                'name' => 'Antoine Dubois',
                'email' => 'antoine.dubois@example.com',
                'phone' => '06 23 45 67 89',
                'is_certified' => false,
                'city' => $lyon,
                'profile' => [
                    'bio' => 'Chef cuisinier créatif, je transforme les ingrédients en plats exceptionnels. J\'adore recevoir mes amis et découvrir de nouveaux restaurants. Je cherche quelqu\'un qui apprécie la bonne cuisine.',
                    'gender' => 'male',
                    'age' => 32,
                    'height' => 178,
                    'hobbies' => ['Cuisine', 'Gastronomie', 'Restaurants', 'Amis', 'Créativité', 'Voyage', 'Dégustation'],
                ],
            ],
            [
                'name' => 'Lucas Rousseau',
                'email' => 'lucas.rousseau@example.com',
                'phone' => '06 34 56 78 90',
                'is_certified' => true,
                'city' => $marseille,
                'profile' => [
                    'bio' => 'Photographe de mariage passionné, je capture les moments précieux de la vie. J\'aime la mer, le surf et les sorties en nature. Je cherche quelqu\'un qui aime l\'aventure et la beauté.',
                    'gender' => 'male',
                    'age' => 28,
                    'height' => 185,
                    'hobbies' => ['Photographie', 'Mer', 'Surf', 'Nature', 'Aventure', 'Sport', 'Art'],
                ],
            ],
            [
                'name' => 'Thomas Laurent',
                'email' => 'thomas.laurent@example.com',
                'phone' => '06 45 67 89 01',
                'is_certified' => false,
                'city' => $toulouse,
                'profile' => [
                    'bio' => 'Ingénieur aérospatial passionné, je travaille sur des projets d\'aviation innovants. J\'aime la science, les défis techniques et les sorties en montagne. Je cherche quelqu\'un qui partage ma curiosité.',
                    'gender' => 'male',
                    'age' => 31,
                    'height' => 180,
                    'hobbies' => ['Aérospatial', 'Science', 'Montagne', 'Technologie', 'Innovation', 'Sport', 'Lecture'],
                ],
            ],
            [
                'name' => 'Nicolas Petit',
                'email' => 'nicolas.petit@example.com',
                'phone' => '06 56 78 90 12',
                'is_certified' => true,
                'city' => $nice,
                'profile' => [
                    'bio' => 'Entrepreneur dans le digital, je crée des solutions innovantes pour les entreprises. J\'aime l\'innovation, les startups et les soirées sur la Promenade des Anglais. Je cherche quelqu\'un d\'ambitieux.',
                    'gender' => 'male',
                    'age' => 33,
                    'height' => 176,
                    'hobbies' => ['Entrepreneuriat', 'Digital', 'Innovation', 'Startups', 'Mer', 'Sport', 'Voyage'],
                ],
            ],
            [
                'name' => 'Julien Moreau',
                'email' => 'julien.moreau@example.com',
                'phone' => '06 67 89 01 23',
                'is_certified' => false,
                'city' => $nantes,
                'profile' => [
                    'bio' => 'Architecte créatif, je conçois des bâtiments durables et esthétiques. J\'aime l\'art contemporain, les musées et les discussions culturelles. Je cherche quelqu\'un d\'artistique et cultivé.',
                    'gender' => 'male',
                    'age' => 30,
                    'height' => 183,
                    'hobbies' => ['Architecture', 'Art contemporain', 'Musées', 'Culture', 'Créativité', 'Design', 'Voyage'],
                ],
            ],
            [
                'name' => 'Maxime Blanc',
                'email' => 'maxime.blanc@example.com',
                'phone' => '06 78 90 12 34',
                'is_certified' => true,
                'city' => $strasbourg,
                'profile' => [
                    'bio' => 'Juriste européen passionné, je travaille sur des dossiers internationaux. J\'aime les langues, les voyages et les discussions intellectuelles. Je cherche quelqu\'un d\'ouvert sur le monde.',
                    'gender' => 'male',
                    'age' => 35,
                    'height' => 181,
                    'hobbies' => ['Droit', 'Europe', 'Langues', 'Voyage', 'Culture', 'Politique', 'Lecture'],
                ],
            ],
            [
                'name' => 'Baptiste Simon',
                'email' => 'baptiste.simon@example.com',
                'phone' => '06 89 01 23 45',
                'is_certified' => false,
                'city' => $bordeaux,
                'profile' => [
                    'bio' => 'Sommelier passionné, je déguste et sélectionne les meilleurs vins. J\'adore les dégustations, les visites de domaines et les moments conviviaux. Je cherche quelqu\'un qui apprécie les bonnes choses.',
                    'gender' => 'male',
                    'age' => 30,
                    'height' => 179,
                    'hobbies' => ['Vin', 'Dégustation', 'Gastronomie', 'Culture', 'Voyage', 'Convivialité', 'Art'],
                ],
            ],
            [
                'name' => 'Quentin Durand',
                'email' => 'quentin.durand@example.com',
                'phone' => '06 90 12 34 56',
                'is_certified' => true,
                'city' => $lille,
                'profile' => [
                    'bio' => 'Commerçant dynamique, je gère ma propre boutique de sport. J\'aime le football, les braderies et l\'accueil chaleureux du Nord. Je cherche quelqu\'un de chaleureux et authentique.',
                    'gender' => 'male',
                    'age' => 28,
                    'height' => 184,
                    'hobbies' => ['Sport', 'Commerce', 'Football', 'Braderies', 'Amis', 'Culture', 'Authenticité'],
                ],
            ],
            [
                'name' => 'Alexandre Roux',
                'email' => 'alexandre.roux@example.com',
                'phone' => '06 01 23 45 67',
                'is_certified' => false,
                'city' => $paris,
                'profile' => [
                    'bio' => 'Médecin spécialiste passionné, je me consacre à aider mes patients. Je pratique le tennis et j\'adore la musique classique. Je cherche quelqu\'un de bienveillant et cultivé.',
                    'gender' => 'male',
                    'age' => 34,
                    'height' => 177,
                    'hobbies' => ['Médecine', 'Tennis', 'Musique classique', 'Culture', 'Sport', 'Lecture', 'Voyage'],
                ],
            ],
        ];

        foreach ($realisticUsers as $userData) {
            $city = $userData['city'];
            $profileData = $userData['profile'];
            unset($userData['city'], $userData['profile']);

            // Ajouter le mot de passe si pas déjà présent
            if (!isset($userData['password'])) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make('password');
            }

            // Générer un email unique
            $userData['email'] = 'realistic_' . uniqid() . '@example.com';

            // Générer un téléphone unique
            $userData['phone'] = '06 ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99);

            $user = User::create($userData);

            Profile::create([
                'user_id' => $user->id,
                'country_id' => $france->id,
                'city_id' => $city->id,
                ...$profileData,
            ]);
        }
    }

    private function createRealisticPhotos(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // 2 à 6 photos par utilisateur
            $photoCount = rand(2, 6);

            for ($i = 0; $i < $photoCount; $i++) {
                Photo::create([
                    'user_id' => $user->id,
                    'path' => 'photos/user-'.$user->id.'-photo-'.($i + 1).'.jpg',
                    'is_profile' => $i === 0, // La première photo est la photo de profil
                ]);
            }
        }
    }

    private function createRealisticMatches(): void
    {
        $users = User::all();
        $matchCount = 0;
        $maxMatches = 200; // Limiter le nombre de matches

        foreach ($users as $user) {
            if ($matchCount >= $maxMatches) {
                break;
            }

            // Créer 2 à 5 matches par utilisateur
            $userMatches = rand(2, 5);

            for ($i = 0; $i < $userMatches; $i++) {
                $matchedUser = $users->where('id', '!=', $user->id)->random();

                // Vérifier si le match n'existe pas déjà
                $existingMatch = UserMatch::where(function ($query) use ($user, $matchedUser) {
                    $query->where('user_id', $user->id)
                        ->where('matched_user_id', $matchedUser->id);
                })->orWhere(function ($query) use ($user, $matchedUser) {
                    $query->where('user_id', $matchedUser->id)
                        ->where('matched_user_id', $user->id);
                })->first();

                if (! $existingMatch) {
                    UserMatch::create([
                        'user_id' => $user->id,
                        'matched_user_id' => $matchedUser->id,
                        'compatibility_score' => rand(70, 98) / 100, // Score entre 0.7 et 0.98
                        'is_mutual' => rand(0, 1) === 1, // 50% de chance d'être mutuel
                        'uuid' => \Illuminate\Support\Str::uuid(),
                    ]);

                    $matchCount++;
                }
            }
        }
    }

    private function createRealisticConversations(): void
    {
        // Créer des conversations pour les matches mutuels
        $mutualMatches = UserMatch::where('is_mutual', true)->get();

        foreach ($mutualMatches as $match) {
            // Vérifier si la conversation n'existe pas déjà
            $existingConversation = Conversation::where(function($query) use ($match) {
                $query->where('user_one', $match->user_id)
                      ->where('user_two', $match->matched_user_id);
            })->orWhere(function($query) use ($match) {
                $query->where('user_one', $match->matched_user_id)
                      ->where('user_two', $match->user_id);
            })->first();

            if ($existingConversation) {
                continue; // Passer à la prochaine conversation
            }

            // Créer une conversation
            $conversation = Conversation::create([
                'user_one' => $match->user_id,
                'user_two' => $match->matched_user_id,
                'last_message_at' => now()->subDays(rand(0, 60)),
            ]);

            // Créer des messages réalistes pour chaque conversation
            $messageCount = rand(10, 50);
            $users = [$match->user_id, $match->matched_user_id];

            for ($i = 0; $i < $messageCount; $i++) {
                $senderId = $users[$i % 2]; // Alterner entre les deux utilisateurs

                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $senderId,
                    'content' => $this->generateRealisticMessage($i),
                    'is_read' => rand(0, 1) === 1,
                    'created_at' => $conversation->last_message_at->addMinutes($i * rand(5, 60)),
                ]);
            }
        }
    }

    private function generateRealisticMessage(int $index): string
    {
        $greetings = [
            'Salut ! Comment ça va ?',
            'Bonjour ! Comment allez-vous ?',
            'Coucou ! Comment ça va ?',
            'Hello ! Comment ça va ?',
            'Salut ! Comment allez-vous ?',
        ];

        $responses = [
            'Ça va bien merci ! Et toi ?',
            'Très bien merci ! Et vous ?',
            'Ça va super ! Et toi ?',
            'Très bien ! Et vous ?',
            'Ça va bien ! Et toi ?',
        ];

        $questions = [
            'Tu fais quoi dans la vie ?',
            'Vous travaillez dans quoi ?',
            'Tu pratiques un sport ?',
            'Vous aimez quoi comme musique ?',
            'Tu voyages souvent ?',
            'Vous habitez où exactement ?',
            'Tu aimes cuisiner ?',
            'Vous sortez souvent ?',
            'Tu lis beaucoup ?',
            'Vous regardez quoi comme films ?',
        ];

        $answers = [
            'Je suis ingénieur, et toi ?',
            'Je travaille dans la finance, et vous ?',
            'Je suis professeur, et toi ?',
            'Je suis médecin, et vous ?',
            'Je suis artiste, et toi ?',
            'Je suis dans le marketing, et vous ?',
            'Je suis avocat, et toi ?',
            'Je suis dans l\'informatique, et vous ?',
            'Je suis architecte, et toi ?',
            'Je suis dans le commerce, et vous ?',
        ];

        $suggestions = [
            'Tu veux qu\'on se rencontre ?',
            'Vous voulez qu\'on se voit ?',
            'On pourrait se voir ?',
            'Tu veux qu\'on aille boire un verre ?',
            'Vous voulez qu\'on aille au cinéma ?',
            'Tu veux qu\'on aille au restaurant ?',
            'On pourrait aller au musée ?',
            'Tu veux qu\'on aille en promenade ?',
            'Vous voulez qu\'on aille au théâtre ?',
            'Tu veux qu\'on aille au concert ?',
        ];

        $agreements = [
            'Avec plaisir !',
            'Excellente idée !',
            'Parfait !',
            'Super !',
            'Génial !',
            'Ça me va !',
            'Pourquoi pas !',
            'Avec grand plaisir !',
            'C\'est une bonne idée !',
            'J\'adore l\'idée !',
        ];

        $details = [
            'Quand est-ce que tu es libre ?',
            'Vous êtes libre quand ?',
            'Tu es libre ce weekend ?',
            'Vous êtes libre samedi ?',
            'Tu veux qu\'on se donne rendez-vous où ?',
            'Vous connaissez un bon endroit ?',
            'Tu connais le café du coin ?',
            'Vous connaissez le restaurant près de chez moi ?',
            'Tu veux qu\'on se retrouve où ?',
            'Vous préférez où ?',
        ];

        $confirmations = [
            'Parfait ! À samedi 15h alors ?',
            'Super ! À samedi 15h !',
            'Génial ! À samedi 15h !',
            'Parfait ! À samedi 15h !',
            'Super ! À samedi 15h !',
            'Génial ! À samedi 15h !',
            'Parfait ! À samedi 15h !',
            'Super ! À samedi 15h !',
            'Génial ! À samedi 15h !',
            'Parfait ! À samedi 15h !',
        ];

        $enthusiasm = [
            'J\'ai hâte de te rencontrer !',
            'Moi aussi ! 😊',
            'J\'ai hâte de vous rencontrer !',
            'Moi aussi ! 😍',
            'J\'ai hâte de te voir !',
            'Moi aussi ! 😊',
            'J\'ai hâte de vous voir !',
            'Moi aussi ! 😍',
            'J\'ai hâte de te connaître !',
            'Moi aussi ! 😊',
        ];

        $messages = [
            ...$greetings,
            ...$responses,
            ...$questions,
            ...$answers,
            ...$suggestions,
            ...$agreements,
            ...$details,
            ...$confirmations,
            ...$enthusiasm,
        ];

        return $messages[array_rand($messages)];
    }
}
