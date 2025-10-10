<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Administrator;
use App\Models\Block;
use App\Models\City;
use App\Models\Conversation;
use App\Models\Country;
use App\Models\Favorite;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Photo;
use App\Models\Plan;
use App\Models\Preference;
use App\Models\Profile;
use App\Models\Report;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserMatch;
use App\Models\View;
use App\Observers\ActivityLogObserver;
use App\Observers\AdministratorObserver;
use App\Observers\BlockObserver;
use App\Observers\CityObserver;
use App\Observers\ConversationObserver;
use App\Observers\CountryObserver;
use App\Observers\FavoriteObserver;
use App\Observers\MessageObserver;
use App\Observers\NotificationObserver;
use App\Observers\PhotoObserver;
use App\Observers\PlanObserver;
use App\Observers\PreferenceObserver;
use App\Observers\ProfileObserver;
use App\Observers\ReportObserver;
use App\Observers\SettingObserver;
use App\Observers\SubscriptionObserver;
use App\Observers\TransactionObserver;
use App\Observers\UserMatchObserver;
use App\Observers\UserObserver;
use App\Observers\ViewObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enregistrer les observers pour la génération automatique des UUIDs
        User::observe(UserObserver::class);
        Profile::observe(ProfileObserver::class);
        Country::observe(CountryObserver::class);
        City::observe(CityObserver::class);
        Plan::observe(PlanObserver::class);
        Subscription::observe(SubscriptionObserver::class);
        Transaction::observe(TransactionObserver::class);
        Photo::observe(PhotoObserver::class);
        UserMatch::observe(UserMatchObserver::class);
        Administrator::observe(AdministratorObserver::class);
        Preference::observe(PreferenceObserver::class);
        Favorite::observe(FavoriteObserver::class);
        Conversation::observe(ConversationObserver::class);
        Message::observe(MessageObserver::class);
        View::observe(ViewObserver::class);
        Block::observe(BlockObserver::class);
        Report::observe(ReportObserver::class);
        Notification::observe(NotificationObserver::class);
        Setting::observe(SettingObserver::class);
        ActivityLog::observe(ActivityLogObserver::class);
    }
}
