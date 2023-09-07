<?php

/**
 * @package   Astroid Framework
 * @author    Astroid Framework Team https://astroidframe.work
 * @copyright Copyright (C) 2023 AstroidFrame.work.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

// The class name must always be the same as the filename (in camel case)
class JFormFieldAstroidsassoverrides extends JFormField {

//The field class must know its own type through the variable $type.
   protected $type = 'astroidsassoverrides';

   public function getLabel() {
      return false;
   }

   public function getInput() {
       $json =   [
           'id'      =>  $this->id,
           'name'    =>  $this->name,
           'type'    =>  strtolower($this->type),
       ];
       return json_encode($json);
//      $renderer = new JLayoutFile('fields.astroidsassoverrides', JPATH_LIBRARIES . '/astroid/framework/layouts');
//      return $renderer->render($this->getLayoutData());
   }

}
