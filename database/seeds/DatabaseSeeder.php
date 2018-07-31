<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $recipients = [];

        /**
         * This first recipient will be used for later testing the API
         */
        $recipients[] = DB::table('recipients')
            ->insertGetId([
                'name'          => 'John Doe',
                'email'         => 'john@doe.com',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

        for ($i = 0; $i < 49; $i++) {
            $recipients[] = DB::table('recipients')
                ->insertGetId([
                    'name'          => $faker->name,
                    'email'         => $faker->unique()->email,
                    'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
        }

        for ($i = 0; $i < 5; $i++) {
            $offer = DB::table('offers')
                ->insertGetId([
                    'name'          => $faker->sentence(4),
                    'discount'      => $faker->numberBetween(1, 20) * 5,
                    'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

            foreach ($recipients as $recipient) {
                DB::table('voucher_codes')
                    ->insert([
                        'offer_id'  => $offer,
                        'recipient_id'      => $recipient,
                        'code'              => str_random(12),
                        'used_on'           => (mt_rand(0, 2) <= 1) ? $faker->dateTimeBetween('-2 months', 'now') : NULL,
                        'created_at'        => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at'        => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
            }
        }
    }
}
