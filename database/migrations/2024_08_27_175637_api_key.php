<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Выполните миграцию.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_user_keys', function (Blueprint $table) {
            $table->string('api_key')->nullable(); // Замените new_column на нужное имя столбца
        });
    }

    /**
     * Откатите миграцию.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_user_keys', function (Blueprint $table) {
            $table->dropColumn('api_key'); // Удалите тот же столбец в случае отката
        });
    }
};
