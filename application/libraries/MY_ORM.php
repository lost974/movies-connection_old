<?php

class ORM extends ORM_Core 
{
   
	// FUNC: Ajoute la gestion des champs created et updated à la méthode save()
	public function save() 
	{
		if ($this->id == 0 and isset($this->created))
			$this->created = time();
		if ($this->id > 0 and isset($this->updated))
			$this->updated = time();
		parent::save();
	}
}
