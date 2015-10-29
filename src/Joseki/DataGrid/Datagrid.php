<?php

namespace Joseki\DataGrid;

use Joseki\Forms\BootstrapRenderer;
use Joseki\Forms\Form;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Forms\Controls\BaseControl;
use Nette\Localization\ITranslator;
use Nette\Utils\Callback;

class DataGrid extends Control
{

    /** @var  @persistent */
    public $filter = array();

    /** @var  @persistent */
    public $lastKey;

    /** @var  @persistent */
    public $orderByColumn;

    /** @var  array */
    protected $filterDefaults;

    private $dataCallback;

    /** @var  ITranslator */
    private $translator;

    /** @var Columns\Column[] */
    private $columns = [];

    /** @var Link[] */
    private $links = [];

    private $itemsPerLoad = 10;

    private $data;

    /** @var callback */
    private $filterFormFactory;



    /**
     * @return int
     */
    public function getItemsPerLoad()
    {
        return $this->itemsPerLoad;
    }



    /**
     * @param int $itemsPerLoad
     */
    public function setItemsPerLoad($itemsPerLoad)
    {
        $this->itemsPerLoad = $itemsPerLoad;
    }



    /**
     * @return mixed
     */
    public function getOrderByColumn()
    {
        return $this->orderByColumn;
    }



    /**
     * @param mixed $orderByColumn
     */
    public function setOrderByColumn($orderByColumn)
    {
        $this->orderByColumn = $orderByColumn;
    }



    /**
     * @return ITranslator
     */
    public function getTranslator()
    {
        return $this->translator;
    }



    /**
     * @param ITranslator $translator
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;
    }



    /**
     * @return Columns\Column[]
     */
    public function getColumns()
    {
        return $this->columns;
    }



    /**
     * @return mixed
     */
    public function getDataCallback()
    {
        return $this->dataCallback;
    }



    /**
     * @param mixed $dataCallback
     */
    public function setDataCallback($dataCallback)
    {
        $this->dataCallback = $dataCallback;
    }


    /************************* CONTROLS **************************/

    /**
     * @param $name
     * @param $label
     * @return Columns\TextColumn
     */
    public function addTextColumn($name, $label)
    {
        $this->columns[$name] = new Columns\TextColumn($name, $label);
        return $this->columns[$name];
    }



    /**
     * @param $name
     * @param $label
     * @return Columns\NumericColumn
     */
    public function addNumericColumn($name, $label)
    {
        $this->columns[$name] = new Columns\NumericColumn($name, $label);
        return $this->columns[$name];
    }



    /**
     * @param $name
     * @param $label
     * @return Columns\DateTimeColumn
     */
    public function addDateTimeColumn($name, $label)
    {
        $this->columns[$name] = new Columns\DateTimeColumn($name, $label);
        return $this->columns[$name];
    }



    public function addLink($link, $label)
    {
        $this->links[] = $link = new Link($link, $label);
        return $link;
    }



    /************************* RENDER **************************/

    public function render()
    {
        $template = $this->createTemplate();
        $template->setFile($template->layout);
        $template->render();
    }



    /**
     * @return \Nette\Application\UI\ITemplate|Template
     */
    protected function createTemplate()
    {
        $template = parent::createTemplate();

        $print = (string)$this['form'];

        $template->layout = __DIR__ . "/layout.latte";

        $template->columns = $this->columns;
        $template->links = $this->links;
        $template->data = $this->getData();

        if ($this->filterFormFactory) {
            $this['form']['filter']->setDefaults($this->filter);
        }

        return $template;
    }



    protected function createComponentForm()
    {
        $form = new Form;
        if ($this->filterFormFactory) {
            $form['filter'] = Callback::invoke($this->filterFormFactory);
            if (!isset($form['filter']['filter'])) {
                $form['filter']->addSubmit('filter', 'Filter');
            }
            if (!isset($form['filter']['cancel'])) {
                $form['filter']->addSubmit('cancel', 'Cancel');
            }
            $this->filterDefaults = array();

            /**  @var BaseControl $control */
            foreach ($form['filter']->controls as $name => $control) {
                $this->filterDefaults[$name] = $control->getValue();
            }
        }
//        if ($this->editFormFactory && ($this->editRowKey !== null || !empty($_POST['edit']))) {
//            $data = $this->editRowKey !== null && empty($_POST) ? $this->getData($this->editRowKey) : null;
//            $form['edit'] = Callback::invokeArgs($this->editFormFactory, array($data));
//            if (!isset($form['edit']['save'])) {
//                $form['edit']->addSubmit('save', 'Save');
//            }
//            if (!isset($form['edit']['cancel'])) {
//                $form['edit']->addSubmit('cancel', 'Cancel');
//            }
//            if (!isset($form['edit'][$this->rowPrimaryKey])) {
//                $form['edit']->addHidden($this->rowPrimaryKey);
//            }
//            $form['edit'][$this->rowPrimaryKey]
//                ->setDefaultValue($this->editRowKey)
//                ->setOption('rendered', true);
//        }
        if ($this->translator) {
            $form->setTranslator($this->translator);
        }
        $form->onSuccess[] = function () {
        }; // fix for Nette Framework 2.0.x
        $form->onSubmit[] = $this->processForm;
        $form->setRenderer(new BootstrapRenderer);
        return $form;
    }



    public function processForm(Form $form)
    {
//        if (isset($form['edit'])) {
//            if ($form['edit']['save']->isSubmittedBy()) {
//                if ($form['edit']->isValid()) {
//                    Callback::invokeArgs(
//                        $this->editFormCallback,
//                        array(
//                            $form['edit']
//                        )
//                    );
//                } else {
//                    $this->editRowKey = $form['edit'][$this->rowPrimaryKey]->getValue();
//                    $allowRedirect = false;
//                }
//            }
//            if ($form['edit']['cancel']->isSubmittedBy() || ($form['edit']['save']->isSubmittedBy() && $form['edit']->isValid())) {
//                $editRowKey = $form['edit'][$this->rowPrimaryKey]->getValue();
//                $this->invalidateRow($editRowKey);
//                $this->getData($editRowKey);
//            }
//            if ($this->editRowKey !== null) {
//                $this->invalidateRow($this->editRowKey);
//            }
//        }
        if (isset($form['filter'])) {
            if ($form['filter']['filter']->isSubmittedBy()) {
                $values = $form['filter']->getValues(true);
                unset($values['filter']);
//                if ($this->paginator) {
//                    $this->page = $this->paginator->page = 1;
//                }
                $this->filter = $this->filterFilterRules($values);
                $this->redrawControl('rows');
            } elseif ($form['filter']['cancel']->isSubmittedBy()) {
//                if ($this->paginator) {
//                    $this->page = $this->paginator->page = 1;
//                }
                $this->filter = $this->filterFilterRules($this->filterDefaults);
                $form['filter']->setValues($this->filter, true);
                $this->redrawControl('rows');
            }
        }
        $this->redrawControl('rows');
        if (!$this->presenter->isAjax()) {
            $this->redirect('this');
        }
    }



    /************************** DATA ***************************/

    protected function getData()
    {
        if ($this->dataCallback) {
            $this->data = Callback::invokeArgs($this->dataCallback, [$this->filter, $this->orderByColumn, $this->lastKey]);
        }
        return is_array($this->data) ? $this->data : [];
    }



    /************************** FILTERING ***************************/

    public function setFilterFormFactory($filterFormFactory)
    {
        Callback::check($filterFormFactory);
        $this->filterFormFactory = $filterFormFactory;
    }



    public function getFilterFormFactory()
    {
        return $this->filterFormFactory;
    }



    private function filterFilterRules(array $rules)
    {
        $filter = array();
        foreach ($rules as $key => $value) {
            if (is_string($value) && strlen($value) === 0) {
                continue;
            }
            if ($value !== null) {
                $filter[$key] = $value;
            }
        }
        return $filter;
    }
}
