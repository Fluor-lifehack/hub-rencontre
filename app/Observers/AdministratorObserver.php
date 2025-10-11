<?php

namespace App\Observers;

use App\Models\Administrator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdministratorObserver
{
    /**
     * Handle the Administrator "creating" event.
     */
    public function creating(Administrator $administrator): void
    {
        if (empty($administrator->uuid)) {
            $administrator->uuid = Str::uuid();
        }

        // Définir un mot de passe par défaut si aucun n'est fourni
        if (empty($administrator->password)) {
            $administrator->password = Hash::make('password');
        }
    }

    /**
     * Handle the Administrator "created" event.
     */
    public function created(Administrator $administrator): void
    {
        // Vérifier automatiquement l'email si pas déjà fait
        if (!$administrator->email_verified_at) {
            $administrator->update(['email_verified_at' => now()]);
        }

        // Envoyer une notification de bienvenue (optionnel)
        // $administrator->notify(new AdministratorWelcomeNotification());

        // Logger la création
        \Log::info('Nouvel administrateur créé', [
            'id' => $administrator->id,
            'uuid' => $administrator->uuid,
            'name' => $administrator->name,
            'email' => $administrator->email,
            'role' => $administrator->role,
            'created_at' => $administrator->created_at,
        ]);

        // Créer un log d'activité pour l'audit
        \Log::channel('admin')->info('Administrator account created', [
            'administrator_id' => $administrator->id,
            'administrator_uuid' => $administrator->uuid,
            'administrator_name' => $administrator->name,
            'administrator_email' => $administrator->email,
            'role' => $administrator->role,
            'is_active' => $administrator->is_active,
            'created_by' => auth()->guard('admin')->id() ?? 'system',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the Administrator "updating" event.
     */
    public function updating(Administrator $administrator): void
    {
        //
    }

    /**
     * Handle the Administrator "updated" event.
     */
    public function updated(Administrator $administrator): void
    {
        // Logger les modifications importantes
        $changes = $administrator->getChanges();

        if (!empty($changes)) {
            \Log::channel('admin')->info('Administrator account updated', [
                'administrator_id' => $administrator->id,
                'administrator_uuid' => $administrator->uuid,
                'administrator_name' => $administrator->name,
                'administrator_email' => $administrator->email,
                'changes' => $changes,
                'updated_by' => auth()->guard('admin')->id() ?? 'system',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }

    /**
     * Handle the Administrator "deleting" event.
     */
    public function deleting(Administrator $administrator): void
    {
        // Empêcher la suppression du dernier super admin
        if ($administrator->isSuperAdmin()) {
            $superAdminCount = Administrator::where('role', 'super_admin')->count();
            if ($superAdminCount <= 1) {
                throw new \Exception('Impossible de supprimer le dernier super administrateur');
            }
        }

        // Logger la suppression
        \Log::channel('admin')->warning('Administrator account deletion attempted', [
            'administrator_id' => $administrator->id,
            'administrator_uuid' => $administrator->uuid,
            'administrator_name' => $administrator->name,
            'administrator_email' => $administrator->email,
            'role' => $administrator->role,
            'deleted_by' => auth()->guard('admin')->id() ?? 'system',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the Administrator "deleted" event.
     */
    public function deleted(Administrator $administrator): void
    {
        // Logger la suppression effective
        \Log::channel('admin')->critical('Administrator account deleted', [
            'administrator_id' => $administrator->id,
            'administrator_uuid' => $administrator->uuid,
            'administrator_name' => $administrator->name,
            'administrator_email' => $administrator->email,
            'role' => $administrator->role,
            'deleted_by' => auth()->guard('admin')->id() ?? 'system',
            'deleted_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Nettoyer les sessions actives de cet administrateur
        \DB::table('sessions')
            ->where('user_id', $administrator->id)
            ->where('guard', 'admin')
            ->delete();
    }

    /**
     * Handle the Administrator "restored" event.
     */
    public function restored(Administrator $administrator): void
    {
        //
    }

    /**
     * Handle the Administrator "force deleted" event.
     */
    public function forceDeleted(Administrator $administrator): void
    {
        //
    }
}
