<?php

declare(strict_types = 1);

namespace TaskForce\controllers;

class ExecuteAction extends AbstractAction {
	
	public function __construct()
	{
		$this->internalActionName = Task::TO_EXECUTE;
		$this->displayingActionName = 'Откликнуться';
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
		return $currentUserRole === 'executant' && $currentUserId !== $customerId ? true : false;
	}
}