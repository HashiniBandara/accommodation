<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MultipleFileChooser extends Component
{

    public $label;
    public $fieldName;
    public $filePathText;
    public $placeholderTitle;
    public $placeholderText;
    public $maxFileSize;
    public $maximumFileCount;
    public $minimumFileCount;
    public $acceptHint;
    public $accept;
    public $errors;
    public $filePaths = [];
    public $uploadPath;
    public $required;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $label,
        $fieldName,
        $placeholderTitle = "Drop files here or click to upload.",
        $filePathText = "",
        $placeholderText = null,
        $maxFileSize = "2MB",
        $maximumFileCount = null,
        $minimumFileCount = null,
        $acceptHint = null,
        $accept="*/*",
        $errors=null,
        $uploadPath = "",
        $required = false
    )
    {
        $this->label = $label;
        $this->placeholderTitle = $placeholderTitle;
        $this->fieldName = $fieldName;
        $this->filePathText = $filePathText;
        $this->placeholderText = $placeholderText;
        $this->maxFileSize = $maxFileSize;
        $this->maximumFileCount = $maximumFileCount;
        $this->minimumFileCount = $minimumFileCount;
        $this->acceptHint = $acceptHint;
        $this->accept = $accept;
        $this->errors = empty($errors) ? null : $errors;
        $this->uploadPath = $uploadPath;
        $this->filePaths = $filePathText ?: [];
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.multiple-file-chooser');
    }
}
