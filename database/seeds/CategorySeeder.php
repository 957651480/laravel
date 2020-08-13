<?php

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
               'name'=>'产品',
               'parent_id'=>0
           ],
            [
                'name'=>'产品一级',
                'parent_id'=>1
            ],

            [
                'name'=>'产品二级',
                'parent_id'=>2
            ]
        ]);
    }
}
