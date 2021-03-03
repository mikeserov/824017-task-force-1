<?php

declare(strict_types = 1);

namespace TaskForce\controllers;

class AccomplishAction extends AbstractAction {
	
	public function __construct()
	{
		$this->internalActionName = Task::TO_ACCOMPLISH;
		$this->displayingActionName = 'Выполнено';
	}

	public function getInternalActionName()
	{
		return $this->internalActionName;
	}
	public function getDisplayingActionName()
	{
		return $this->displayingActionName;
	}
	public function canUserAct(int $customerId, int $executantId, int $currentUserId, ?string $currentUserRole): bool
	{
		return $currentUserId === $customerId ? true : false;
	}
}