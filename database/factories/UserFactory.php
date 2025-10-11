<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\Profile;
use App\Models\User;
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
            'email' => 'user_'.time().'_'.rand(1000, 9999).'@example.com',
            'phone' => $this->generatePhoneNumberWithCountryCode(),
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
            'Noé', 'Paul', 'Rémi', 'Simon', 'Tristan', 'Valentin', 'William', 'Xavier',
        ];

        $femaleNames = [
            'Amélie', 'Béatrice', 'Camille', 'Diane', 'Élise', 'Fanny', 'Gabrielle', 'Hélène',
            'Isabelle', 'Julie', 'Karine', 'Léa', 'Marie', 'Nathalie', 'Océane', 'Pauline',
            'Quitterie', 'Roxane', 'Sophie', 'Tiffany', 'Ursule', 'Valérie', 'Wendy', 'Xénia',
            'Yasmine', 'Zoé', 'Alice', 'Bérénice', 'Chloé', 'Delphine', 'Emma', 'Fiona',
            'Gaëlle', 'Hortense', 'Inès', 'Justine', 'Kelly', 'Lola', 'Manon', 'Nina',
            'Ophélie', 'Perrine', 'Raphaëlle', 'Sarah', 'Tatiana', 'Ursula', 'Victoria', 'Wendy',
        ];

        $lastNames = [
            'Martin', 'Bernard', 'Thomas', 'Petit', 'Robert', 'Richard', 'Durand', 'Dubois',
            'Moreau', 'Laurent', 'Simon', 'Michel', 'Lefebvre', 'Leroy', 'Roux', 'David',
            'Bertrand', 'Morel', 'Fournier', 'Girard', 'Bonnet', 'Dupont', 'Lambert', 'Fontaine',
            'Chevalier', 'Robin', 'Masson', 'Sanchez', 'Garcia', 'Petit', 'John', 'Bourgeois',
            'Rousseau', 'Vincent', 'Noël', 'Henry', 'Roussel', 'Mathieu', 'Gautier', 'Blanc',
            'Guerin', 'Muller', 'Henry', 'Legrand', 'Faure', 'Andre', 'Hebert', 'Deschamps',
            'Carpentier', 'Fernandez', 'Lopez', 'Rocher', 'Colin', 'Arnaud', 'Picard', 'Roger',
        ];

        if ($gender === 'male') {
            $firstName = $this->faker->randomElement($maleNames);
        } else {
            $firstName = $this->faker->randomElement($femaleNames);
        }

        $lastName = $this->faker->randomElement($lastNames);

        return $firstName.' '.$lastName;
    }

    /**
     * Generate a realistic phone number with country code
     */
    private function generatePhoneNumberWithCountryCode(): string
    {
        $countryCodes = [
            'FR' => '+33',  // France
            'BE' => '+32',  // Belgique
            'CH' => '+41',  // Suisse
            'CA' => '+1',   // Canada
            'US' => '+1',   // États-Unis
            'GB' => '+44',  // Royaume-Uni
            'DE' => '+49',  // Allemagne
            'ES' => '+34',  // Espagne
            'IT' => '+39',  // Italie
            'PT' => '+351', // Portugal
            'NL' => '+31',  // Pays-Bas
            'SE' => '+46',  // Suède
            'NO' => '+47',  // Norvège
            'DK' => '+45',  // Danemark
            'FI' => '+358', // Finlande
            'AU' => '+61',  // Australie
            'JP' => '+81',  // Japon
            'KR' => '+82',  // Corée du Sud
            'CN' => '+86',  // Chine
            'IN' => '+91',  // Inde
            'BR' => '+55',  // Brésil
            'MX' => '+52',  // Mexique
            'AR' => '+54',  // Argentine
            'RU' => '+7',   // Russie
            'ZA' => '+27',  // Afrique du Sud
            'EG' => '+20',  // Égypte
            'MA' => '+212', // Maroc
            'TN' => '+216', // Tunisie
            'DZ' => '+213', // Algérie
            'SN' => '+221', // Sénégal
            'CI' => '+225', // Côte d'Ivoire
            'CM' => '+237', // Cameroun
            'NG' => '+234', // Nigeria
            'KE' => '+254', // Kenya
            'GH' => '+233', // Ghana
            'UG' => '+256', // Ouganda
            'TZ' => '+255', // Tanzanie
            'ET' => '+251', // Éthiopie
            'ZA' => '+27',  // Afrique du Sud
        ];

        $countryCode = $this->faker->randomElement(array_keys($countryCodes));
        $phoneCode = $countryCodes[$countryCode];

        return $this->generatePhoneNumberForCountry($countryCode, $phoneCode);
    }

    /**
     * Generate phone number for specific country
     */
    private function generatePhoneNumberForCountry(string $countryCode, string $phoneCode): string
    {
        switch ($countryCode) {
            case 'FR':
                return $this->generateFrenchPhoneNumber($phoneCode);
            case 'BE':
                return $this->generateBelgianPhoneNumber($phoneCode);
            case 'CH':
                return $this->generateSwissPhoneNumber($phoneCode);
            case 'CA':
            case 'US':
                return $this->generateNorthAmericanPhoneNumber($phoneCode);
            case 'GB':
                return $this->generateUKPhoneNumber($phoneCode);
            case 'DE':
                return $this->generateGermanPhoneNumber($phoneCode);
            case 'ES':
                return $this->generateSpanishPhoneNumber($phoneCode);
            case 'IT':
                return $this->generateItalianPhoneNumber($phoneCode);
            case 'AU':
                return $this->generateAustralianPhoneNumber($phoneCode);
            case 'JP':
                return $this->generateJapanesePhoneNumber($phoneCode);
            case 'BR':
                return $this->generateBrazilianPhoneNumber($phoneCode);
            case 'MA':
            case 'TN':
            case 'DZ':
                return $this->generateNorthAfricanPhoneNumber($phoneCode);
            default:
                return $this->generateGenericPhoneNumber($phoneCode);
        }
    }

    /**
     * Generate French phone number
     */
    private function generateFrenchPhoneNumber(string $phoneCode): string
    {
        $prefixes = ['06', '07'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('########');

        // Format: +33 6 XX XX XX XX (supprimer le 0 du préfixe pour l'international)
        $internationalPrefix = substr($prefix, 1); // Enlever le 0
        $formattedNumber = substr($number, 0, 2).' '.substr($number, 2, 2).' '.substr($number, 4, 2).' '.substr($number, 6, 2);

        return $phoneCode.' '.$internationalPrefix.' '.$formattedNumber;
    }

    /**
     * Generate Belgian phone number
     */
    private function generateBelgianPhoneNumber(string $phoneCode): string
    {
        $prefixes = ['04', '05', '06', '07', '08', '09'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('######');

        $internationalPrefix = substr($prefix, 1); // Enlever le 0
        $formattedNumber = substr($number, 0, 3).' '.substr($number, 3, 3);

        return $phoneCode.' '.$internationalPrefix.' '.$formattedNumber;
    }

    /**
     * Generate Swiss phone number
     */
    private function generateSwissPhoneNumber(string $phoneCode): string
    {
        $prefixes = ['07', '08', '09'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('######');

        $internationalPrefix = substr($prefix, 1); // Enlever le 0
        $formattedNumber = substr($number, 0, 3).' '.substr($number, 3, 3);

        return $phoneCode.' '.$internationalPrefix.' '.$formattedNumber;
    }

    /**
     * Generate North American phone number
     */
    private function generateNorthAmericanPhoneNumber(string $phoneCode): string
    {
        $areaCode = $this->faker->numerify('###');
        $number = $this->faker->numerify('#######');

        $formattedNumber = substr($number, 0, 3).'-'.substr($number, 3, 4);

        return $phoneCode.' ('.$areaCode.') '.$formattedNumber;
    }

    /**
     * Generate UK phone number
     */
    private function generateUKPhoneNumber(string $phoneCode): string
    {
        $prefixes = ['07', '01', '02'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('########');

        $internationalPrefix = substr($prefix, 1); // Enlever le 0
        $formattedNumber = substr($number, 0, 4).' '.substr($number, 4, 4);

        return $phoneCode.' '.$internationalPrefix.' '.$formattedNumber;
    }

    /**
     * Generate German phone number
     */
    private function generateGermanPhoneNumber(string $phoneCode): string
    {
        $prefixes = ['01', '02', '03', '04', '05', '06', '07', '08', '09'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('########');

        $internationalPrefix = substr($prefix, 1); // Enlever le 0
        $formattedNumber = substr($number, 0, 4).' '.substr($number, 4, 4);

        return $phoneCode.' '.$internationalPrefix.' '.$formattedNumber;
    }

    /**
     * Generate Spanish phone number
     */
    private function generateSpanishPhoneNumber(string $phoneCode): string
    {
        $prefixes = ['06', '07', '08', '09'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('#######');

        $internationalPrefix = substr($prefix, 1); // Enlever le 0
        $formattedNumber = substr($number, 0, 3).' '.substr($number, 3, 2).' '.substr($number, 5, 2);

        return $phoneCode.' '.$internationalPrefix.' '.$formattedNumber;
    }

    /**
     * Generate Italian phone number
     */
    private function generateItalianPhoneNumber(string $phoneCode): string
    {
        $prefixes = ['03', '06', '07', '08', '09'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('#######');

        $internationalPrefix = substr($prefix, 1); // Enlever le 0
        $formattedNumber = substr($number, 0, 3).' '.substr($number, 3, 2).' '.substr($number, 5, 2);

        return $phoneCode.' '.$internationalPrefix.' '.$formattedNumber;
    }

    /**
     * Generate Australian phone number
     */
    private function generateAustralianPhoneNumber(string $phoneCode): string
    {
        $prefixes = ['04', '05', '07', '08'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('#######');

        $internationalPrefix = substr($prefix, 1); // Enlever le 0
        $formattedNumber = substr($number, 0, 3).' '.substr($number, 3, 2).' '.substr($number, 5, 2);

        return $phoneCode.' '.$internationalPrefix.' '.$formattedNumber;
    }

    /**
     * Generate Japanese phone number
     */
    private function generateJapanesePhoneNumber(string $phoneCode): string
    {
        $prefixes = ['09', '08', '07', '06', '05', '04', '03', '02', '01'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('########');

        $internationalPrefix = substr($prefix, 1); // Enlever le 0
        $formattedNumber = substr($number, 0, 4).'-'.substr($number, 4, 4);

        return $phoneCode.' '.$internationalPrefix.'-'.$formattedNumber;
    }

    /**
     * Generate Brazilian phone number
     */
    private function generateBrazilianPhoneNumber(string $phoneCode): string
    {
        $areaCode = $this->faker->numerify('##');
        $number = $this->faker->numerify('####-####');

        return $phoneCode.' '.$areaCode.' '.$number;
    }

    /**
     * Generate North African phone number
     */
    private function generateNorthAfricanPhoneNumber(string $phoneCode): string
    {
        $prefixes = ['06', '07', '08', '09'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('#######');

        $internationalPrefix = substr($prefix, 1); // Enlever le 0
        $formattedNumber = substr($number, 0, 3).' '.substr($number, 3, 2).' '.substr($number, 5, 2);

        return $phoneCode.' '.$internationalPrefix.' '.$formattedNumber;
    }

    /**
     * Generate generic phone number
     */
    private function generateGenericPhoneNumber(string $phoneCode): string
    {
        $number = $this->faker->numerify('##########');
        $formattedNumber = substr($number, 0, 3).' '.substr($number, 3, 3).' '.substr($number, 6, 4);

        return $phoneCode.' '.$formattedNumber;
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
        if (! $country) {
            $country = Country::create(['name' => 'France', 'code' => 'FR']);
        }

        // Récupérer une ville aléatoire du pays
        $city = City::where('country_id', $country->id)->inRandomOrder()->first();
        if (! $city) {
            $city = City::create([
                'name' => $this->faker->city(),
                'country_id' => $country->id,
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
            'Chats', 'Chiens', 'Chevaux', 'Oiseaux', 'Aquariophilie', 'Collection', 'Antiquités',
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
            "Médecin passionné par mon métier, j'aime aider les autres. Je pratique la course à pied et j'adore la musique classique. Je cherche une personne bienveillante.",
        ];

        $femaleBios = [
            "Passionnée de voyage et de photographie. J'aime capturer les beaux moments et découvrir de nouvelles cultures. Je cherche quelqu'un pour partager mes aventures.",
            "Artiste peintre, j'aime créer et exprimer mes émotions à travers l'art. Je pratique le yoga et j'adore les soirées entre amis. À la recherche d'une âme sœur.",
            "Professeure de français, j'aime la littérature et les discussions intellectuelles. Je pratique la danse et j'adore les concerts. Je cherche quelqu'un de cultivé.",
            "Psychologue bienveillante, j'aime écouter et aider les autres. Je pratique la méditation et j'adore la nature. Je cherche une personne sensible et ouverte.",
            "Designer créative, j'aime créer de beaux objets et décorer des espaces. Je pratique le pilates et j'adore les musées. Je cherche quelqu'un d'artistique.",
            "Avocate engagée, je défends des causes qui me tiennent à cœur. Je pratique l'escalade et j'adore les festivals de musique. Je cherche une personne avec des valeurs.",
            "Infirmière dévouée, j'aime prendre soin des autres. Je pratique la natation et j'adore les animaux. Je cherche quelqu'un de bienveillant et généreux.",
            "Architecte passionnée, j'aime créer des espaces harmonieux. Je pratique le jardinage et j'adore les antiquités. Je cherche quelqu'un pour construire ensemble.",
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
