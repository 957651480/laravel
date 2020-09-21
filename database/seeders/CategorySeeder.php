<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * @var \App\Models\Category
     */
    protected $categories;

    /**
     * CategorySeeder constructor.
     * @param \App\Models\Category $categories
     */
    public function __construct(\App\Models\Category $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->categories->insert([
           [
               'name'=>'首页',
               'parent_id'=>0,
           ],
            [
                'name'=>'客户案列',
                'parent_id'=>0
            ],

            [
                'name'=>'客户案列一',
                'parent_id'=>2
            ],
            [
                'name'=>'客户案列一',
                'parent_id'=>3
            ],
            [
                'name'=>'产品介绍',
                'parent_id'=>0
            ],

            [
                'name'=>'产品介绍一',
                'parent_id'=>5
            ],
            [
                'name'=>'产品介绍一',
                'parent_id'=>6
            ]
        ]);
    }
}
