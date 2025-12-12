<?php
// File: class/Form.php
class Form
{
    private $fields = array();
    private $action;
    private $submit = "Submit Form";
    private $jumField = 0;

    public function __construct($action, $submit)
    {
        $this->action = $action;
        $this->submit = $submit;
    }
    
    // Method baru: Menetapkan nilai field
    public function setFieldValue($name, $value)
    {
        foreach ($this->fields as $key => $field) {
            if ($field['name'] === $name) {
                $this->fields[$key]['value'] = $value;
                return;
            }
        }
    }

    public function displayForm()
    {
        echo "<form action='" . htmlspecialchars($this->action) . "' method='POST'>";
        echo '<table width="100%" border="0">';
        
        foreach ($this->fields as $field) {
            $name = htmlspecialchars($field['name']);
            $label = htmlspecialchars($field['label']);
            $type = $field['type'];
            // Nilai saat ini (jika ada, default kosong)
            $current_value = $field['value'] ?? ''; 
            
            echo "<tr><td align='right' valign='top'>" . $label . 
            "</td>";
            echo "<td>";
            
            switch ($type) {
                case 'textarea':
                    echo "<textarea name='" . $name . "' cols='30' 
                    rows='4'>" . htmlspecialchars($current_value) . "</textarea>";
                    break;
                case 'select':
                    echo "<select name='" . $name . "'>";
                    foreach ($field['options'] as $value => $label) {
                        $selected = ($current_value == $value) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($value) . "' $selected>" . htmlspecialchars($label) . 
                        "</option>";
                    }
                    echo "</select>";
                    break;
                case 'radio':
                    foreach ($field['options'] as $value => $label) {
                        $checked = ($current_value == $value) ? 'checked' : '';
                        echo "<label><input type='radio' name='" . $name . "' value='" . htmlspecialchars($value) . "' $checked> " . htmlspecialchars($label) . "</label> ";
                    }
                    break;
                case 'checkbox':
                    // Untuk checkbox group, nilai saat ini mungkin berupa array atau string
                    $current_values = is_array($current_value) ? $current_value : explode(',', $current_value);
                    foreach ($field['options'] as $value => $label) {
                        // Periksa apakah value ada di array current_values
                        $checked = in_array($value, $current_values) ? 'checked' : '';
                        // Untuk checkbox group, nama field ditambah []
                        echo "<label><input type='checkbox' name='" . $name . "[]' value='" . htmlspecialchars($value) . "' $checked> " . htmlspecialchars($label) . "</label> ";
                    }
                    break;
                case 'password':
                    // Password tidak perlu diisi ulang untuk keamanan
                    echo "<input type='password' name='" . $name . "'>";
                    break;
                default: // Defaultnya adalah text input biasa
                    echo "<input type='text' name='" . $name . "' value='" . htmlspecialchars($current_value) . "'>";
                    break;
            }
            echo "</td></tr>";
        }
        
        echo "<tr><td colspan='2'>";
        echo "<input type='submit' value='" . htmlspecialchars($this->submit) . "'></td></tr>";
        echo "</table>";
        echo "</form>";
    }

    /**
    * addField
    * @param string $name Nama atribut (name="")
    * @param string $label Label untuk field
    * @param string $type Tipe input (text, textarea, select, radio, checkbox, 
    password)
    * @param array $options Opsi untuk select/radio/checkbox (format: 
    ['value' => 'Label'])
    */
    public function addField($name, $label, $type = "text", $options = 
    array())
    {
        $this->fields[$this->jumField]['name'] = $name;
        $this->fields[$this->jumField]['label'] = $label;
        $this->fields[$this->jumField]['type'] = $type;
        $this->fields[$this->jumField]['options'] = $options;
        // Inisialisasi nilai awal
        $this->fields[$this->jumField]['value'] = ''; 
        $this->jumField++;
    }
}
?>
