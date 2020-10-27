<?php

namespace App\Http;

use App\Models\Transition;
use App\Models\UserCard;
use Illuminate\Support\Facades\DB;

class BatchTransitioner
{
    static function HandleExpiredAuthorizations()
    {
        $expiredAuthCardIds = DB::select('select user_cards.id from user_cards inner join authorizations on user_cards.authorization_id = authorizations.id  where user_cards.state = 6 and authorizations.expires_at < now()');
        foreach($expiredAuthCardIds as $c)
        {
            $userCard = UserCard::find($c->id);
            $userCard->state = UserCard::PENDING_QUESTIONNAIRE_2;
            $userCard->authorization_id = null;
            $userCard->save();

            $t = Transition::create([
                'user_id' => $userCard->user->id,
                'state' => $userCard->state,
                'actor' => 'System',
            ]);
        }
    }

    static function HandleRequiredNewTests()
    {
        $max_days = env('MAX_DAYS_BEFORE_NEW_TEST_REQUIRED');
        $query = "SELECT user_cards.id, users.email, user_cards.most_recent_negative_test_result_at, user_cards.state, DATEDIFF(NOW(), user_cards.most_recent_negative_test_result_at) AS day_count
                FROM user_cards
                    INNER JOIN  users ON user_cards.user_id = users.id
                    INNER JOIN tracked_accounts ON users.tracked_account_id = tracked_accounts.id
                WHERE (tracked_accounts.account_type_id = 3 OR tracked_accounts.account_type_id = 2) AND (user_cards.state = 5 OR user_cards.state = 6)
                HAVING day_count >= {$max_days}
                ORDER BY most_recent_negative_test_result_at;";

        $affectedRecords = DB::select($query);
        foreach($affectedRecords as $c)
        {
            $userCard = UserCard::find($c->id);
            $userCard->state = UserCard::PENDING_COVERED_TEST_2;
            $userCard->authorization_id = null;
            $userCard->requires_maintenance_test = 1;
            $userCard->save();

            Transition::create([
                'user_id' => $userCard->user->id,
                'state' => $userCard->state,
                'actor' => 'System',
            ]);
        }
    }

    static function HandleNewTestsDueSoon()
    {
        $max_days = env('MAX_DAYS_BEFORE_NEW_TEST_REQUIRED');
        $days_before_warning = env('DAYS_BEFORE_NEW_TEST_DUE_SOON_WARNING');
        $query = "SELECT user_cards.id, users.email, user_cards.most_recent_negative_test_result_at, user_cards.state, DATEDIFF(NOW(), user_cards.most_recent_negative_test_result_at) AS day_count
                FROM user_cards
                    INNER JOIN  users ON user_cards.user_id = users.id
                    INNER JOIN tracked_accounts ON users.tracked_account_id = tracked_accounts.id
                WHERE (tracked_accounts.account_type_id = 3 OR tracked_accounts.account_type_id = 2) AND (user_cards.state = 5 OR user_cards.state = 6)
                HAVING day_count >= {$days_before_warning} AND day_count < {$max_days}
                ORDER BY most_recent_negative_test_result_at;";

        $affectedRecords = DB::select($query);
        foreach($affectedRecords as $c)
        {
            $userCard = UserCard::find($c->id);
            $userCard->requires_maintenance_test = 1;
            $userCard->save();
        }
    }
}
