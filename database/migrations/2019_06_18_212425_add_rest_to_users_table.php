<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRestToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('Historicresttime')->nullable();
            $table->integer('Historicsavedcount')->default('0');
            $table->integer('HistoricTotalSaveCount')->default('0');
            $table->dateTime('HistoricFirstDate')->nullable();
            $table->boolean('IsHistoricRest')->default(true);

            $table->integer('Vacantresttime')->nullable();
            $table->integer('Vacantsavedcount')->default('0');
            $table->integer('VacantTotalSaveCount')->default('0');
            $table->dateTime('VacantFirstDate')->nullable();
            $table->boolean('IsVacantRest')->default(true);

            $table->integer('Addressresttime')->nullable();
            $table->integer('Addresssavedcount')->default('0');
            $table->integer('AddressTotalSaveCount')->default('0');
            $table->dateTime('AddressFirstDate')->nullable();
            $table->boolean('IsAddressRest')->default(true);

            $table->integer('Personresttime')->nullable();
            $table->integer('Personsavedcount')->default('0');
            $table->integer('PersonTotalSaveCount')->default('0');
            $table->dateTime('PersonFirstDate')->nullable();
            $table->boolean('IsPersonRest')->default(true);


            $table->integer('TotalSaveCount')->default('0');
            $table->dateTime('SavedPropertyFirstDate')->nullable();
            $table->boolean('IsSavedPropertyRest')->default(true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('Historicresttime');
            $table->dropColumn('Historicsavedcount');
            $table->dropColumn('HistoricTotalSaveCount');
            $table->dropColumn('HistoricFirstDate');
            $table->dropColumn('IsHistoricRest');

            $table->dropColumn('Vacantresttime');
            $table->dropColumn('Vacantsavedcount');
            $table->dropColumn('VacantTotalSaveCount');
            $table->dropColumn('VacantFirstDate');
            $table->dropColumn('IsVacantRest');

            $table->dropColumn('Addressresttime');
            $table->dropColumn('Addresssavedcount');
            $table->dropColumn('AddressTotalSaveCount');
            $table->dropColumn('AddressFirstDate');
            $table->dropColumn('IsAddressRest');

            $table->dropColumn('Personresttime');
            $table->dropColumn('Personsavedcount');
            $table->dropColumn('PersonTotalSaveCount');
            $table->dropColumn('PersonFirstDate');
            $table->dropColumn('IsPersonRest');

            $table->dropColumn('TotalSaveCount');
            $table->dropColumn('SavedPropertyFirstDate');
            $table->dropColumn('IsSavedPropertyRest');
        });
    }
}
