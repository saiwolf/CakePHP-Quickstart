<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
// the Text class
use Cake\Utility\Text;

// Import the Validator class
use Cake\Validation\Validator;

class ArticlesTable extends Table
{
  public function initialize(array $config)
  {
    $this->addBehavior('Timestamp');
    $this->belongsToMany('Tags');
  }
  
  public function beforeSave($event, $entity, $options)
  {
    if ($entity->isNew() && !$entity->slug) {
      $sluggedTitle = Text::slug($entity->title);
      // trim slug to maximum length defined in schema
      $entity->slug = substr($sluggedTitle, 0, 191);
      
    }
  }
  
  // Our validation method
  public function validationDefault(Validator $validator)
  {
    $validator
      ->notEmpty('title')
      ->minLength('title', 10)
      ->maxLength('title', 255)
      ->notEmpty('body')
      ->minLength('body', 10);
    
    return $validator;
  }
  
}
?>