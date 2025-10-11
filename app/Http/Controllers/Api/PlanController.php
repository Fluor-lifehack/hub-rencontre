<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
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
            'data' => PlanResource::collection($plans),
        ]);
    }

    /**
     * @group Plans
     *
     * Détails d'un plan
     *
     * Récupère les détails d'un plan d'abonnement.
     *
     * @urlParam id string required UUID du plan. Example: 3fe609a4-a037-4dab-adca-6c8e94a242c4
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
        $plan = Plan::where('uuid', $id)->first();

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Plan non trouvé',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new PlanResource($plan),
        ]);
    }
}
