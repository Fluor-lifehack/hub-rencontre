<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Côte d'Ivoire (pays par défaut)
        $coteIvoire = Country::where('code', 'CIV')->first();
        if ($coteIvoire) {
            $cities = [
                'Abidjan', 'Yamoussoukro', 'Bouaké', 'San-Pédro', 'Korhogo', 'Man', 'Gagnoa', 'Soubré', 'Divo', 'Daloa',
                'Anyama', 'Agboville', 'Bingerville', 'Grand-Bassam', 'Jacqueville', 'Tiassalé', 'Bondoukou', 'Abengourou', 'Agnibilékrou', 'Bouna',
                'Odienné', 'Touba', 'Seguela', 'Vavoua', 'Sinfra', 'Zuenoula', 'Issia', 'Bangolo', 'Duekoué', 'Guiglo',
                'Toumodi', 'Dabou', 'Bonoua', 'Adzopé', 'Akoupé', 'Alépé', 'Aboisso', 'Adiaké', 'Grand-Lahou', 'Fresco'
            ];
            foreach ($cities as $city) {
                City::create(['country_id' => $coteIvoire->id, 'name' => $city]);
            }
        }

        // Sénégal
        $senegal = Country::where('code', 'SEN')->first();
        if ($senegal) {
            $cities = ['Dakar', 'Thiès', 'Kaolack', 'Ziguinchor', 'Saint-Louis', 'Diourbel', 'Tambacounda', 'Kolda', 'Matam', 'Fatick'];
            foreach ($cities as $city) {
                City::create(['country_id' => $senegal->id, 'name' => $city]);
            }
        }

        // Mali
        $mali = Country::where('code', 'MLI')->first();
        if ($mali) {
            $cities = ['Bamako', 'Sikasso', 'Ségou', 'Mopti', 'Gao', 'Koutiala', 'Kayes', 'Tombouctou', 'Kidal', 'Djenné'];
            foreach ($cities as $city) {
                City::create(['country_id' => $mali->id, 'name' => $city]);
            }
        }

        // Burkina Faso
        $burkina = Country::where('code', 'BFA')->first();
        if ($burkina) {
            $cities = ['Ouagadougou', 'Bobo-Dioulasso', 'Koudougou', 'Ouahigouya', 'Banfora', 'Dédougou', 'Kaya', 'Tenkodogo', 'Fada N\'gourma', 'Dori'];
            foreach ($cities as $city) {
                City::create(['country_id' => $burkina->id, 'name' => $city]);
            }
        }

        // Ghana
        $ghana = Country::where('code', 'GHA')->first();
        if ($ghana) {
            $cities = ['Accra', 'Kumasi', 'Tamale', 'Sekondi-Takoradi', 'Sunyani', 'Cape Coast', 'Koforidua', 'Ho', 'Wa', 'Bolgatanga'];
            foreach ($cities as $city) {
                City::create(['country_id' => $ghana->id, 'name' => $city]);
            }
        }

        // Nigeria
        $nigeria = Country::where('code', 'NGA')->first();
        if ($nigeria) {
            $cities = ['Lagos', 'Abuja', 'Kano', 'Ibadan', 'Port Harcourt', 'Benin City', 'Kaduna', 'Jos', 'Ilorin', 'Abakaliki'];
            foreach ($cities as $city) {
                City::create(['country_id' => $nigeria->id, 'name' => $city]);
            }
        }

        // Cameroun
        $cameroun = Country::where('code', 'CMR')->first();
        if ($cameroun) {
            $cities = ['Yaoundé', 'Douala', 'Garoua', 'Bamenda', 'Maroua', 'Ngaoundéré', 'Bafoussam', 'Bertoua', 'Ebolowa', 'Kumba'];
            foreach ($cities as $city) {
                City::create(['country_id' => $cameroun->id, 'name' => $city]);
            }
        }

        // Gabon
        $gabon = Country::where('code', 'GAB')->first();
        if ($gabon) {
            $cities = ['Libreville', 'Port-Gentil', 'Franceville', 'Oyem', 'Moanda', 'Lambaréné', 'Mouila', 'Tchibanga', 'Koulamoutou', 'Bitam'];
            foreach ($cities as $city) {
                City::create(['country_id' => $gabon->id, 'name' => $city]);
            }
        }

        // Maroc
        $maroc = Country::where('code', 'MAR')->first();
        if ($maroc) {
            $cities = ['Rabat', 'Casablanca', 'Fès', 'Marrakech', 'Agadir', 'Tanger', 'Meknès', 'Oujda', 'Kénitra', 'Tétouan'];
            foreach ($cities as $city) {
                City::create(['country_id' => $maroc->id, 'name' => $city]);
            }
        }

        // Algérie
        $algerie = Country::where('code', 'DZA')->first();
        if ($algerie) {
            $cities = ['Alger', 'Oran', 'Constantine', 'Annaba', 'Blida', 'Batna', 'Djelfa', 'Sétif', 'Sidi Bel Abbès', 'Biskra'];
            foreach ($cities as $city) {
                City::create(['country_id' => $algerie->id, 'name' => $city]);
            }
        }

        // Tunisie
        $tunisie = Country::where('code', 'TUN')->first();
        if ($tunisie) {
            $cities = ['Tunis', 'Sfax', 'Sousse', 'Kairouan', 'Gabès', 'Bizerte', 'Ariana', 'Monastir', 'Ben Arous', 'Nabeul'];
            foreach ($cities as $city) {
                City::create(['country_id' => $tunisie->id, 'name' => $city]);
            }
        }

        // Égypte
        $egypte = Country::where('code', 'EGY')->first();
        if ($egypte) {
            $cities = ['Le Caire', 'Alexandrie', 'Gizeh', 'Shubra El Kheima', 'Port-Saïd', 'Suez', 'Louxor', 'Assouan', 'Hurghada', 'Sharm el-Sheikh'];
            foreach ($cities as $city) {
                City::create(['country_id' => $egypte->id, 'name' => $city]);
            }
        }

        // Kenya
        $kenya = Country::where('code', 'KEN')->first();
        if ($kenya) {
            $cities = ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Thika', 'Malindi', 'Kitale', 'Garissa', 'Kakamega'];
            foreach ($cities as $city) {
                City::create(['country_id' => $kenya->id, 'name' => $city]);
            }
        }

        // Afrique du Sud
        $afriqueSud = Country::where('code', 'ZAF')->first();
        if ($afriqueSud) {
            $cities = ['Johannesburg', 'Le Cap', 'Durban', 'Pretoria', 'Port Elizabeth', 'Bloemfontein', 'East London', 'Nelspruit', 'Kimberley', 'Polokwane'];
            foreach ($cities as $city) {
                City::create(['country_id' => $afriqueSud->id, 'name' => $city]);
            }
        }

        // France
        $france = Country::where('code', 'FRA')->first();
        if ($france) {
            $cities = ['Paris', 'Marseille', 'Lyon', 'Toulouse', 'Nice', 'Nantes', 'Montpellier', 'Strasbourg', 'Bordeaux', 'Lille'];
            foreach ($cities as $city) {
                City::create(['country_id' => $france->id, 'name' => $city]);
            }
        }

        // Allemagne
        $allemagne = Country::where('code', 'DEU')->first();
        if ($allemagne) {
            $cities = ['Berlin', 'Hambourg', 'Munich', 'Cologne', 'Francfort', 'Stuttgart', 'Düsseldorf', 'Dortmund', 'Essen', 'Leipzig'];
            foreach ($cities as $city) {
                City::create(['country_id' => $allemagne->id, 'name' => $city]);
            }
        }

        // Italie
        $italie = Country::where('code', 'ITA')->first();
        if ($italie) {
            $cities = ['Rome', 'Milan', 'Naples', 'Turin', 'Palerme', 'Gênes', 'Bologne', 'Florence', 'Bari', 'Catane'];
            foreach ($cities as $city) {
                City::create(['country_id' => $italie->id, 'name' => $city]);
            }
        }

        // Espagne
        $espagne = Country::where('code', 'ESP')->first();
        if ($espagne) {
            $cities = ['Madrid', 'Barcelone', 'Valence', 'Séville', 'Saragosse', 'Málaga', 'Murcie', 'Palma', 'Las Palmas', 'Bilbao'];
            foreach ($cities as $city) {
                City::create(['country_id' => $espagne->id, 'name' => $city]);
            }
        }

        // Royaume-Uni
        $royaumeUni = Country::where('code', 'GBR')->first();
        if ($royaumeUni) {
            $cities = ['Londres', 'Birmingham', 'Manchester', 'Glasgow', 'Liverpool', 'Leeds', 'Sheffield', 'Edimbourg', 'Bristol', 'Cardiff'];
            foreach ($cities as $city) {
                City::create(['country_id' => $royaumeUni->id, 'name' => $city]);
            }
        }

        // États-Unis
        $usa = Country::where('code', 'USA')->first();
        if ($usa) {
            $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphie', 'San Antonio', 'San Diego', 'Dallas', 'San Jose'];
            foreach ($cities as $city) {
                City::create(['country_id' => $usa->id, 'name' => $city]);
            }
        }

        // Canada
        $canada = Country::where('code', 'CAN')->first();
        if ($canada) {
            $cities = ['Toronto', 'Montréal', 'Vancouver', 'Calgary', 'Edmonton', 'Ottawa', 'Winnipeg', 'Québec', 'Hamilton', 'Kitchener'];
            foreach ($cities as $city) {
                City::create(['country_id' => $canada->id, 'name' => $city]);
            }
        }

        // Chine
        $chine = Country::where('code', 'CHN')->first();
        if ($chine) {
            $cities = ['Pékin', 'Shanghai', 'Guangzhou', 'Shenzhen', 'Tianjin', 'Wuhan', 'Dongguan', 'Chengdu', 'Nanjing', 'Chongqing'];
            foreach ($cities as $city) {
                City::create(['country_id' => $chine->id, 'name' => $city]);
            }
        }

        // Japon
        $japon = Country::where('code', 'JPN')->first();
        if ($japon) {
            $cities = ['Tokyo', 'Yokohama', 'Osaka', 'Nagoya', 'Sapporo', 'Fukuoka', 'Kobe', 'Kyoto', 'Kawasaki', 'Saitama'];
            foreach ($cities as $city) {
                City::create(['country_id' => $japon->id, 'name' => $city]);
            }
        }

        // Inde
        $inde = Country::where('code', 'IND')->first();
        if ($inde) {
            $cities = ['Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Ahmedabad', 'Chennai', 'Kolkata', 'Pune', 'Jaipur', 'Lucknow'];
            foreach ($cities as $city) {
                City::create(['country_id' => $inde->id, 'name' => $city]);
            }
        }
    }
}
