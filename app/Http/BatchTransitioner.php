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
}
