<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    /**
     * @group Plans
     *
     * Liste des plans d'abonnement
     *
     * Récupère la liste paginée des plans d'abonnement.
     *
     * @queryParam page integer Numéro de page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 50). Example: 15
     * @queryParam search string Recherche par nom de plan. Example: Premium
     * @queryParam tag string Filtrer par tag. Example: premium
     * @queryParam price_min decimal Prix minimum. Example: 0.00
     * @queryParam price_max decimal Prix maximum. Example: 50.00
     *
     * @response 200 scenario="Liste récupérée" {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "id": 1,
     *         "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *         "name": "Premium",
     *         "description": "Plan premium avec fonctionnalités avancées",
     *         "price": 19.99,
     *         "duration_days": 30,
     *         "tag": "premium",
     *         "advantages": ["Messages illimités", "Recherche avancée", "Profil en vedette"],
     *         "created_at": "2025-10-10T15:30:00.000000Z",
     *         "updated_at": "2025-10-10T15:30:00.000000Z"
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 10
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $query = Plan::query();

        // Recherche
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        // Filtres
        if ($request->filled('tag')) {
            $query->where('tag', $request->get('tag'));
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->get('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->get('price_max'));
        }

        $perPage = min($request->get('per_page', 15), 50);
        $plans = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $plans,
        ]);
    }

    /**
     * @group Plans
     *
     * Créer un plan d'abonnement
     *
     * Crée un nouveau plan d'abonnement.
     *
     * @bodyParam name string required Nom du plan. Example: Premium
     * @bodyParam description string Description du plan. Example: Plan premium avec fonctionnalités avancées
     * @bodyParam price decimal required Prix du plan. Example: 19.99
     * @bodyParam duration_days integer required Durée en jours. Example: 30
     * @bodyParam tag string Tag du plan. Example: premium
     * @bodyParam advantages array Avantages du plan. Example: ["Messages illimités", "Recherche avancée"]
     *
     * @response 201 scenario="Plan créé" {
     *   "success": true,
     *   "message": "Plan créé avec succès",
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "name": "Premium",
     *     "description": "Plan premium avec fonctionnalités avancées",
     *     "price": 19.99,
     *     "duration_days": 30,
     *     "tag": "premium",
     *     "advantages": ["Messages illimités", "Recherche avancée", "Profil en vedette"],
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z"
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'tag' => 'nullable|string|max:100',
            'advantages' => 'nullable|array',
            'advantages.*' => 'string|max:255',
        ]);

        $plan = Plan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Plan créé avec succès',
            'data' => $plan,
        ], 201);
    }

    /**
     * @group Plans
     *
     * Détails d'un plan
     *
     * Récupère les détails d'un plan d'abonnement.
     *
     * @urlParam id integer required ID du plan. Example: 1
     *
     * @response 200 scenario="Plan trouvé" {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "name": "Premium",
     *     "description": "Plan premium avec fonctionnalités avancées",
     *     "price": 19.99,
     *     "duration_days": 30,
     *     "tag": "premium",
     *     "advantages": ["Messages illimités", "Recherche avancée", "Profil en vedette"],
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z"
     *   }
     * }
     *
     * @response 404 scenario="Plan non trouvé" {
     *   "success": false,
     *   "message": "Plan non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $plan = Plan::find($id);

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Plan non trouvé',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $plan,
        ]);
    }

    /**
     * @group Plans
     *
     * Mettre à jour un plan
     *
     * Met à jour les informations d'un plan d'abonnement.
     *
     * @urlParam id integer required ID du plan. Example: 1
     * @bodyParam name string Nom du plan. Example: Premium
     * @bodyParam description string Description du plan. Example: Plan premium avec fonctionnalités avancées
     * @bodyParam price decimal Prix du plan. Example: 19.99
     * @bodyParam duration_days integer Durée en jours. Example: 30
     * @bodyParam tag string Tag du plan. Example: premium
     * @bodyParam advantages array Avantages du plan. Example: ["Messages illimités", "Recherche avancée"]
     *
     * @response 200 scenario="Plan mis à jour" {
     *   "success": true,
     *   "message": "Plan mis à jour avec succès",
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "name": "Premium",
     *     "description": "Plan premium avec fonctionnalités avancées",
     *     "price": 19.99,
     *     "duration_days": 30,
     *     "tag": "premium",
     *     "advantages": ["Messages illimités", "Recherche avancée", "Profil en vedette"],
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z"
     *   }
     * }
     *
     * @response 404 scenario="Plan non trouvé" {
     *   "success": false,
     *   "message": "Plan non trouvé"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $plan = Plan::find($id);

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Plan non trouvé',
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'sometimes|numeric|min:0',
            'duration_days' => 'sometimes|integer|min:1',
            'tag' => 'nullable|string|max:100',
            'advantages' => 'nullable|array',
            'advantages.*' => 'string|max:255',
        ]);

        $plan->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Plan mis à jour avec succès',
            'data' => $plan,
        ]);
    }

    /**
     * @group Plans
     *
     * Supprimer un plan
     *
     * Supprime un plan d'abonnement (seulement s'il n'a pas d'abonnements actifs).
     *
     * @urlParam id integer required ID du plan. Example: 1
     *
     * @response 200 scenario="Plan supprimé" {
     *   "success": true,
     *   "message": "Plan supprimé avec succès"
     * }
     *
     * @response 404 scenario="Plan non trouvé" {
     *   "success": false,
     *   "message": "Plan non trouvé"
     * }
     *
     * @response 422 scenario="Plan avec des abonnements" {
     *   "success": false,
     *   "message": "Impossible de supprimer un plan qui a des abonnements actifs"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $plan = Plan::withCount(['subscriptions' => function ($query) {
            $query->where('is_active', true);
        }])->find($id);

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Plan non trouvé',
            ], 404);
        }

        if ($plan->subscriptions_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer un plan qui a des abonnements actifs',
            ], 422);
        }

        $plan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Plan supprimé avec succès',
        ]);
    }
}
