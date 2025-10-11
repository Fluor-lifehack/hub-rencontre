<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Profile;
use App\Models\Country;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genders = ['male', 'female', 'other'];
        $gender = $this->faker->randomElement($genders);

        // Générer des noms français réalistes selon le genre
        $name = $this->generateFrenchName($gender);

        return [
            'name' => $name,
            'email' => 'user_' . time() . '_' . rand(1000, 9999) . '@example.com',
            'phone' => $this->generateFrenchPhoneNumber(),
            'email_verified_at' => $this->faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
            'password' => static::$password ??= Hash::make('password'),
            'is_certified' => $this->faker->boolean(30), // 30% des utilisateurs certifiés
            'last_login_at' => $this->faker->optional(0.7)->dateTimeBetween('-30 days', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Generate a realistic French name based on gender
     */
    private function generateFrenchName(string $gender): string
    {
        $maleNames = [
            'Alexandre', 'Antoine', 'Baptiste', 'Benjamin', 'Charles', 'Clément', 'Damien', 'David',
            'Étienne', 'Fabien', 'Gabriel', 'Guillaume', 'Hugo', 'Julien', 'Kevin', 'Lucas',
            'Marc', 'Nicolas', 'Olivier', 'Pierre', 'Quentin', 'Romain', 'Sébastien', 'Thomas',
            'Vincent', 'Yann', 'Adrien', 'Arthur', 'Bastien', 'Cédric', 'Dylan', 'Emmanuel',
            'Florian', 'Grégoire', 'Hervé', 'Ivan', 'Jérémy', 'Kévin', 'Laurent', 'Mathieu',
            'Noé', 'Paul', 'Rémi', 'Simon', 'Tristan', 'Valentin', 'William', 'Xavier'
        ];

        $femaleNames = [
            'Amélie', 'Béatrice', 'Camille', 'Diane', 'Élise', 'Fanny', 'Gabrielle', 'Hélène',
            'Isabelle', 'Julie', 'Karine', 'Léa', 'Marie', 'Nathalie', 'Océane', 'Pauline',
            'Quitterie', 'Roxane', 'Sophie', 'Tiffany', 'Ursule', 'Valérie', 'Wendy', 'Xénia',
            'Yasmine', 'Zoé', 'Alice', 'Bérénice', 'Chloé', 'Delphine', 'Emma', 'Fiona',
            'Gaëlle', 'Hortense', 'Inès', 'Justine', 'Kelly', 'Lola', 'Manon', 'Nina',
            'Ophélie', 'Perrine', 'Raphaëlle', 'Sarah', 'Tatiana', 'Ursula', 'Victoria', 'Wendy'
        ];

        $lastNames = [
            'Martin', 'Bernard', 'Thomas', 'Petit', 'Robert', 'Richard', 'Durand', 'Dubois',
            'Moreau', 'Laurent', 'Simon', 'Michel', 'Lefebvre', 'Leroy', 'Roux', 'David',
            'Bertrand', 'Morel', 'Fournier', 'Girard', 'Bonnet', 'Dupont', 'Lambert', 'Fontaine',
            'Chevalier', 'Robin', 'Masson', 'Sanchez', 'Garcia', 'Petit', 'John', 'Bourgeois',
            'Rousseau', 'Vincent', 'Noël', 'Henry', 'Roussel', 'Mathieu', 'Gautier', 'Blanc',
            'Guerin', 'Muller', 'Henry', 'Legrand', 'Faure', 'Andre', 'Hebert', 'Deschamps',
            'Carpentier', 'Fernandez', 'Lopez', 'Rocher', 'Colin', 'Arnaud', 'Picard', 'Roger'
        ];

        if ($gender === 'male') {
            $firstName = $this->faker->randomElement($maleNames);
        } else {
            $firstName = $this->faker->randomElement($femaleNames);
        }

        $lastName = $this->faker->randomElement($lastNames);

        return $firstName . ' ' . $lastName;
    }

    /**
     * Generate a realistic French phone number
     */
    private function generateFrenchPhoneNumber(): string
    {
        $prefixes = ['06', '07'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('########');

        return $prefix . ' ' . substr($number, 0, 2) . ' ' . substr($number, 2, 2) . ' ' . substr($number, 4, 2) . ' ' . substr($number, 6, 2);
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            // Créer automatiquement un profil pour chaque utilisateur
            $this->createProfileForUser($user);
        });
    }

    /**
     * Create a profile for the user
     */
    private function createProfileForUser(User $user): void
    {
        $genders = ['male', 'female', 'other'];
        $gender = $this->faker->randomElement($genders);

        // Récupérer un pays aléatoire (France principalement)
        $country = Country::inRandomOrder()->first();
        if (!$country) {
            $country = Country::create(['name' => 'France', 'code' => 'FR']);
        }

        // Récupérer une ville aléatoire du pays
        $city = City::where('country_id', $country->id)->inRandomOrder()->first();
        if (!$city) {
            $city = City::create([
                'name' => $this->faker->city(),
                'country_id' => $country->id
            ]);
        }

        $hobbies = [
            'Voyage', 'Cuisine', 'Photographie', 'Sport', 'Musique', 'Cinéma', 'Lecture',
            'Danse', 'Peinture', 'Randonnée', 'Natation', 'Tennis', 'Football', 'Basketball',
            'Yoga', 'Pilates', 'Course à pied', 'Vélo', 'Escalade', 'Ski', 'Surf', 'Plongée',
            'Théâtre', 'Concert', 'Festival', 'Art', 'Design', 'Mode', 'Beauté', 'Jardinage',
            'Bricolage', 'Jeux vidéo', 'Jeux de société', 'Poker', 'Échecs', 'Langues',
            'Histoire', 'Géographie', 'Science', 'Technologie', 'Entrepreneuriat', 'Finance',
            'Immobilier', 'Automobile', 'Moto', 'Aviation', 'Astronomie', 'Nature', 'Animaux',
            'Chats', 'Chiens', 'Chevaux', 'Oiseaux', 'Aquariophilie', 'Collection', 'Antiquités'
        ];

        Profile::create([
            'user_id' => $user->id,
            'bio' => $this->generateBio($gender),
            'gender' => $gender,
            'age' => $this->faker->numberBetween(18, 65),
            'country_id' => $country->id,
            'city_id' => $city->id,
            'height' => $this->generateHeight($gender),
            'hobbies' => $this->faker->randomElements($hobbies, $this->faker->numberBetween(3, 8)),
            'avatar' => null, // Pour l'instant, pas d'avatar
        ]);
    }

    /**
     * Generate a realistic bio based on gender
     */
    private function generateBio(string $gender): string
    {
        $maleBios = [
            "Passionné de sport et de nature. J'aime les randonnées en montagne et les sorties entre amis. Je cherche quelqu'un pour partager mes aventures.",
            "Ingénieur de formation, j'aime la technologie et l'innovation. Je pratique le tennis et j'adore voyager. À la recherche d'une personne avec qui construire quelque chose de beau.",
            "Artiste dans l'âme, je peins et je joue de la guitare. J'aime les soirées culturelles et les discussions profondes. Je cherche une âme sœur.",
            "Sportif et aventurier, je pratique l'escalade et le surf. J'aime découvrir de nouveaux endroits et vivre des expériences fortes. Tu veux m'accompagner ?",
            "Chef cuisinier passionné, j'adore créer de nouveaux plats et recevoir mes amis. Je cherche quelqu'un qui aime la bonne cuisine et les moments conviviaux.",
            "Entrepreneur dynamique, j'aime relever des défis et créer de nouveaux projets. Je pratique le yoga pour me détendre. À la recherche d'une partenaire de vie.",
            "Professeur d'histoire, j'aime transmettre mes connaissances et découvrir de nouveaux lieux chargés d'histoire. Je cherche quelqu'un pour explorer le monde avec moi.",
            "Médecin passionné par mon métier, j'aime aider les autres. Je pratique la course à pied et j'adore la musique classique. Je cherche une personne bienveillante."
        ];

        $femaleBios = [
            "Passionnée de voyage et de photographie. J'aime capturer les beaux moments et découvrir de nouvelles cultures. Je cherche quelqu'un pour partager mes aventures.",
            "Artiste peintre, j'aime créer et exprimer mes émotions à travers l'art. Je pratique le yoga et j'adore les soirées entre amis. À la recherche d'une âme sœur.",
            "Professeure de français, j'aime la littérature et les discussions intellectuelles. Je pratique la danse et j'adore les concerts. Je cherche quelqu'un de cultivé.",
            "Psychologue bienveillante, j'aime écouter et aider les autres. Je pratique la méditation et j'adore la nature. Je cherche une personne sensible et ouverte.",
            "Designer créative, j'aime créer de beaux objets et décorer des espaces. Je pratique le pilates et j'adore les musées. Je cherche quelqu'un d'artistique.",
            "Avocate engagée, je défends des causes qui me tiennent à cœur. Je pratique l'escalade et j'adore les festivals de musique. Je cherche une personne avec des valeurs.",
            "Infirmière dévouée, j'aime prendre soin des autres. Je pratique la natation et j'adore les animaux. Je cherche quelqu'un de bienveillant et généreux.",
            "Architecte passionnée, j'aime créer des espaces harmonieux. Je pratique le jardinage et j'adore les antiquités. Je cherche quelqu'un pour construire ensemble."
        ];

        if ($gender === 'male') {
            return $this->faker->randomElement($maleBios);
        } else {
            return $this->faker->randomElement($femaleBios);
        }
    }

    /**
     * Generate realistic height based on gender
     */
    private function generateHeight(string $gender): int
    {
        if ($gender === 'male') {
            return $this->faker->numberBetween(165, 195); // 165cm à 195cm pour les hommes
        } else {
            return $this->faker->numberBetween(150, 180); // 150cm à 180cm pour les femmes
        }
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create a certified user
     */
    public function certified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_certified' => true,
        ]);
    }

    /**
     * Create a recently active user
     */
    public function recentlyActive(): static
    {
        return $this->state(fn (array $attributes) => [
            'last_login_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
        ]);
    }
}
