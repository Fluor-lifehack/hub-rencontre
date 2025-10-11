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

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des pays si ils n'existent pas
        $this->createCountries();

        // Créer des villes si elles n'existent pas
        $this->createCities();

        // Créer des utilisateurs avec profils
        $this->createUsers();

        // Créer des photos pour certains utilisateurs
        $this->createPhotos();

        // Créer des matches
        $this->createMatches();

        // Créer des conversations et messages
        $this->createConversations();
    }

    private function createCountries(): void
    {
        $countries = [
            ['name' => 'France', 'code' => 'FR'],
            ['name' => 'Belgique', 'code' => 'BE'],
            ['name' => 'Suisse', 'code' => 'CH'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'Espagne', 'code' => 'ES'],
            ['name' => 'Italie', 'code' => 'IT'],
            ['name' => 'Allemagne', 'code' => 'DE'],
            ['name' => 'Royaume-Uni', 'code' => 'GB'],
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate(
                ['code' => $country['code']],
                $country
            );
        }
    }

    private function createCities(): void
    {
        $france = Country::where('code', 'FR')->first();
        $belgium = Country::where('code', 'BE')->first();
        $switzerland = Country::where('code', 'CH')->first();
        $canada = Country::where('code', 'CA')->first();

        $cities = [
            // France
            ['name' => 'Paris', 'country_id' => $france->id],
            ['name' => 'Lyon', 'country_id' => $france->id],
            ['name' => 'Marseille', 'country_id' => $france->id],
            ['name' => 'Toulouse', 'country_id' => $france->id],
            ['name' => 'Nice', 'country_id' => $france->id],
            ['name' => 'Nantes', 'country_id' => $france->id],
            ['name' => 'Strasbourg', 'country_id' => $france->id],
            ['name' => 'Montpellier', 'country_id' => $france->id],
            ['name' => 'Bordeaux', 'country_id' => $france->id],
            ['name' => 'Lille', 'country_id' => $france->id],
            ['name' => 'Rennes', 'country_id' => $france->id],
            ['name' => 'Reims', 'country_id' => $france->id],
            ['name' => 'Toulon', 'country_id' => $france->id],
            ['name' => 'Grenoble', 'country_id' => $france->id],
            ['name' => 'Dijon', 'country_id' => $france->id],
            ['name' => 'Angers', 'country_id' => $france->id],
            ['name' => 'Nîmes', 'country_id' => $france->id],
            ['name' => 'Villeurbanne', 'country_id' => $france->id],
            ['name' => 'Saint-Étienne', 'country_id' => $france->id],
            ['name' => 'Le Havre', 'country_id' => $france->id],

            // Belgique
            ['name' => 'Bruxelles', 'country_id' => $belgium->id],
            ['name' => 'Anvers', 'country_id' => $belgium->id],
            ['name' => 'Gand', 'country_id' => $belgium->id],
            ['name' => 'Charleroi', 'country_id' => $belgium->id],
            ['name' => 'Liège', 'country_id' => $belgium->id],
            ['name' => 'Bruges', 'country_id' => $belgium->id],

            // Suisse
            ['name' => 'Zurich', 'country_id' => $switzerland->id],
            ['name' => 'Genève', 'country_id' => $switzerland->id],
            ['name' => 'Bâle', 'country_id' => $switzerland->id],
            ['name' => 'Berne', 'country_id' => $switzerland->id],
            ['name' => 'Lausanne', 'country_id' => $switzerland->id],

            // Canada
            ['name' => 'Montréal', 'country_id' => $canada->id],
            ['name' => 'Québec', 'country_id' => $canada->id],
            ['name' => 'Toronto', 'country_id' => $canada->id],
            ['name' => 'Vancouver', 'country_id' => $canada->id],
        ];

        foreach ($cities as $city) {
            City::firstOrCreate(
                ['name' => $city['name'], 'country_id' => $city['country_id']],
                $city
            );
        }
    }

    private function createUsers(): void
    {
        // Créer 50 utilisateurs avec profils complets
        User::factory(50)->create();

        // Créer quelques utilisateurs spécifiques pour les tests
        $this->createSpecificUsers();
    }

    private function createSpecificUsers(): void
    {
        $france = Country::where('code', 'FR')->first();
        $paris = City::where('name', 'Paris')->first();
        $lyon = City::where('name', 'Lyon')->first();
        $marseille = City::where('name', 'Marseille')->first();

        $specificUsers = [
            [
                'name' => 'Marie Dubois',
                'email' => 'marie.dubois@example.com',
                'phone' => '06 12 34 56 78',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_certified' => true,
                'profile' => [
                    'bio' => 'Passionnée de voyage et de photographie. J\'aime découvrir de nouveaux endroits et capturer les beaux moments. Je cherche quelqu\'un pour partager mes aventures.',
                    'gender' => 'female',
                    'age' => 28,
                    'city_id' => $paris->id,
                    'height' => 165,
                    'hobbies' => ['Voyage', 'Photographie', 'Cuisine', 'Danse', 'Cinéma'],
                ],
            ],
            [
                'name' => 'Pierre Martin',
                'email' => 'pierre.martin@example.com',
                'phone' => '06 98 76 54 32',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_certified' => true,
                'profile' => [
                    'bio' => 'Ingénieur passionné par la technologie et l\'innovation. Je pratique le tennis et j\'adore voyager. À la recherche d\'une personne avec qui construire quelque chose de beau.',
                    'gender' => 'male',
                    'age' => 32,
                    'city_id' => $lyon->id,
                    'height' => 180,
                    'hobbies' => ['Sport', 'Technologie', 'Voyage', 'Musique', 'Lecture'],
                ],
            ],
            [
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@example.com',
                'phone' => '06 55 44 33 22',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_certified' => false,
                'profile' => [
                    'bio' => 'Artiste peintre, j\'aime créer et exprimer mes émotions à travers l\'art. Je pratique le yoga et j\'adore les soirées entre amis.',
                    'gender' => 'female',
                    'age' => 25,
                    'city_id' => $marseille->id,
                    'height' => 160,
                    'hobbies' => ['Art', 'Peinture', 'Yoga', 'Musique', 'Théâtre'],
                ],
            ],
            [
                'name' => 'Antoine Rousseau',
                'email' => 'antoine.rousseau@example.com',
                'phone' => '06 11 22 33 44',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_certified' => true,
                'profile' => [
                    'bio' => 'Chef cuisinier passionné, j\'adore créer de nouveaux plats et recevoir mes amis. Je cherche quelqu\'un qui aime la bonne cuisine.',
                    'gender' => 'male',
                    'age' => 29,
                    'city_id' => $paris->id,
                    'height' => 175,
                    'hobbies' => ['Cuisine', 'Voyage', 'Sport', 'Musique', 'Cinéma'],
                ],
            ],
            [
                'name' => 'Camille Petit',
                'email' => 'camille.petit@example.com',
                'phone' => '06 99 88 77 66',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_certified' => false,
                'profile' => [
                    'bio' => 'Professeure de français, j\'aime la littérature et les discussions intellectuelles. Je pratique la danse et j\'adore les concerts.',
                    'gender' => 'female',
                    'age' => 30,
                    'city_id' => $lyon->id,
                    'height' => 168,
                    'hobbies' => ['Littérature', 'Danse', 'Musique', 'Voyage', 'Lecture'],
                ],
            ],
        ];

        foreach ($specificUsers as $userData) {
            $profileData = $userData['profile'];
            unset($userData['profile']);

            $user = User::create($userData);

            Profile::create([
                'user_id' => $user->id,
                ...$profileData,
            ]);
        }
    }

    private function createPhotos(): void
    {
        // Créer des photos pour 50% des utilisateurs
        $users = User::inRandomOrder()->limit(100)->get();

        foreach ($users as $user) {
            // 1 à 5 photos par utilisateur
            $photoCount = rand(1, 5);

            for ($i = 0; $i < $photoCount; $i++) {
                Photo::create([
                    'user_id' => $user->id,
                    'path' => 'photos/placeholder-'.rand(1, 20).'.jpg',
                    'is_profile' => $i === 0, // La première photo est la photo de profil
                ]);
            }
        }
    }

    private function createMatches(): void
    {
        $users = User::all();
        $matchCount = 0;
        $maxMatches = 150; // Limiter le nombre de matches pour éviter la surcharge

        foreach ($users as $user) {
            if ($matchCount >= $maxMatches) {
                break;
            }

            // Créer 1 à 3 matches par utilisateur
            $userMatches = rand(1, 3);

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
                        'compatibility_score' => rand(60, 95) / 100, // Score entre 0.6 et 0.95
                        'is_mutual' => rand(0, 1) === 1, // 50% de chance d'être mutuel
                        'uuid' => \Illuminate\Support\Str::uuid(),
                    ]);

                    $matchCount++;
                }
            }
        }
    }

    private function createConversations(): void
    {
        // Créer des conversations pour les matches mutuels
        $mutualMatches = UserMatch::where('is_mutual', true)->get();

        foreach ($mutualMatches as $match) {
            // Créer une conversation
            $conversation = Conversation::create([
                'user_one' => $match->user_id,
                'user_two' => $match->matched_user_id,
                'last_message_at' => now()->subDays(rand(0, 30)),
            ]);

            // Créer quelques messages pour chaque conversation
            $messageCount = rand(5, 20);
            $users = [$match->user_id, $match->matched_user_id];

            for ($i = 0; $i < $messageCount; $i++) {
                $senderId = $users[$i % 2]; // Alterner entre les deux utilisateurs

                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $senderId,
                    'content' => $this->generateMessageContent(),
                    'is_read' => rand(0, 1) === 1,
                    'created_at' => $conversation->last_message_at->addMinutes($i * 30),
                ]);
            }
        }
    }

    private function generateMessageContent(): string
    {
        $messages = [
            'Salut ! Comment ça va ?',
            'Ça va bien merci ! Et toi ?',
            'Très bien aussi ! Tu veux qu\'on se rencontre ?',
            'Avec plaisir ! Quand est-ce que tu es libre ?',
            'Ce weekend ça te va ?',
            'Parfait ! On se donne rendez-vous où ?',
            'Tu connais le café du coin ?',
            'Oui, c\'est un bon endroit !',
            'Super ! À samedi 15h alors ?',
            'Parfait, à samedi ! 😊',
            'J\'ai hâte de te rencontrer !',
            'Moi aussi ! 😍',
            'Tu fais quoi dans la vie ?',
            'Je suis ingénieur, et toi ?',
            'Je suis professeure de français',
            'C\'est super ! J\'adore la littérature',
            'Moi aussi ! Tu lis quoi en ce moment ?',
            'Je lis un livre de Murakami',
            'J\'adore cet auteur !',
            'Tu veux qu\'on en parle plus tard ?',
            'Avec plaisir !',
            'Tu pratiques un sport ?',
            'Oui, je fais du tennis',
            'Cool ! Moi je fais de la danse',
            'C\'est génial ! Tu danses quoi ?',
            'Du modern jazz principalement',
            'Tu veux qu\'on aille voir un spectacle ?',
            'Excellente idée !',
            'Tu voyages souvent ?',
            'Oui, j\'adore découvrir de nouveaux endroits',
            'Moi aussi ! Tu as visité où récemment ?',
            'Je suis allée en Italie le mois dernier',
            'C\'est magnifique ! J\'aimerais y aller',
            'Je peux te donner des conseils si tu veux !',
            'Ce serait super !',
            'Tu aimes la cuisine ?',
            'Oui, j\'adore cuisiner !',
            'Moi aussi ! Tu cuisines quoi ?',
            'Principalement de la cuisine française',
            'Parfait ! On pourrait cuisiner ensemble',
            'Excellente idée ! 😊',
            'Tu écoutes quoi comme musique ?',
            'J\'aime le jazz et la musique classique',
            'C\'est super ! Moi j\'aime le rock',
            'On a des goûts différents mais c\'est bien !',
            'Tout à fait ! Ça enrichit nos discussions',
            'Tu veux qu\'on aille au cinéma ?',
            'Avec plaisir ! Tu aimes quel genre ?',
            'J\'aime les films d\'auteur',
            'Moi aussi ! On a les mêmes goûts',
            'C\'est parfait ! 😊',
        ];

        return $messages[array_rand($messages)];
    }
}
