<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * @group Users
     *
     * Liste des utilisateurs
     *
     * Récupère la liste paginée des utilisateurs avec leurs profils.
     *
     * @queryParam page integer Numéro de page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 50). Example: 15
     * @queryParam search string Recherche par nom ou email. Example: john
     * @queryParam is_certified boolean Filtrer par certification. Example: true
     *
     * @response 200 scenario="Liste récupérée" {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "id": 1,
     *         "uuid": "40e35362-0215-45df-8afe-293778cb6ec7",
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "phone": "+225123456789",
     *         "is_certified": true,
     *         "last_login_at": "2025-10-10T15:30:00.000000Z",
     *         "created_at": "2025-10-10T14:00:00.000000Z",
     *         "updated_at": "2025-10-10T15:30:00.000000Z"
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
        $query = User::with('profile');

        // Recherche
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre par certification
        if ($request->filled('is_certified')) {
            $query->where('is_certified', $request->boolean('is_certified'));
        }

        $perPage = min($request->get('per_page', 15), 50);
        $users = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => UserResource::collection($users),
        ]);
    }

    /**
     * @group Users
     *
     * Créer un utilisateur
     *
     * Crée un nouvel utilisateur avec son profil.
     *
     * @bodyParam name string required Nom complet de l'utilisateur. Example: John Doe
     * @bodyParam email string required Email de l'utilisateur. Example: john@example.com
     * @bodyParam phone string required Numéro de téléphone. Example: +225123456789
     * @bodyParam password string required Mot de passe (minimum 6 caractères). Example: password123
     * @bodyParam password_confirmation string required Confirmation du mot de passe. Example: password123
     * @bodyParam bio string Bio de l'utilisateur. Example: Passionné de voyages
     * @bodyParam gender string Genre (male, female, other). Example: male
     * @bodyParam age integer Âge (18-100). Example: 25
     * @bodyParam country_id integer ID du pays. Example: 1
     * @bodyParam city_id integer ID de la ville. Example: 1
     * @bodyParam height integer Taille en cm (100-250). Example: 175
     * @bodyParam hobbies array Centres d'intérêt. Example: ["voyage", "sport", "musique"]
     *
     * @response 201 scenario="Utilisateur créé" {
     *   "success": true,
     *   "message": "Utilisateur créé avec succès",
     *   "data": {
     *     "user": {
     *       "id": 1,
     *       "uuid": "40e35362-0215-45df-8afe-293778cb6ec7",
     *       "name": "John Doe",
     *       "email": "john@example.com",
     *       "phone": "+225123456789",
     *       "is_certified": false,
     *       "last_login_at": null,
     *       "created_at": "2025-10-10T15:30:00.000000Z",
     *       "updated_at": "2025-10-10T15:30:00.000000Z"
     *     },
     *     "profile": {
     *       "id": 1,
     *       "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *       "user_id": 1,
     *       "bio": "Passionné de voyages",
     *       "gender": "male",
     *       "age": 25,
     *       "country_id": 1,
     *       "city_id": 1,
     *       "height": 175,
     *       "hobbies": ["voyage", "sport", "musique"],
     *       "avatar": null,
     *       "created_at": "2025-10-10T15:30:00.000000Z",
     *       "updated_at": "2025-10-10T15:30:00.000000Z"
     *     }
     *   }
     * }
     * @response 422 scenario="Erreur de validation" {
     *   "success": false,
     *   "message": "Les données fournies ne sont pas valides",
     *   "errors": {
     *     "email": ["L'email a déjà été pris."],
     *     "password": ["La confirmation du mot de passe ne correspond pas."]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'bio' => 'nullable|string|max:1000',
            'gender' => 'nullable|in:male,female,other',
            'age' => 'nullable|integer|min:18|max:100',
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'height' => 'nullable|integer|min:100|max:250',
            'hobbies' => 'nullable|array',
            'hobbies.*' => 'string|max:100',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        $profile = $user->profile()->create([
            'bio' => $request->bio,
            'gender' => $request->gender,
            'age' => $request->age,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'height' => $request->height,
            'hobbies' => $request->hobbies,
        ]);

        $user->load('profile');

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur créé avec succès',
            'data' => new UserResource($user),
        ], 201);
    }

    /**
     * @group Users
     *
     * Détails d'un utilisateur
     *
     * Récupère les détails d'un utilisateur avec son profil.
     *
     * @urlParam id integer required ID de l'utilisateur. Example: 1
     *
     * @response 200 scenario="Utilisateur trouvé" {
     *   "success": true,
     *   "data": {
     *     "user": {
     *       "id": 1,
     *       "uuid": "40e35362-0215-45df-8afe-293778cb6ec7",
     *       "name": "John Doe",
     *       "email": "john@example.com",
     *       "phone": "+225123456789",
     *       "is_certified": true,
     *       "last_login_at": "2025-10-10T15:30:00.000000Z",
     *       "created_at": "2025-10-10T14:00:00.000000Z",
     *       "updated_at": "2025-10-10T15:30:00.000000Z"
     *     },
     *     "profile": {
     *       "id": 1,
     *       "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *       "user_id": 1,
     *       "bio": "Passionné de voyages",
     *       "gender": "male",
     *       "age": 25,
     *       "country_id": 1,
     *       "city_id": 1,
     *       "height": 175,
     *       "hobbies": ["voyage", "sport", "musique"],
     *       "avatar": null,
     *       "created_at": "2025-10-10T15:30:00.000000Z",
     *       "updated_at": "2025-10-10T15:30:00.000000Z"
     *     }
     *   }
     * }
     * @response 404 scenario="Utilisateur non trouvé" {
     *   "success": false,
     *   "message": "Utilisateur non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $user = User::with('profile')->find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
        ]);
    }

    /**
     * @group Users
     *
     * Mettre à jour un utilisateur
     *
     * Met à jour les informations d'un utilisateur et de son profil.
     *
     * @urlParam id integer required ID de l'utilisateur. Example: 1
     *
     * @bodyParam name string Nom complet de l'utilisateur. Example: John Doe
     * @bodyParam email string Email de l'utilisateur. Example: john@example.com
     * @bodyParam phone string Numéro de téléphone. Example: +225123456789
     * @bodyParam bio string Bio de l'utilisateur. Example: Passionné de voyages
     * @bodyParam gender string Genre (male, female, other). Example: male
     * @bodyParam age integer Âge (18-100). Example: 25
     * @bodyParam country_id integer ID du pays. Example: 1
     * @bodyParam city_id integer ID de la ville. Example: 1
     * @bodyParam height integer Taille en cm (100-250). Example: 175
     * @bodyParam hobbies array Centres d'intérêt. Example: ["voyage", "sport", "musique"]
     *
     * @response 200 scenario="Utilisateur mis à jour" {
     *   "success": true,
     *   "message": "Utilisateur mis à jour avec succès",
     *   "data": {
     *     "user": {
     *       "id": 1,
     *       "uuid": "40e35362-0215-45df-8afe-293778cb6ec7",
     *       "name": "John Doe",
     *       "email": "john@example.com",
     *       "phone": "+225123456789",
     *       "is_certified": true,
     *       "last_login_at": "2025-10-10T15:30:00.000000Z",
     *       "created_at": "2025-10-10T14:00:00.000000Z",
     *       "updated_at": "2025-10-10T15:30:00.000000Z"
     *     },
     *     "profile": {
     *       "id": 1,
     *       "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *       "user_id": 1,
     *       "bio": "Passionné de voyages",
     *       "gender": "male",
     *       "age": 25,
     *       "country_id": 1,
     *       "city_id": 1,
     *       "height": 175,
     *       "hobbies": ["voyage", "sport", "musique"],
     *       "avatar": null,
     *       "created_at": "2025-10-10T15:30:00.000000Z",
     *       "updated_at": "2025-10-10T15:30:00.000000Z"
     *     }
     *   }
     * }
     * @response 404 scenario="Utilisateur non trouvé" {
     *   "success": false,
     *   "message": "Utilisateur non trouvé"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé',
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'sometimes|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'gender' => 'nullable|in:male,female,other',
            'age' => 'nullable|integer|min:18|max:100',
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'height' => 'nullable|integer|min:100|max:250',
            'hobbies' => 'nullable|array',
            'hobbies.*' => 'string|max:100',
        ]);

        $user->update($request->only(['name', 'email', 'phone']));

        if ($user->profile) {
            $user->profile->update($request->only([
                'bio', 'gender', 'age', 'country_id', 'city_id', 'height', 'hobbies',
            ]));
        }

        $user->load('profile');

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur mis à jour avec succès',
            'data' => new UserResource($user),
        ]);
    }

    /**
     * @group Users
     *
     * Supprimer un utilisateur
     *
     * Supprime un utilisateur et son profil (soft delete).
     *
     * @urlParam id integer required ID de l'utilisateur. Example: 1
     *
     * @response 200 scenario="Utilisateur supprimé" {
     *   "success": true,
     *   "message": "Utilisateur supprimé avec succès"
     * }
     * @response 404 scenario="Utilisateur non trouvé" {
     *   "success": false,
     *   "message": "Utilisateur non trouvé"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès',
        ]);
    }
}
