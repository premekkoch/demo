<?php declare(strict_types = 1);

/**
 * This file is part of the Nextras\Orm library.
 * @license    MIT
 * @link       https://github.com/nextras/orm
 */

namespace Nextras\Orm\Relationships;

use Nextras\Orm\Collection\ICollection;


class ManyHasOne extends HasOne
{
	protected function createCollection(): ICollection
	{
		$collection = $this->getTargetRepository()->getMapper()->createCollectionManyHasOne($this->metadata);
		return $collection->setRelationshipParent($this->parent);
	}


	protected function modify()
	{
		$this->isModified = true;
		$this->parent->setAsModified($this->metadata->name);
	}


	protected function updateRelationship($oldEntity, $newEntity, bool $allowNull)
	{
		$key = $this->metadata->relationship->property;
		if (!$key) {
			return;
		}

		$this->updatingReverseRelationship = true;
		if ($oldEntity) {
			$oldEntity->getValue($key)->remove($this->parent);
		}

		if ($newEntity) {
			$newEntity->getValue($key)->add($this->parent);
		}
		$this->updatingReverseRelationship = false;
	}


	protected function initReverseRelationship($entity)
	{
		$key = $this->metadata->relationship->property;
		if (!$key || !$entity) {
			return;
		}

		$this->updatingReverseRelationship = true;
		$entity->getValue($key)->trackEntity($this->parent);
		$this->updatingReverseRelationship = false;
	}
}
