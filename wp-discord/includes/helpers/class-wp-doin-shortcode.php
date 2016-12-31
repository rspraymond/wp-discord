<?php

class WP_Doin_Shortcode
{
    public $fields = array();
    public $id ='';
    public $name = '';
    public $description = '';

    /**
     * Make sure each field is stored as a separate entity with unique variables passed
     *
     * @param string $id
     * @param string $name
     * @param string $description
     */
    public function __construct($id, $name, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * Add a field to the object
     *
     * @param string $type
     * @param string $name
     * @param string $heading
     * @param string $description
     * @param array $values
     * @return \WP_Doin_Shortcode
     */
    public function add_field($type, $name, $heading = '', $description = '', $values = [ ])
    {
        $this->fields[$name] = array( 'type' => $type, 'heading' => $heading, 'description' => $description, 'values' => $values );
        return $this;
    }

    /**
     * Iterate over the stored fields and generate their corresponding markup
     */
    public function generate_fields()
    {
        foreach ($this->fields as $key => $field) {
            switch ($field['type']) {
                case 'col':
                    $this->generate_col($field['heading']);
                    break;
                case 'text':
                    $this->generate_text($key, $field['heading'], $field['description']);
                    break;
                case 'textarea':
                    $this->generate_textarea($key, $field['heading'], $field['description']);
                    break;
                case 'checkbox':
                    $this->generate_checkbox($key, $field['heading'], $field['description'], $field['values']);
                    break;
                case 'select':
                    $this->generate_select($key, $field['heading'], $field['description'], $field['values']);
                    break;
                default:
                    $this->generate_text($key, $field['heading'], $field['description']);
                    break;
            }
        }
    }

    /**
     * Generate the 1/3 column markup for the TinyMCE popup
     *
     * @param string $type either start or any (usually end :P)
     */
    public function generate_col($type)
    {
        if ($type === 'start'):
            ?>
			<div class="columns-3"> 
			<?php else: ?>
			</div>
		<?php
        endif;
    }

    public function generate_text($key, $heading, $description)
    {
        ?>
		<div class="field-container <?php echo $key; ?>">
			<div class="label-desc">
				<label for="<?php echo $heading; ?>"><?php echo $heading; ?></label>
			</div>
			<div class="content">
				<input type="text" id="<?php echo $key; ?>"/>
				<?php if (!empty($description)): ?>
					<p><?php echo $description; ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php

    }

    public function generate_textarea($key, $heading, $description)
    {
        ?>
		<div class="field-container <?php echo $key; ?>">
			<div class="label-desc">
				<label for="<?php echo $heading; ?>"><?php echo $heading; ?></label>
			</div>
			<div class="content">
				<textarea id="<?php echo $key; ?>"/></textarea>
				<?php if (!empty($description)): ?>
					<p><?php echo $description; ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php

    }

    public function generate_select($key, $heading, $description, $values)
    {
        ?>
		<div class="field-container <?php echo $key; ?>">
			<div class="label-desc">
				<label for="<?php echo $heading; ?>"><?php echo $heading; ?></label>
			</div>
			<div class="content">
				<select id="<?php echo $key; ?>">
					<?php foreach ($values as $key => $value): ?>
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php endforeach; ?>
				</select>
				<?php if (!empty($description)): ?>
					<p><?php echo $description; ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php

    }

    public function generate_checkbox($key, $heading, $description, $values)
    {
        ?>
		<div class="field-container <?php echo $key; ?>">
			<div class="label-desc">
				<label for="<?php echo $heading; ?>"><?php echo $heading; ?></label>
			</div>
			<div class="content">
				<?php foreach ($values as $key => $value):
                    ?>
					<input type="checkbox" id="<?php echo $key; ?>" />
					<?php if (!empty($value)): ?>
						<p><?php echo $value; ?></p>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php if (!empty($description)): ?>
					<p><?php echo $description; ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php

    }
}
