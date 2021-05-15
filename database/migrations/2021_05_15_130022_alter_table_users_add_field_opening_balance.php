<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersAddFieldOpeningBalance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('users', 'opening_balance')) {
		    Schema::table('users', function (Blueprint $table) {
                $table->bigInteger('opening_balance')->default(0)->after('birthday'); 
		    });
	    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn('users', 'opening_balance')) {
		    Schema::table('users', function (Blueprint $table) {
			    $table->dropColumn('opening_balance');
		    });
	    }
    }
}
