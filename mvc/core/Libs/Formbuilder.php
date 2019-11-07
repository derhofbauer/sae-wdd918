<?php

namespace Core\Libs;

/**
 * Der Formbuilder wird von uns als externe Abhängigkeit betrachtet, daher kommentiere ich ihn nicht. Die Verwendung
 * kann in den Controllern beispielhaft nachgelesen werden.
 */
class Formbuilder
{
    private $markup = [];
    private $columns;
    private $columns_grid;

    public function __construct ($name, $action = "", $method = "POST", $enctype = false, $columns = 1)
    {
        $this->columns = $columns;
        $this->columns_grid = 12 / $columns;

        $this->markup[] = "<form method=\"$method\" action=\"$action\" id=\"f-$name\"";

        $this->markup[] = ($enctype) ? " enctype=\"multipart/form-data\">" : ">";

        $csrf = set_csrf();
        $this->markup[] = "<input type=\"hidden\" value=\"$csrf\" name=\"csrf\">";

        $this->markup[] = "<div class=\"row\">"; // bootstrap row

    }

    public function addInput ($type = "text", $name = "", $label = false, $attr = [], $column_width = null)
    {
        // ['class' => 'myform', 'placeholder' => 'Mein Wert', 'value' => 'Jetzt absenden']

        $bootstrap_columns = ($column_width !== null) ? $column_width : $this->columns_grid;

        $this->markup[] = "<div class=\"form-group col-sm-{$bootstrap_columns}\">";

        if ($label !== false) $this->markup[] = "<label for=\"$name\">$label</label>";

        $this->markup[] = "<input type=\"$type\" name=\"$name\" id=\"$name\"";

        $class = (isset($attr['class'])) ? "form-control {$attr['class']}" : "form-control";
        $this->markup[] = " class=\"$class\"";

        if (count($attr) > 0) {

            foreach ($attr as $key => $val):
                if ($key == "class") continue;
                $this->markup[] = " $key=\"$val\"";
            endforeach;
        }

        $this->markup[] = ">"; // input end
        $this->markup[] = "</div>"; // form-group end

        return $this;
    }

    public function addButton ($name, $value, $attr = [], $column_width = null)
    {
        $bootstrap_columns = ($column_width !== null) ? $column_width : $this->columns_grid;
        $this->markup[] = "<div class=\"form-group col-sm-{$bootstrap_columns}\">";

        $this->markup[] = "<button name=\"$name\" id=\"$name\"";

        $class = (isset($attr['class'])) ? "btn btn-primary {$attr['class']}" : "btn btn-primary";
        $this->markup[] = " class=\"$class\"";

        if (count($attr) > 0) {

            foreach ($attr as $key => $val):
                if ($key == "class") continue;
                $this->markup[] = " $key=\"$val\"";
            endforeach;
        }

        $this->markup[] = ">$value</button>";
        $this->markup[] = "</div>"; // form-group end

        return $this;
    }

    public function addSelect ($name = "", $label = false, $options = [], $selected = null, $attr = [], $column_width = null)
    {
        $bootstrap_columns = ($column_width !== null) ? $column_width : $this->columns_grid;
        $this->markup[] = "<div class=\"form-group col-sm-{$bootstrap_columns}\">";

        if ($label !== false) $this->markup[] = "<label for=\"$name\">$label</label>";

        $this->markup[] = "<select id=\"$name\" name=\"$name\"";

        $class = (isset($attr['class'])) ? "form-control {$attr['class']}" : "form-control";
        $this->markup[] = " class=\"$class\"";

        if (count($attr) > 0) {

            foreach ($attr as $key => $val):
                if ($key == "class") continue;
                $this->markup[] = " $key=\"$val\"";
            endforeach;
        }

        $this->markup[] = ">";

        foreach ($options as $key => $val):
            if ($selected !== null && $selected == $key) {
                $this->markup[] = "<option value=\"$key\" selected>$val</option>";
            } else {
                $this->markup[] = "<option value=\"$key\">$val</option>";
            }
        endforeach;

        $this->markup[] = "</select>";
        $this->markup[] = "</div>"; // form-group end

        return $this;
    }

    public function addTextarea ($name = "", $label = false, $value = "", $attr = [], $column_width = null)
    {
        $bootstrap_columns = ($column_width !== null) ? $column_width : $this->columns_grid;
        $this->markup[] = "<div class=\"form-group col-sm-{$bootstrap_columns}\">";

        if ($label !== false) $this->markup[] = "<label for=\"$name\">$label</label>";

        $this->markup[] = "<textarea name=\"$name\" id=\"$name\"";

        $class = (isset($attr['class'])) ? "form-control {$attr['class']}" : "form-control";
        $this->markup[] = " class=\"$class\"";

        if (count($attr) > 0) {

            foreach ($attr as $key => $val):
                if ($key == "class") continue;
                $this->markup[] = " $key=\"$val\"";
            endforeach;
        }

        $this->markup[] = ">$value</textarea>";

        $this->markup[] = "</div>"; // form-group end

        return $this;
    }

    public function addRadioGroup ($name = "", $data = [], $inline = false)
    {
        $this->markup[] = "<div class=\"col-sm-12\">";

        $counter = 1;

        foreach ($data as $key => $val):
            $class = ($inline) ? "form-check form-check-inline" : "form-check";

            $this->markup[] = "<div class=\"$class\">";
            $this->markup[] = "<input class=\"form-check-input\" id=\"$name-$counter\" type=\"radio\" name=\"$name\" value=\"$key\">";
            $this->markup[] = "<label for=\"$name-$counter\" class=\"form-check-label\">$val</label>";
            $this->markup[] = "</div>";

            $counter++;
        endforeach;

        $this->markup[] = "</div>"; // col-sm end

        return $this;
    }

    public function addCheckboxGroup ($data = [], $inline = false)
    {
        $this->markup[] = "<div class=\"col-sm-12\">";

        $counter = 1;

        foreach ($data as $key => $val):
            $class = ($inline) ? "form-check form-check-inline" : "form-check";

            $this->markup[] = "<div class=\"$class\">";
            $this->markup[] = "<input class=\"form-check-input\" id=\"$key\" type=\"checkbox\" name=\"$key\" value=\"$key\">";
            $this->markup[] = "<label for=\"$key\" class=\"form-check-label\">$val</label>";
            $this->markup[] = "</div>";

            $counter++;
        endforeach;

        $this->markup[] = "</div>"; // col-sm end

        return $this;
    }

    public function output ()
    {
        $this->markup[] = "</div>"; // bootstrap row end
        $this->markup[] = "</form>"; // form end

        return implode('', $this->markup);
    }
}
