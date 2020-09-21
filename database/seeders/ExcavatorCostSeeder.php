<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ExcavatorCostSeeder extends Seeder
{
    /**
     * @var \App\Models\ExcavatorCost
     */
    protected $excavatorCosts;

    /**
     * ExcavatorCostSeeder constructor.
     * @param \App\Models\ExcavatorCost $excavatorCosts
     */
    public function __construct(\App\Models\ExcavatorCost $excavatorCosts)
    {
        $this->excavatorCosts = $excavatorCosts;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->excavatorCosts->insert([
           [
               'name'=>'代缴税额',
               'parent_id'=>0,
           ],
            [
                'name'=>'申报机价',
                'parent_id'=>1
            ],

            [
                'name'=>'增值税30%',
                'parent_id'=>1
            ],
            [
                'name'=>'关税8%',
                'parent_id'=>1
            ],
            [
                'name'=>'香港中检费',
                'parent_id'=>0
            ],

            [
                'name'=>'证书费',
                'parent_id'=>5
            ],
            [
                'name'=>'证书费',
                'parent_id'=>5
            ]
        ]);
    }
}
