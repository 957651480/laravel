<?php


namespace App\Ui\Form;


use Illuminate\Database\Eloquent\Model;

class Form
{
    /**
     * @var $model Model
     */
    protected $model;

    /**
     * The form validator.
     *
     * @var null|string
     */
    protected $validator = null;

    /**
     * @return string|null
     */
    public function getValidator(): ?string
    {
        return $this->validator;
    }

    /**
     * @param string|null $validator
     */
    public function setValidator(?string $validator): void
    {
        $this->validator = $validator;
    }


    /**
     * Form constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }


}