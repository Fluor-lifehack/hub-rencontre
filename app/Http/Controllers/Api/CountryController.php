<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        // Filtre par code
        if ($request->filled('code')) {
            $query->where('code', $request->get('code'));
        }

        $perPage = min($request->get('per_page', 15), 50);
        $countries = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $countries,
        ]);
    }

    /**
     * @group Countries
     *
     * Créer un pays
     *
     * Crée un nouveau pays.
     *
     * @bodyParam name string required Nom du pays. Example: Côte d'Ivoire
     * @bodyParam code string required Code ISO du pays (3 caractères). Example: CIV
     *
     * @response 201 scenario="Pays créé" {
     *   "success": true,
     *   "message": "Pays créé avec succès",
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "name": "Côte d'Ivoire",
     *     "code": "CIV",
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z"
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:countries,name',
            'code' => 'required|string|size:3|unique:countries,code|uppercase',
        ]);

        $country = Country::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pays créé avec succès',
            'data' => $country,
        ], 201);
    }

    /**
     * @group Countries
     *
     * Détails d'un pays
     *
     * Récupère les détails d'un pays avec ses villes.
     *
     * @urlParam id integer required ID du pays. Example: 1
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
     *
     * @response 404 scenario="Pays non trouvé" {
     *   "success": false,
     *   "message": "Pays non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $country = Country::with('cities')->find($id);

        if (!$country) {
            return response()->json([
                'success' => false,
                'message' => 'Pays non trouvé',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $country,
        ]);
    }

    /**
     * @group Countries
     *
     * Mettre à jour un pays
     *
     * Met à jour les informations d'un pays.
     *
     * @urlParam id integer required ID du pays. Example: 1
     * @bodyParam name string Nom du pays. Example: Côte d'Ivoire
     * @bodyParam code string Code ISO du pays (3 caractères). Example: CIV
     *
     * @response 200 scenario="Pays mis à jour" {
     *   "success": true,
     *   "message": "Pays mis à jour avec succès",
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "name": "Côte d'Ivoire",
     *     "code": "CIV",
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z"
     *   }
     * }
     *
     * @response 404 scenario="Pays non trouvé" {
     *   "success": false,
     *   "message": "Pays non trouvé"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json([
                'success' => false,
                'message' => 'Pays non trouvé',
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255|unique:countries,name,' . $country->id,
            'code' => 'sometimes|string|size:3|unique:countries,code,' . $country->id . '|uppercase',
        ]);

        $updateData = $request->only(['name']);
        if ($request->filled('code')) {
            $updateData['code'] = strtoupper($request->code);
        }

        $country->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Pays mis à jour avec succès',
            'data' => $country,
        ]);
    }

    /**
     * @group Countries
     *
     * Supprimer un pays
     *
     * Supprime un pays (seulement s'il n'a pas de villes).
     *
     * @urlParam id integer required ID du pays. Example: 1
     *
     * @response 200 scenario="Pays supprimé" {
     *   "success": true,
     *   "message": "Pays supprimé avec succès"
     * }
     *
     * @response 404 scenario="Pays non trouvé" {
     *   "success": false,
     *   "message": "Pays non trouvé"
     * }
     *
     * @response 422 scenario="Pays avec des villes" {
     *   "success": false,
     *   "message": "Impossible de supprimer un pays qui contient des villes"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $country = Country::withCount('cities')->find($id);

        if (!$country) {
            return response()->json([
                'success' => false,
                'message' => 'Pays non trouvé',
            ], 404);
        }

        if ($country->cities_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer un pays qui contient des villes',
            ], 422);
        }

        $country->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pays supprimé avec succès',
        ]);
    }
}
