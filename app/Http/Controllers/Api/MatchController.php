<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MatchResource;
use App\Models\UserMatch;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MatchController extends Controller
{
    /**
     * @group Matches
     *
     * Liste des correspondances
     *
     * Récupère la liste paginée des correspondances d'un utilisateur.
     *
     * @queryParam page integer Numéro de page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 50). Example: 15
     * @queryParam user_id integer Filtrer par utilisateur. Example: 1
     * @queryParam is_mutual boolean Filtrer par correspondance mutuelle. Example: true
     * @queryParam compatibility_min decimal Score de compatibilité minimum. Example: 70.00
     *
     * @response 200 scenario="Liste récupérée" {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "id": 1,
     *         "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *         "user_id": 1,
     *         "matched_user_id": 2,
     *         "compatibility_score": 85.50,
     *         "is_mutual": true,
     *         "created_at": "2025-10-10T15:30:00.000000Z",
     *         "updated_at": "2025-10-10T15:30:00.000000Z",
     *         "user": {
     *           "id": 1,
     *           "name": "John Doe",
     *           "email": "john@example.com"
     *         },
     *         "matched_user": {
     *           "id": 2,
     *           "name": "Jane Smith",
     *           "email": "jane@example.com"
     *         }
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 25
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $query = UserMatch::with(['user', 'matchedUser']);

        // Filtres
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        if ($request->filled('is_mutual')) {
            $query->where('is_mutual', $request->boolean('is_mutual'));
        }

        if ($request->filled('compatibility_min')) {
            $query->where('compatibility_score', '>=', $request->get('compatibility_min'));
        }

        $perPage = min($request->get('per_page', 15), 50);
        $matches = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => MatchResource::collection($matches),
        ]);
    }

    /**
     * @group Matches
     *
     * Créer une correspondance
     *
     * Crée une nouvelle correspondance entre deux utilisateurs.
     *
     * @bodyParam user_id integer required ID de l'utilisateur. Example: 1
     * @bodyParam matched_user_id integer required ID de l'utilisateur correspondant. Example: 2
     * @bodyParam compatibility_score decimal Score de compatibilité (0-100). Example: 85.50
     * @bodyParam is_mutual boolean Correspondance mutuelle. Example: false
     *
     * @response 201 scenario="Correspondance créée" {
     *   "success": true,
     *   "message": "Correspondance créée avec succès",
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "user_id": 1,
     *     "matched_user_id": 2,
     *     "compatibility_score": 85.50,
     *     "is_mutual": false,
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z"
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'matched_user_id' => 'required|exists:users,id|different:user_id',
            'compatibility_score' => 'nullable|numeric|min:0|max:100',
            'is_mutual' => 'boolean',
        ]);

        // Vérifier qu'il n'y a pas déjà une correspondance entre ces utilisateurs
        $existingMatch = UserMatch::where('user_id', $request->user_id)
            ->where('matched_user_id', $request->matched_user_id)
            ->first();

        if ($existingMatch) {
            return response()->json([
                'success' => false,
                'message' => 'Une correspondance existe déjà entre ces utilisateurs',
            ], 422);
        }

        $match = UserMatch::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Correspondance créée avec succès',
            'data' => new MatchResource($match),
        ], 201);
    }

    /**
     * @group Matches
     *
     * Détails d'une correspondance
     *
     * Récupère les détails d'une correspondance.
     *
     * @urlParam id string required UUID de la correspondance. Example: 3fe609a4-a037-4dab-adca-6c8e94a242c4
     *
     * @response 200 scenario="Correspondance trouvée" {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "user_id": 1,
     *     "matched_user_id": 2,
     *     "compatibility_score": 85.50,
     *     "is_mutual": true,
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z",
     *     "user": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "john@example.com"
     *     },
     *     "matched_user": {
     *       "id": 2,
     *       "name": "Jane Smith",
     *       "email": "jane@example.com"
     *     }
     *   }
     * }
     *
     * @response 404 scenario="Correspondance non trouvée" {
     *   "success": false,
     *   "message": "Correspondance non trouvée"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $match = UserMatch::where('uuid', $id)->with(['user', 'matchedUser'])->first();

        if (!$match) {
            return response()->json([
                'success' => false,
                'message' => 'Correspondance non trouvée',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new MatchResource($match),
        ]);
    }

    /**
     * @group Matches
     *
     * Mettre à jour une correspondance
     *
     * Met à jour les informations d'une correspondance.
     *
     * @urlParam id string required UUID de la correspondance. Example: 3fe609a4-a037-4dab-adca-6c8e94a242c4
     * @bodyParam compatibility_score decimal Score de compatibilité (0-100). Example: 85.50
     * @bodyParam is_mutual boolean Correspondance mutuelle. Example: true
     *
     * @response 200 scenario="Correspondance mise à jour" {
     *   "success": true,
     *   "message": "Correspondance mise à jour avec succès",
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "user_id": 1,
     *     "matched_user_id": 2,
     *     "compatibility_score": 85.50,
     *     "is_mutual": true,
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z"
     *   }
     * }
     *
     * @response 404 scenario="Correspondance non trouvée" {
     *   "success": false,
     *   "message": "Correspondance non trouvée"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $match = UserMatch::find($id);

        if (!$match) {
            return response()->json([
                'success' => false,
                'message' => 'Correspondance non trouvée',
            ], 404);
        }

        $request->validate([
            'compatibility_score' => 'nullable|numeric|min:0|max:100',
            'is_mutual' => 'boolean',
        ]);

        $match->update($request->only(['compatibility_score', 'is_mutual']));

        return response()->json([
            'success' => true,
            'message' => 'Correspondance mise à jour avec succès',
            'data' => new MatchResource($match),
        ]);
    }

    /**
     * @group Matches
     *
     * Supprimer une correspondance
     *
     * Supprime une correspondance.
     *
     * @urlParam id string required UUID de la correspondance. Example: 3fe609a4-a037-4dab-adca-6c8e94a242c4
     *
     * @response 200 scenario="Correspondance supprimée" {
     *   "success": true,
     *   "message": "Correspondance supprimée avec succès"
     * }
     *
     * @response 404 scenario="Correspondance non trouvée" {
     *   "success": false,
     *   "message": "Correspondance non trouvée"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $match = UserMatch::find($id);

        if (!$match) {
            return response()->json([
                'success' => false,
                'message' => 'Correspondance non trouvée',
            ], 404);
        }

        $match->delete();

        return response()->json([
            'success' => true,
            'message' => 'Correspondance supprimée avec succès',
        ]);
    }
}
