<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * @group Countries
     *
     * Liste des pays
     *
     * Récupère la liste paginée des pays avec leurs villes.
     *
     * @queryParam page integer Numéro de page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 50). Example: 15
     * @queryParam search string Recherche par nom de pays. Example: Côte
     * @queryParam code string Filtrer par code ISO. Example: CIV
     *
     * @response 200 scenario="Liste récupérée" {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "id": 1,
     *         "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *         "name": "Côte d'Ivoire",
     *         "code": "CIV",
     *         "created_at": "2025-10-10T15:30:00.000000Z",
     *         "updated_at": "2025-10-10T15:30:00.000000Z",
     *         "cities_count": 50
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 100
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $query = Country::withCount('cities');

        // Recherche
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->get('search').'%');
        }

        // Filtre par code
        if ($request->filled('code')) {
            $query->where('code', $request->get('code'));
        }

        $perPage = min($request->get('per_page', 15), 50);
        $countries = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => CountryResource::collection($countries),
        ]);
    }

    /**
     * @group Countries
     *
     * Détails d'un pays
     *
     * Récupère les détails d'un pays avec ses villes.
     *
     * @urlParam id string required UUID du pays. Example: 3fe609a4-a037-4dab-adca-6c8e94a242c4
     *
     * @response 200 scenario="Pays trouvé" {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "name": "Côte d'Ivoire",
     *     "code": "CIV",
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z",
     *     "cities": [
     *       {
     *         "id": 1,
     *         "name": "Abidjan",
     *         "created_at": "2025-10-10T15:30:00.000000Z"
     *       }
     *     ]
     *   }
     * }
     * @response 404 scenario="Pays non trouvé" {
     *   "success": false,
     *   "message": "Pays non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $country = Country::where('uuid', $id)->with('cities')->first();

        if (! $country) {
            return response()->json([
                'success' => false,
                'message' => 'Pays non trouvé',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new CountryResource($country),
        ]);
    }
}
