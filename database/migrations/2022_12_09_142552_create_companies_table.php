<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->date('established_on');
            $table->unsignedBigInteger('number_of_employees');
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('phone_number')->index();
            $table->string('email')->unique();
            $table->string('website')->nullable();
            $table->text('about');
            $table->timestamps();
        });

        $data = [];
        $tlds = ['com', 'org', 'gov', 'us', 'io', 'ai', 'app', 'store', 'net'];
        $tldsCount = count($tlds)-1;
        $faker = \Faker\Factory::create();
        for ($i=0; $i < 1000 ; $i++) {
            $website = $faker->lexify('?????????????????') . '.' . $tlds[random_int(0, $tldsCount)];
            $data[] = [
                'name' => $faker->company(),
                'established_on' => $faker->dateTime(),
                'number_of_employees' => $faker->randomNumber(5, false),
                'street' => $faker->streetName(),
                'city' => $faker->city(),
                'state' => $faker->state(),
                'phone_number' => $faker->phoneNumberWithExtension(),
                'email' => $faker->unique()->email,
                'website' => $website,
                'about' => substr($faker->realText(), 0, 65000),
            ];
        }

        DB::table('companies')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
