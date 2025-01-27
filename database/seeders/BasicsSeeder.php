<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Background;
use App\Models\Sobre;
use Illuminate\Support\Facades\DB;


class BasicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('backgrounds')->insert([
            'name'=>'Basic',
            'color'=>'grey',
            'cost'=>0
        ]);

        DB::table('sobres')->insert([
            'name'=>'normal',
            'type'=>'normal,epica',
            'cost'=>1000
        ]);

        DB::table('sobres')->insert([
            'name'=>'supersobre',
            'type'=>'normal,epica,legendaria',
            'cost'=>4000
        ]);

        DB::table('sobres')->insert([
            'name'=>'megasobre',
            'type'=>'normal,epica,legendaria',
            'cost'=>8000
        ]);

    }
}
