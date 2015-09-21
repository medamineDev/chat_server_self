<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $i = 0;

        while ($i <10000) {


            DB::table('messages')->insert([
                'id_sender' => 1,
                'id_receiver' => 23,
                //'message_body' => 'msg '.$i.' slt bilel',
                'message_body' => '{id : "1" , id_conversation : "1,23" , message : " msg :  ' . $i . '  slt bilel" }'
            ]);

            DB::table('messages')->insert([
                'id_sender' => 23,
                'id_receiver' => 1,
                'message_body' => '{id : "23" , id_conversation : "23,1" , message : " msg :  ' . $i . '   slt amine" }' //  'msg '.$i.' slt amine',
            ]);


            $i++;

        }


        Model::unguard();

        // $this->call('UserTableSeeder');
    }

}
