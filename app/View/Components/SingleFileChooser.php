<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SingleFileChooser extends Component
{
    public $label;
    public $fieldName;
    public $placeholderTitle;
    public $placeholderText;
    public $maxFileSize;
    public $required;
    public $acceptHint;
    public $accept;
    public $errors;
    public $filePath;
    public $uploadPath;
    public $type;
    public $uitype;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $label,
        $fieldName,
        $placeholderTitle = "Drop a file here or click to upload.",
        $filePath = null,
        $placeholderText = null,
        $maxFileSize = "2MB",
        $required = false,
        $acceptHint = null,
        $accept="*/*",
        $errors=null,
        $uploadPath = "",
        $type = "image",
        $uitype = "horizontal"
    )
    {
        $this->label = $label;
        $this->placeholderTitle = $placeholderTitle;
        $this->fieldName = $fieldName;
        $this->filePath = $filePath;
        $this->placeholderText = $placeholderText;
        $this->maxFileSize = $maxFileSize;
        $this->acceptHint = $acceptHint;
        $this->accept = $accept;
        $this->required = $required;
        $this->errors = empty($errors) ? null : $errors;
        $this->uploadPath = $uploadPath;
        $this->type = $type;
        $this->uitype = $uitype;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.single-file-chooser');
    }
}
