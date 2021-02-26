<?php

namespace Database\Seeders;

use App\Models\Instruction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayInstructions = [
            [
                'title' => 'Инструкция к холодильнику',
                'description' => 'Холодильник важная часть обихода человека. Поэтому им важно пользоваться правильно. Попробуйте открыть дверцу холодильника без инструкции и он с некоторой долей вероятности может развалиться на месте. Не упускай возможность узнать как пользоваться холодильником заранее.',
                'file_name' => '09dfb440-76b5-11eb-a7b3-c1aaf7be504c_.txt',
                'status_approved' => 0,
                'author_id' => 1,
            ],
            [
                'title' => 'Ритуальный Бубен DX-473 для компилирования программ',
                'description' => 'Ритуальный Бубен DX-473 - категорически необходимый предмет в Вашем арсенале программиста.',
                'file_name' => 'f3b42f20-17a8-406c-9c4e-4a865e0a97ed_.txt',
                'status_approved' => 0,
                'author_id' => 2,
            ],
        ];

        if( count($arrayInstructions) > 0 ){
            foreach ($arrayInstructions as $instruction) {
                $instructionFound = DB::table('instructions')
                    ->where('title', '=', $instruction['title'])->first();

                if( !$instructionFound ) {
                    $newInstruction = new Instruction();
                    $newInstruction->title = $instruction['title'];
                    $newInstruction->description = $instruction['description'];
                    $newInstruction->file_name = $instruction['file_name'];
                    $newInstruction->status_approved = $instruction['status_approved'];
                    $newInstruction->author_id = $instruction['author_id'];
                    // set created At and updated At?

                    $newInstruction->save();
                }
            }
        }
    }
}
