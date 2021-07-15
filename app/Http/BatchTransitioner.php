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
            $from_state = $userCard->state;
            $userCard->state = UserCard::PENDING_QUESTIONNAIRE_2;
            $userCard->authorization_id = null;
            $userCard->save();

            $t = Transition::create([
                'user_id' => $userCard->user->id,
                'state' => $userCard->state,
                'actor' => 'System',
                'from_state' => $from_state,
            ]);
        }
    }

    static function HandleRequiredNewTests_StaffAndFaculty()
    {
        $query = "SELECT user_cards.id, users.email, user_cards.most_recent_negative_test_result_at, user_cards.state
                FROM user_cards
                    INNER JOIN  users ON user_cards.user_id = users.id
                    INNER JOIN tracked_accounts ON users.tracked_account_id = tracked_accounts.id
                WHERE (tracked_accounts.account_type_id = 3 OR tracked_accounts.account_type_id = 2)
                    AND (user_cards.completed_immunization == 0)
                    AND (user_cards.state = 5 OR user_cards.state = 6) AND (user_cards.next_test_result_due_date < NOW())
                ORDER BY most_recent_negative_test_result_at;";

        $affectedRecords = DB::select($query);
        foreach($affectedRecords as $c)
        {
            $userCard = UserCard::find($c->id);
            $from_state = $userCard->state;
            $userCard->state = UserCard::PENDING_COVERED_TEST_2;
            $userCard->authorization_id = null;
            $userCard->requires_maintenance_test = 1;
            $userCard->save();

            Transition::create([
                'user_id' => $userCard->user->id,
                'state' => $userCard->state,
                'actor' => 'System',
                'from_state' => $from_state,
            ]);
        }
    }

    static function HandleRequiredNewTest_Students()
    {
        $query = "SELECT user_cards.id, users.email, user_cards.most_recent_negative_test_result_at, user_cards.state
                FROM user_cards
                    INNER JOIN  users ON user_cards.user_id = users.id
                    INNER JOIN tracked_accounts ON users.tracked_account_id = tracked_accounts.id
                    INNER JOIN `groups` ON tracked_accounts.group_id = `groups`.id
                WHERE tracked_accounts.account_type_id = 1 AND `groups`.automatically_require_maintenance_test = 1
                    AND (user_cards.completed_immunization == 0)
                    AND (user_cards.state = 5 OR user_cards.state = 6) AND (user_cards.next_test_result_due_date < NOW())
                ORDER BY most_recent_negative_test_result_at;";

        $affectedRecords = DB::select($query);
        foreach($affectedRecords as $c)
        {
            $userCard = UserCard::find($c->id);
            $from_state = $userCard->state;
            $userCard->state = UserCard::PENDING_COVERED_TEST_2;
            $userCard->authorization_id = null;
            $userCard->requires_maintenance_test = 1;
            $userCard->save();

            Transition::create([
                'user_id' => $userCard->user->id,
                'state' => $userCard->state,
                'actor' => 'System',
                'from_state' => $from_state,
            ]);
        }
    }

    static function HandleNewTestsDueSoon_StaffAndFaculty()
    {
        $days_before_warning = env('DAYS_BEFORE_NEXT_TEST_WARNING');
        $query = "SELECT user_cards.id, users.email, user_cards.most_recent_negative_test_result_at, user_cards.state, DATEDIFF(user_cards.next_test_result_due_date, NOW()) AS day_count
                FROM user_cards
                    INNER JOIN  users ON user_cards.user_id = users.id
                    INNER JOIN tracked_accounts ON users.tracked_account_id = tracked_accounts.id
                WHERE (tracked_accounts.account_type_id = 3 OR tracked_accounts.account_type_id = 2)
                    AND (user_cards.completed_immunization == 0)
                    AND NOT requires_maintenance_test = 1 AND (user_cards.state = 5 OR user_cards.state = 6)
                    AND NOT user_cards.next_test_result_due_date IS NULL
                HAVING day_count < {$days_before_warning}
                ORDER BY most_recent_negative_test_result_at;";

        $affectedRecords = DB::select($query);
        foreach($affectedRecords as $c)
        {
            $userCard = UserCard::find($c->id);
            $userCard->requires_maintenance_test = 1;
            $userCard->save();
        }
    }

    static function HandleNewTestsDueSoon_Students()
    {
        $days_before_warning = env('DAYS_BEFORE_NEXT_TEST_WARNING');
        $query = "SELECT user_cards.id, users.email, user_cards.most_recent_negative_test_result_at, user_cards.state, DATEDIFF(user_cards.next_test_result_due_date, NOW()) AS day_count
                FROM user_cards
                    INNER JOIN  users ON user_cards.user_id = users.id
                    INNER JOIN tracked_accounts ON users.tracked_account_id = tracked_accounts.id
                    INNER JOIN `groups` ON tracked_accounts.group_id = `groups`.id
                WHERE tracked_accounts.account_type_id = 1 AND `groups`.automatically_require_maintenance_test = 1
                    AND (user_cards.completed_immunization == 0)
                    AND NOT requires_maintenance_test = 1 AND (user_cards.state = 5 OR user_cards.state = 6)
                    AND NOT user_cards.next_test_result_due_date IS NULL
                HAVING day_count < {$days_before_warning}
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
