<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @group Profiles
     *
     * Liste des profils
     *
     * Récupère la liste paginée des profils avec leurs utilisateurs.
     *
     * @queryParam page integer Numéro de page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 50). Example: 15
     * @queryParam search string Recherche par bio ou nom d'utilisateur. Example: voyage
     * @queryParam gender string Filtrer par genre (male, female, other). Example: male
     * @queryParam age_min integer Âge minimum. Example: 18
     * @queryParam age_max integer Âge maximum. Example: 35
     * @queryParam country_id integer ID du pays. Example: 1
     * @queryParam city_id integer ID de la ville. Example: 1
     *
     * @response 200 scenario="Liste récupérée" {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "id": 1,
     *         "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *         "user_id": 1,
     *         "bio": "Passionné de voyages",
     *         "gender": "male",
     *         "age": 25,
     *         "country_id": 1,
     *         "city_id": 1,
     *         "height": 175,
     *         "hobbies": ["voyage", "sport", "musique"],
     *         "avatar": null,
     *         "created_at": "2025-10-10T15:30:00.000000Z",
     *         "updated_at": "2025-10-10T15:30:00.000000Z",
     *         "user": {
     *           "id": 1,
     *           "name": "John Doe",
     *           "email": "john@example.com"
     *         }
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
        $query = Profile::with(['user', 'country', 'city']);

        // Recherche
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('bio', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filtres
        if ($request->filled('gender')) {
            $query->where('gender', $request->get('gender'));
        }

        if ($request->filled('age_min')) {
            $query->where('age', '>=', $request->get('age_min'));
        }

        if ($request->filled('age_max')) {
            $query->where('age', '<=', $request->get('age_max'));
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->get('country_id'));
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->get('city_id'));
        }

        $perPage = min($request->get('per_page', 15), 50);
        $profiles = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => ProfileResource::collection($profiles),
        ]);
    }

    /**
     * @group Profiles
     *
     * Créer un profil
     *
     * Crée un nouveau profil pour un utilisateur.
     *
     * @bodyParam user_id integer required ID de l'utilisateur. Example: 1
     * @bodyParam bio string Bio de l'utilisateur. Example: Passionné de voyages
     * @bodyParam gender string Genre (male, female, other). Example: male
     * @bodyParam age integer Âge (18-100). Example: 25
     * @bodyParam country_id integer ID du pays. Example: 1
     * @bodyParam city_id integer ID de la ville. Example: 1
     * @bodyParam height integer Taille en cm (100-250). Example: 175
     * @bodyParam hobbies array Centres d'intérêt. Example: ["voyage", "sport", "musique"]
     * @bodyParam avatar file Photo de profil (image, max 2MB). Example: avatar.jpg
     *
     * @response 201 scenario="Profil créé" {
     *   "success": true,
     *   "message": "Profil créé avec succès",
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "user_id": 1,
     *     "bio": "Passionné de voyages",
     *     "gender": "male",
     *     "age": 25,
     *     "country_id": 1,
     *     "city_id": 1,
     *     "height": 175,
     *     "hobbies": ["voyage", "sport", "musique"],
     *     "avatar": "avatars/profile.jpg",
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z"
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:profiles,user_id',
            'bio' => 'nullable|string|max:1000',
            'gender' => 'nullable|in:male,female,other',
            'age' => 'nullable|integer|min:18|max:100',
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'height' => 'nullable|integer|min:100|max:250',
            'hobbies' => 'nullable|array',
            'hobbies.*' => 'string|max:100',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $profileData = $request->except(['avatar']);

        if ($request->hasFile('avatar')) {
            $profileData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $profile = Profile::create($profileData);

        return response()->json([
            'success' => true,
            'message' => 'Profil créé avec succès',
            'data' => new ProfileResource($profile),
        ], 201);
    }

    /**
     * @group Profiles
     *
     * Détails d'un profil
     *
     * Récupère les détails d'un profil avec ses relations.
     *
     * @urlParam id string required UUID du profil. Example: 3fe609a4-a037-4dab-adca-6c8e94a242c4
     *
     * @response 200 scenario="Profil trouvé" {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "user_id": 1,
     *     "bio": "Passionné de voyages",
     *     "gender": "male",
     *     "age": 25,
     *     "country_id": 1,
     *     "city_id": 1,
     *     "height": 175,
     *     "hobbies": ["voyage", "sport", "musique"],
     *     "avatar": "avatars/profile.jpg",
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z",
     *     "user": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "john@example.com"
     *     },
     *     "country": {
     *       "id": 1,
     *       "name": "Côte d'Ivoire",
     *       "code": "CIV"
     *     },
     *     "city": {
     *       "id": 1,
     *       "name": "Abidjan"
     *     }
     *   }
     * }
     * @response 404 scenario="Profil non trouvé" {
     *   "success": false,
     *   "message": "Profil non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $profile = Profile::where('uuid', $id)->with(['user', 'country', 'city'])->first();

        if (! $profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profil non trouvé',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ProfileResource($profile),
        ]);
    }

    /**
     * @group Profiles
     *
     * Mettre à jour un profil
     *
     * Met à jour les informations d'un profil.
     *
     * @urlParam id string required UUID du profil. Example: 3fe609a4-a037-4dab-adca-6c8e94a242c4
     *
     * @bodyParam bio string Bio de l'utilisateur. Example: Passionné de voyages
     * @bodyParam gender string Genre (male, female, other). Example: male
     * @bodyParam age integer Âge (18-100). Example: 25
     * @bodyParam country_id integer ID du pays. Example: 1
     * @bodyParam city_id integer ID de la ville. Example: 1
     * @bodyParam height integer Taille en cm (100-250). Example: 175
     * @bodyParam hobbies array Centres d'intérêt. Example: ["voyage", "sport", "musique"]
     * @bodyParam avatar file Photo de profil (image, max 2MB). Example: avatar.jpg
     *
     * @response 200 scenario="Profil mis à jour" {
     *   "success": true,
     *   "message": "Profil mis à jour avec succès",
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "user_id": 1,
     *     "bio": "Passionné de voyages",
     *     "gender": "male",
     *     "age": 25,
     *     "country_id": 1,
     *     "city_id": 1,
     *     "height": 175,
     *     "hobbies": ["voyage", "sport", "musique"],
     *     "avatar": "avatars/profile.jpg",
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z"
     *   }
     * }
     * @response 404 scenario="Profil non trouvé" {
     *   "success": false,
     *   "message": "Profil non trouvé"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $profile = Profile::where('uuid', $id)->first();

        if (! $profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profil non trouvé',
            ], 404);
        }

        $request->validate([
            'bio' => 'nullable|string|max:1000',
            'gender' => 'nullable|in:male,female,other',
            'age' => 'nullable|integer|min:18|max:100',
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'height' => 'nullable|integer|min:100|max:250',
            'hobbies' => 'nullable|array',
            'hobbies.*' => 'string|max:100',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $profileData = $request->except(['avatar']);

        if ($request->hasFile('avatar')) {
            // Supprimer l'ancienne image si elle existe
            if ($profile->avatar) {
                \Storage::disk('public')->delete($profile->avatar);
            }
            $profileData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $profile->update($profileData);

        return response()->json([
            'success' => true,
            'message' => 'Profil mis à jour avec succès',
            'data' => new ProfileResource($profile),
        ]);
    }

    /**
     * @group Profiles
     *
     * Supprimer son propre profil
     *
     * Supprime le profil de l'utilisateur authentifié.
     *
     * @response 200 scenario="Profil supprimé" {
     *   "success": true,
     *   "message": "Votre profil a été supprimé avec succès"
     * }
     * @response 404 scenario="Profil non trouvé" {
     *   "success": false,
     *   "message": "Profil non trouvé"
     * }
     * @response 403 scenario="Accès refusé" {
     *   "success": false,
     *   "message": "Vous ne pouvez supprimer que votre propre profil"
     * }
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non authentifié',
            ], 401);
        }

        $profile = $user->profile;

        if (! $profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profil non trouvé',
            ], 404);
        }

        // Supprimer l'image si elle existe
        if ($profile->avatar) {
            \Storage::disk('public')->delete($profile->avatar);
        }

        $profile->delete();

        return response()->json([
            'success' => true,
            'message' => 'Votre profil a été supprimé avec succès',
        ]);
    }
}
