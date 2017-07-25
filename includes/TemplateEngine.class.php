<?php

class TemplateEngine {
	public static function generateFormInput($name, $type, $label, $required=false, $input_extra=null) {
	        $required_text = "";
	        if ($required) {
	                $required_text = " required";
	        }
	?>
	<div class="form-group">
	        <label class="col-sm-4 x control-label" for="<?php echo($name); ?>"><?php echo($label); ?></label>
	        <div class="col-sm-8">
	<?php
	        if (strcmp($type, "radio") && strcmp($type, "select")) {
	                echo('<input class="form-control" type="'.$type.'" name="'.$name.'"');
	                if ($input_extra != null) {
	                        if (!strcmp($type, "password")) {
	                                echo(' placeholder="'.$input_extra.'"');
	                        }
	                        if (!strcmp($type, "number")) {
	                                echo(' min='.$input_extra);
	                        }
	                }
	                echo($required_text." />");
	        } else if (!strcmp($type, "radio")) {
	                foreach ($input_extra as $option) {
	?>
	                <input id="<?php echo($type.$name.$option); ?>" type="radio" name="<?php echo($name); ?>" value="<?php echo($option); ?>"<?php echo($required_text); ?>>
	                        <label for="<?php echo($type.$name.$option); ?>">
	<?php
	                        echo($option);
	                        if (!strcmp($option, "other")) {
	?>
	                                <input class="form-control" type="text" name="<?php echo($name); ?>_other"/>
	<?php
	                        }
	?>
	                        </label>
	                </input><br/>
	<?php
	                }
	        } else if (!strcmp($type, "select")) {
	?>
	                <select class="form-control" name="<?php echo($name); ?>">
	<?php
	                foreach ($input_extra as $option) {
	                        echo('<option value="'.$option.'">'.$option.'</option>');
	                }
	?>
	                </select>
	<?php
	        }
	?>
	        </div>
	</div>
	<?php
	}
	
	public static function generateFormSubmit($btn_text=null) {
	?>
	<div class="form-group">
	        <label class="col-sm-4 x control-label"> </label>
	        <div class="col-sm-8">
	                <input type="submit" <?php if ($btn_text != null) echo('value="'.$btn_text.'"'); ?>/>
	        </div>
	</div>
	<?php
	}
}
