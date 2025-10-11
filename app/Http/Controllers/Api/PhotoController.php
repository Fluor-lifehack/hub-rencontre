<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * @group Photos
     *
     * Liste des photos
     *
     * Récupère la liste paginée des photos d'un utilisateur.
     *
     * @queryParam page integer Numéro de page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 50). Example: 15
     * @queryParam user_id integer Filtrer par utilisateur. Example: 1
     * @queryParam is_profile boolean Filtrer par photo de profil. Example: true
     *
     * @response 200 scenario="Liste récupérée" {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "id": 1,
     *         "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *         "user_id": 1,
     *         "path": "photos/user1/photo1.jpg",
     *         "is_profile": true,
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
     *     "total": 10
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $query = Photo::with('user');

        // Filtres
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        if ($request->filled('is_profile')) {
            $query->where('is_profile', $request->boolean('is_profile'));
        }

        $perPage = min($request->get('per_page', 15), 50);
        $photos = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => PhotoResource::collection($photos),
        ]);
    }

    /**
     * @group Photos
     *
     * Uploader une photo
     *
     * Upload une nouvelle photo pour un utilisateur.
     *
     * @bodyParam user_id integer required ID de l'utilisateur. Example: 1
     * @bodyParam photo file required Photo à uploader (image, max 5MB). Example: photo.jpg
     * @bodyParam is_profile boolean Photo de profil. Example: false
     *
     * @response 201 scenario="Photo uploadée" {
     *   "success": true,
     *   "message": "Photo uploadée avec succès",
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "user_id": 1,
     *     "path": "photos/user1/photo1.jpg",
     *     "is_profile": false,
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z"
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'photo' => 'required|image|max:5120', // 5MB max
            'is_profile' => 'boolean',
        ]);

        $photoFile = $request->file('photo');
        $path = $photoFile->store('photos/user'.$request->user_id, 'public');

        $photo = Photo::create([
            'user_id' => $request->user_id,
            'path' => $path,
            'is_profile' => $request->boolean('is_profile', false),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Photo uploadée avec succès',
            'data' => new PhotoResource($photo),
        ], 201);
    }

    /**
     * @group Photos
     *
     * Détails d'une photo
     *
     * Récupère les détails d'une photo.
     *
     * @urlParam id integer required ID de la photo. Example: 1
     *
     * @response 200 scenario="Photo trouvée" {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "user_id": 1,
     *     "path": "photos/user1/photo1.jpg",
     *     "is_profile": true,
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z",
     *     "user": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "john@example.com"
     *     }
     *   }
     * }
     * @response 404 scenario="Photo non trouvée" {
     *   "success": false,
     *   "message": "Photo non trouvée"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $photo = Photo::with('user')->find($id);

        if (! $photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo non trouvée',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new PhotoResource($photo),
        ]);
    }

    /**
     * @group Photos
     *
     * Mettre à jour une photo
     *
     * Met à jour les informations d'une photo.
     *
     * @urlParam id integer required ID de la photo. Example: 1
     *
     * @bodyParam is_profile boolean Photo de profil. Example: true
     *
     * @response 200 scenario="Photo mise à jour" {
     *   "success": true,
     *   "message": "Photo mise à jour avec succès",
     *   "data": {
     *     "id": 1,
     *     "uuid": "3fe609a4-a037-4dab-adca-6c8e94a242c4",
     *     "user_id": 1,
     *     "path": "photos/user1/photo1.jpg",
     *     "is_profile": true,
     *     "created_at": "2025-10-10T15:30:00.000000Z",
     *     "updated_at": "2025-10-10T15:30:00.000000Z"
     *   }
     * }
     * @response 404 scenario="Photo non trouvée" {
     *   "success": false,
     *   "message": "Photo non trouvée"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $photo = Photo::find($id);

        if (! $photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo non trouvée',
            ], 404);
        }

        $request->validate([
            'is_profile' => 'boolean',
        ]);

        $photo->update($request->only(['is_profile']));

        return response()->json([
            'success' => true,
            'message' => 'Photo mise à jour avec succès',
            'data' => new PhotoResource($photo),
        ]);
    }

    /**
     * @group Photos
     *
     * Supprimer une photo
     *
     * Supprime une photo et le fichier associé.
     *
     * @urlParam id integer required ID de la photo. Example: 1
     *
     * @response 200 scenario="Photo supprimée" {
     *   "success": true,
     *   "message": "Photo supprimée avec succès"
     * }
     * @response 404 scenario="Photo non trouvée" {
     *   "success": false,
     *   "message": "Photo non trouvée"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $photo = Photo::find($id);

        if (! $photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo non trouvée',
            ], 404);
        }

        // Supprimer le fichier
        \Storage::disk('public')->delete($photo->path);

        $photo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Photo supprimée avec succès',
        ]);
    }
}
