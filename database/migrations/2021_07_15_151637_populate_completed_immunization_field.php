<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PopulateCompletedImmunizationField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Mark those that got at least one Jenssen's vaccine
        $sql = "UPDATE user_cards
            SET completed_immunization = 1
            WHERE user_id IN (SELECT DISTINCT user_id FROM vaccinations
            WHERE vaccine_type_id = 3);";
        DB::update($sql);

        // Mark those that got 2 or more doses of any vaccine
        $sql = "UPDATE user_cards
        SET completed_immunization = 1
        WHERE user_id IN (
            SELECT user_id
                FROM (
                SELECT user_id, count(*) AS vac_count
                FROM vaccinations
                GROUP BY user_id
                HAVING vac_count > 1
            ) AS two_doses_or_more
        );";
        DB::update($sql);

        // Set status as Pending Questionare 2
        // for all those who completed immunazation and were pending a rapid test
        $sql = "UPDATE user_cards
            SET user_cards.state = 5, user_cards.requires_maintenance_test = 0
            WHERE completed_immunization = 1 AND (user_cards.state = 3 OR user_cards.state = 4);";
        DB::update($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
