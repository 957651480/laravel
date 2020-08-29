<?php


namespace App\Ui\Form;


use Illuminate\Foundation\Bus\DispatchesJobs;

class FormBuilder
{
    use DispatchesJobs;

    protected $ajax=false;

    /**
     * The entry object.
     *
     * @var null|int
     */
    protected $entry = null;


    /**
     * @var Form
     */
    protected $form;

    /**
     * FormBuilder constructor.
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Build the form.
     *
     * @param  null $entry
     * @return $this
     */
    public function build($entry = null)
    {
        if ($entry) {
            $this->entry = $entry;
        }

        $this->fire('ready', ['builder' => $this]);

        $this->dispatchNow(new BuildForm($this));

        $this->fire('built', ['builder' => $this]);

        return $this;
    }

    /**
     * Make the form.
     *
     * @param  null $entry
     * @return $this
     */
    public function make($entry = null)
    {
        $this->build($entry);
        $this->post();

        $this->fire('make', ['builder' => $this]);

        if ($this->getFormResponse() === null) {
            $this->dispatchNow(new LoadForm($this));
            $this->dispatchNow(new MakeForm($this));
        }

        return $this;
    }

    /**
     * Render the form.
     *
     * @param  null $entry
     * @return Response
     */
    public function render($entry = null)
    {
        $this->make($entry);

        if (!$this->form->getResponse()) {
            $this->dispatchNow(new SetFormResponse($this));
        }

        return $this->form->getResponse();
    }
}