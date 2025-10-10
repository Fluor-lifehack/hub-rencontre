<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @group Authentication
     *
     * Connexion utilisateur
     *
     * Permet à un utilisateur de se connecter et d'obtenir un token d'authentification.
     * L'utilisateur peut se connecter avec son numéro de téléphone ou son email.
     *
     * @bodyParam phone string Numéro de téléphone de l'utilisateur. Example: +225123456789
     * @bodyParam email string Email de l'utilisateur. Example: user@example.com
     * @bodyParam password string required Mot de passe de l'utilisateur. Example: password123
     *
     * @response 200 scenario="Connexion réussie" {
     *   "success": true,
     *   "message": "Connexion réussie",
     *   "data": {
     *     "user": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "user@example.com",
     *       "phone": "+225123456789",
     *       "is_certified": false,
     *       "last_login_at": "2025-10-10T15:30:00.000000Z",
     *       "created_at": "2025-10-10T14:00:00.000000Z",
     *       "updated_at": "2025-10-10T15:30:00.000000Z"
     *     },
     *     "token": "1|abcdef123456789..."
     *   }
     * }
     * @response 422 scenario="Erreur de validation" {
     *   "success": false,
     *   "message": "Les données fournies ne sont pas valides",
     *   "errors": {
     *     "phone": ["Le numéro de téléphone ou l'email est requis."],
     *     "password": ["Le champ password est requis."]
     *   }
     * }
     * @response 401 scenario="Identifiants incorrects" {
     *   "success": false,
     *   "message": "Identifiants incorrects"
     * }
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required_without:email|string',
            'email' => 'required_without:phone|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('password');

        // Déterminer le champ d'identification (phone ou email)
        if ($request->has('phone')) {
            $credentials['phone'] = $request->phone;
        } else {
            $credentials['email'] = $request->email;
        }

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'phone' => ['Identifiants incorrects'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('auth-token')->plainTextToken;

        // Mettre à jour la dernière connexion
        $user->update(['last_login_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    /**
     * @group Authentication
     *
     * Inscription utilisateur
     *
     * Permet à un nouvel utilisateur de s'inscrire sur la plateforme.
     * Seul le numéro de téléphone est obligatoire, le nom et l'email sont optionnels.
     *
     * @bodyParam name string Nom complet de l'utilisateur. Example: John Doe
     * @bodyParam email string Email de l'utilisateur. Example: user@example.com
     * @bodyParam phone string required Numéro de téléphone unique. Example: +225123456789
     * @bodyParam password string required Mot de passe (minimum 6 caractères). Example: password123
     * @bodyParam password_confirmation string required Confirmation du mot de passe. Example: password123
     *
     * @response 201 scenario="Inscription réussie" {
     *   "success": true,
     *   "message": "Inscription réussie",
     *   "data": {
     *     "user": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "user@example.com",
     *       "phone": "+225123456789",
     *       "is_certified": false,
     *       "last_login_at": null,
     *       "created_at": "2025-10-10T15:30:00.000000Z",
     *       "updated_at": "2025-10-10T15:30:00.000000Z"
     *     },
     *     "token": "1|abcdef123456789..."
     *   }
     * }
     * @response 422 scenario="Erreur de validation" {
     *   "success": false,
     *   "message": "Les données fournies ne sont pas valides",
     *   "errors": {
     *     "phone": ["Le numéro de téléphone a déjà été pris."],
     *     "email": ["L'email a déjà été pris."],
     *     "password": ["La confirmation du mot de passe ne correspond pas."]
     *   }
     * }
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $userData = [
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ];

        // Ajouter le nom s'il est fourni
        if ($request->has('name') && !empty($request->name)) {
            $userData['name'] = $request->name;
        }

        // Ajouter l'email s'il est fourni
        if ($request->has('email') && !empty($request->email)) {
            $userData['email'] = $request->email;
        }

        $user = User::create($userData);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Inscription réussie',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 201);
    }

    /**
     * @group Authentication
     *
     * Déconnexion utilisateur
     *
     * Permet à un utilisateur de se déconnecter en révoquant son token d'authentification.
     *
     * @authenticated
     *
     * @response 200 scenario="Déconnexion réussie" {
     *   "success": true,
     *   "message": "Déconnexion réussie"
     * }
     * @response 401 scenario="Non authentifié" {
     *   "success": false,
     *   "message": "Non authentifié"
     * }
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie',
        ]);
    }

    /**
     * @group Authentication
     *
     * Profil utilisateur connecté
     *
     * Récupère les informations du profil de l'utilisateur actuellement connecté.
     *
     * @authenticated
     *
     * @response 200 scenario="Profil récupéré" {
     *   "success": true,
     *   "data": {
     *     "user": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "user@example.com",
     *       "phone": "+225123456789",
     *       "is_certified": false,
     *       "last_login_at": "2025-10-10T15:30:00.000000Z",
     *       "created_at": "2025-10-10T14:00:00.000000Z",
     *       "updated_at": "2025-10-10T15:30:00.000000Z"
     *     }
     *   }
     * }
     * @response 401 scenario="Non authentifié" {
     *   "success": false,
     *   "message": "Non authentifié"
     * }
     */
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $request->user(),
            ],
        ]);
    }
}
